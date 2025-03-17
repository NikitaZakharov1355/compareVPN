<?php
function calculate_and_save_average_rating($post_id)
{
    // Ensure this only runs for the specific post type (e.g., 'vpn')
    if (get_post_type($post_id) !== 'vpn') {
        return;
    }

    // Check if the flexible content field exists
    if (have_rows('flexible_content', $post_id)) {
        // Variables to hold the total rating and the count of rows
        $total_rating = 0;
        $row_count = 0;

        while (have_rows('flexible_content', $post_id)) {
            the_row();

            // Check if the current row layout is 'content'
            if (get_row_layout() === 'content') {
                // Get the rating field value
                $rating = get_sub_field('rating');

                // Convert the rating from '9,5' to '9.5'
                $rating = str_replace(',', '.', $rating);

                // Add to total rating if it's numeric
                if (is_numeric($rating)) {
                    $total_rating += (float)$rating;
                    $row_count++;
                }
            }
        }

        // Calculate the average rating
        $average_rating = 0.0;
        if ($row_count > 0) {
            $average_rating = $total_rating / $row_count;
            // Round to one decimal place and ensure it always has one decimal (e.g., 10.0)
            $average_rating = number_format($average_rating, 1, '.', '');
        }

        // Save the average rating to a custom field
        update_post_meta($post_id, 'average_rating', $average_rating);
    } else {
        // Default value if no rows exist
        update_post_meta($post_id, 'average_rating', '0.0');
    }
}

add_action('acf/save_post', 'calculate_and_save_average_rating', 20);


function register_vpn_rating_meta()
{
    register_meta('post', 'rating', [
        'type' => 'number',
        'single' => true,
        'sanitize_callback' => 'floatval',
        'show_in_rest' => true,
    ]);
    register_meta('post', 'rating_count', [
        'type' => 'number',
        'single' => true,
        'sanitize_callback' => 'absint',
        'show_in_rest' => true,
    ]);
    register_meta('post', 'average_rating', [
        'type' => 'number',
        'single' => true,
        // 'sanitize_callback' => 'floatval',
        'show_in_rest' => true,
    ]);
}

// add_action('init', 'register_vpn_rating_meta');

function vpn_add_custom_columns($columns)
{
    $screen = get_current_screen();
    if ($screen && $screen->post_type === 'vpn') {
        $columns['average_rating'] = __('Auto Rating', 'text-domain');
    }

    if ($screen && ($screen->post_type === 'vpn' || $screen->post_type === 'post')) {
        $columns['rating'] = __('User Rating', 'text-domain');
        $columns['rating_count'] = __('User Rating Count', 'text-domain');
        $columns['clear_ratings'] = __('Clear Ratings', 'text-domain');
    }
    return $columns;
}
add_filter('manage_vpn_posts_columns', 'vpn_add_custom_columns');
add_filter('manage_posts_columns', 'vpn_add_custom_columns');

function vpn_populate_custom_columns($column, $post_id)
{
    $screen = get_current_screen();
    if ($screen && ($screen->post_type === 'vpn' || $screen->post_type === 'post')) {
        if ('rating' === $column) {
            $rating = get_post_meta($post_id, 'rating', true) ?: 0;
            echo number_format((float)$rating, 1); // Show rating to 2 decimal places
        }

        if ('rating_count' === $column) {
            $rating_count = get_post_meta($post_id, 'rating_count', true) ?: 0;
            echo absint($rating_count);
        }
    }
    if ($screen && $screen->post_type === 'vpn') {
        if ('average_rating' === $column) {
            $total_rating = get_post_meta($post_id, 'average_rating', true) ?: 0;
            echo number_format((float)$total_rating, 1);
        }
    }

    if ($column === 'clear_ratings') {
        // Add a "Clear Ratings" button
        $clear_url = add_query_arg([
            'action'   => 'clear_vpn_rating',
            'post_id'  => $post_id,
            '_wpnonce' => wp_create_nonce('clear_vpn_rating'),
        ], admin_url('edit.php?post_type=vpn'));

        echo '<a href="' . esc_url($clear_url) . '" class="button button-small">' . __('Clear Ratings', 'text-domain') . '</a>';
    }
}
// add_action('manage_vpn_posts_custom_column', 'vpn_populate_custom_columns', 10, 2);
add_action('manage_posts_custom_column', 'vpn_populate_custom_columns', 10, 2);

function vpn_make_columns_sortable($sortable_columns)
{
    $sortable_columns['average_rating'] = 'average_rating';
    $sortable_columns['rating'] = 'rating';
    $sortable_columns['rating_count'] = 'rating_count';
    return $sortable_columns;
}
add_filter('manage_edit-vpn_sortable_columns', 'vpn_make_columns_sortable');
add_filter('manage_edit-posts_sortable_columns', 'vpn_make_columns_sortable');

function vpn_sort_columns_query($query)
{
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    $orderby = $query->get('orderby');
    if ('rating' === $orderby) {
        $query->set('meta_key', 'rating');
        $query->set('orderby', 'meta_value_num');
    }

    if ('rating_count' === $orderby) {
        $query->set('meta_key', 'rating_count');
        $query->set('orderby', 'meta_value_num');
    }

    if ('average_rating' === $orderby) {
        $query->set('meta_key', 'average_rating');
        $query->set('orderby', 'meta_value_num');
    }
}
add_action('pre_get_posts', 'vpn_sort_columns_query');

// Handle the clear ratings action
function vpn_handle_clear_ratings()
{
    if (!isset($_GET['action']) || $_GET['action'] !== 'clear_vpn_rating') {
        return;
    }

    // Verify the nonce
    if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'clear_vpn_rating')) {
        wp_die(__('Invalid request.', 'text-domain'));
    }

    // Verify the post ID and post type
    $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
    if (!$post_id) {
        wp_die(__('Invalid post ID.', 'text-domain'));
    }

    // Clear the meta fields
    update_post_meta($post_id, 'rating', 0);
    update_post_meta($post_id, 'rating_count', 0);

    // Redirect back to the post list with a success message
    $redirect_url = add_query_arg('cleared', 'true', admin_url('edit.php'));
    wp_redirect($redirect_url);
    exit;
}
add_action('admin_init', 'vpn_handle_clear_ratings');
// Display success notice
function vpn_clear_ratings_notice()
{
    if (isset($_GET['cleared']) && $_GET['cleared'] === 'true') {
        echo '<div class="notice notice-success is-dismissible">
                <p>' . __('Ratings cleared successfully.', 'text-domain') . '</p>
              </div>';
    }
}
add_action('admin_notices', 'vpn_clear_ratings_notice');



// AJAX handler for liking comments
function handle_like_comment()
{
    // Verify nonce for security
    // check_ajax_referer('like_comment_nonce', 'nonce');

    $comment_id = intval($_POST['comment_id']);
    $user_id = get_current_user_id();

    // Check if the user has already liked this comment
    $liked_users = get_comment_meta($comment_id, 'liked_users', true);
    $liked_users = is_array($liked_users) ? $liked_users : [];

    if (!in_array($user_id, $liked_users)) {
        // Increment the like count
        $like_count = get_comment_meta($comment_id, 'like_count', true) ?: 0;
        $like_count++;

        // Update the like count and add the user to the liked list
        update_comment_meta($comment_id, 'like_count', $like_count);
        $liked_users[] = $user_id;
        update_comment_meta($comment_id, 'liked_users', $liked_users);

        // Return the new like count
        wp_send_json_success(array('like_count' => $like_count));
    } else {
        // User has already liked the comment
        wp_send_json_error('You have already liked this comment.');
    }

    wp_die(); // Required to terminate the AJAX request properly
}
add_action('wp_ajax_like_comment', 'handle_like_comment');
add_action('wp_ajax_nopriv_like_comment', 'handle_like_comment'); // Optional for non-logged-in users



// Add title field to the comment form
function custom_comment_form_fields($fields)
{
    $fields['comment_title'] = '<p class="comment-form-title">
        <label for="comment_title">' . __('Title') . '</label>
        <input id="comment_title" name="comment_title" type="text" required />
    </p>';
    return $fields;
}
add_filter('comment_form_default_fields', 'custom_comment_form_fields');

// Add rating stars to the comment form
function custom_comment_form($post_id)
{
    if (get_post_type() === 'vpn') {
?>
        <div class="comment-rating flex justify_sb align_c">
            <label><?php _e('Your Score:'); ?></label>
            <div class="post_main-author-descr-action-rating flex align_c justify_c" data-post-id="<?php echo get_the_ID(); ?>">
                <?php for ($i = 1; $i <= 5; $i++) : ?>
                    <div class="rating-star" data-rating="<?php echo $i; ?>">

                    </div>
                <?php endfor; ?>
            </div>
            <input type="hidden" name="comment_rating" id="comment_rating" value="0">
        </div>
        <div id="rating-feedback"></div>
    <?php
    }
}
add_action('comment_form', 'custom_comment_form');

// Save title and rating when comment is posted
function save_comment_meta_data($comment_id)
{
    if (isset($_POST['comment_title'])) {
        add_comment_meta($comment_id, 'comment_title', sanitize_text_field($_POST['comment_title']));
    }
    if (isset($_POST['comment_rating'])) {
        add_comment_meta($comment_id, 'comment_rating', intval($_POST['comment_rating']));
    }
}
add_action('comment_post', 'save_comment_meta_data');


function default_comments_callback($comment, $args, $depth) {
    $comment_title = get_comment_meta($comment->comment_ID, 'comment_title', true);
    $comment_rating = get_comment_meta($comment->comment_ID, 'comment_rating', true);
    $like_count = get_comment_meta($comment->comment_ID, 'like_count', true) ?: 0;
    $reply_link = get_comment_reply_link(array_merge($args, array(
        'depth'     => $depth,
        'max_depth' => $args['max_depth'],
    )));

    // Check if the current user has already liked the comment
    $liked_users = get_comment_meta($comment->comment_ID, 'liked_users', true);
    $liked_users = is_array($liked_users) ? $liked_users : [];
    $user_id = get_current_user_id();
    $is_active = in_array($user_id, $liked_users) ? 'active' : ''; // Add 'active' class if liked
    ?>
    <li class="comment">
        <div class="comment-body">
            <div class="comment-meta">
                <div class="comment-author">
                    <?php echo get_avatar($comment, 56); ?>
                    <b class="fn"><?php echo get_comment_author_link(); ?></b>
                </div>
                <div class="comment-metadata">
                    <time><?php echo get_comment_date(); ?></time>
                </div>
            </div>

            <div class="comment-head flex justify_sb align_fs">
                <div class="comment-content">
                    <?php if ($comment_title) : ?>
                        <h4 class="comment-title font_im"><?php echo esc_html($comment_title); ?></h4>
                    <?php endif; ?>
                    <?php comment_text(); ?>
                </div>

                <?php if ($comment_rating) : ?>
                    <div class="comment-rating flex align_c font_im">
                        <?php for ($i = 1; $i <= $comment_rating; $i++) : ?>
                            <img class="star-icon flex_auto" src="<?php echo get_template_directory_uri(); ?>/website/dist/images/star-ic.svg" alt="star" style="opacity: <?php echo $i <= $comment_rating ? '1' : '0.3'; ?>;">
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="comment-actions-wrap flex align_c justify_sb">
                <div class="comment-actions flex align_c">
                    <!-- Add the 'active' class if the user has already liked the comment -->
                    <button class="comment-like-button flex_inline align_c <?php echo esc_attr($is_active); ?>" data-comment-id="<?php echo esc_attr($comment->comment_ID); ?>">
                        <?php echo __('Like'); ?>
                    </button>
                    <div class="divider">•</div>
                    <?php echo $reply_link; ?>
                </div>
                <div class="comment-actions-like-counter font_im">
                    <?php echo esc_html($like_count); ?> <?php echo __('liked'); ?>
                </div>
            </div>
        </div>
    </li>
    <?php
}
