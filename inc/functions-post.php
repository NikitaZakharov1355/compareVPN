<?php

function add_social_fields_to_user_profile($user)
{
?>
    <h3><?php esc_html_e('Social Media Links', 'text-domain'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="facebook"><?php esc_html_e('Facebook', 'text-domain'); ?></label></th>
            <td>
                <input type="url" name="facebook" id="facebook" value="<?php echo esc_attr(get_the_author_meta('facebook', $user->ID)); ?>" class="regular-text" />
                <p class="description"><?php esc_html_e('Enter your Facebook profile URL.', 'text-domain'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="twitter"><?php esc_html_e('Twitter', 'text-domain'); ?></label></th>
            <td>
                <input type="url" name="twitter" id="twitter" value="<?php echo esc_attr(get_the_author_meta('twitter', $user->ID)); ?>" class="regular-text" />
                <p class="description"><?php esc_html_e('Enter your Twitter profile URL.', 'text-domain'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="instagram"><?php esc_html_e('Instagram', 'text-domain'); ?></label></th>
            <td>
                <input type="url" name="instagram" id="instagram" value="<?php echo esc_attr(get_the_author_meta('instagram', $user->ID)); ?>" class="regular-text" />
                <p class="description"><?php esc_html_e('Enter your Instagram profile URL.', 'text-domain'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="linkedin"><?php esc_html_e('LinkedIn', 'text-domain'); ?></label></th>
            <td>
                <input type="url" name="linkedin" id="linkedin" value="<?php echo esc_attr(get_the_author_meta('linkedin', $user->ID)); ?>" class="regular-text" />
                <p class="description"><?php esc_html_e('Enter your LinkedIn profile URL.', 'text-domain'); ?></p>
            </td>
        </tr>
    </table>
<?php
}
add_action('show_user_profile', 'add_social_fields_to_user_profile');
add_action('edit_user_profile', 'add_social_fields_to_user_profile');

function save_social_fields_to_user_meta($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    update_user_meta($user_id, 'facebook', sanitize_text_field($_POST['facebook']));
    update_user_meta($user_id, 'twitter', sanitize_text_field($_POST['twitter']));
    update_user_meta($user_id, 'instagram', sanitize_text_field($_POST['instagram']));
    update_user_meta($user_id, 'linkedin', sanitize_text_field($_POST['linkedin']));
}
add_action('personal_options_update', 'save_social_fields_to_user_meta');
add_action('edit_user_profile_update', 'save_social_fields_to_user_meta');


// rate articles
function start_session() {
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'start_session', 1);

function vpn_rating_ajax_handler()
{
    // check_ajax_referer('vpn_rating_nonce', 'nonce');

    $post_id = absint($_POST['post_id']);
    $rating = absint($_POST['rating']);
    $user_id = get_current_user_id();

    if (!$post_id || !$rating || $rating < 1 || $rating > 5) {
        wp_send_json_error(['message' => 'Invalid request.']);
    }

    // Check if the user has already rated
    if ($user_id) {
        $user_rating_key = 'user_rating_' . $post_id;
        $user_rated = get_user_meta($user_id, $user_rating_key, true);

        if ($user_rated) {
            wp_send_json_error(['message' => 'You have already rated this post.']);
        }

        // Save user rating
        update_user_meta($user_id, $user_rating_key, $rating);
    } else {
        // Handle anonymous users
        $session_key = 'rated_' . $post_id;
        if (isset($_SESSION[$session_key])) {
            wp_send_json_error(['message' => 'You have already rated this post.']);
        }
        $_SESSION[$session_key] = $rating;
    }

    // Update post meta for overall rating
    $current_rating = get_post_meta($post_id, 'rating', true) ?: 0;
    $rating_count = get_post_meta($post_id, 'rating_count', true) ?: 0;

    $new_rating_count = $rating_count + 1;
    $new_rating = ($current_rating * $rating_count + $rating) / $new_rating_count;

    update_post_meta($post_id, 'rating', $new_rating);
    update_post_meta($post_id, 'rating_count', $new_rating_count);

    wp_send_json_success([
        'message' => 'Thanks for your rating!',
        'user_rating' => $rating,
        'new_rating' => $new_rating,
    ]);
}
add_action('wp_ajax_vpn_rating', 'vpn_rating_ajax_handler');
add_action('wp_ajax_nopriv_vpn_rating', 'vpn_rating_ajax_handler');

function get_user_rating_for_post($post_id)
{
    $user_id = get_current_user_id();
    if ($user_id) {
        $user_rating_key = 'user_rating_' . $post_id;
        return get_user_meta($user_id, $user_rating_key, true);
    } elseif (isset($_SESSION['rated_' . $post_id])) {
        return $_SESSION['rated_' . $post_id];
    }
    return null; // No rating found
}

// load more comments

function load_more_comments() {
    // check_ajax_referer('load_more_comments_nonce', 'security');

    $post_id = intval($_POST['post_id']);
    $paged   = intval($_POST['paged']);
    $comments_per_page = get_option('comments_per_page');

    $args = [
        'post_id' => $post_id,
        'status'  => 'approve',
        'number'  => $comments_per_page,
        'offset'  => ($paged - 1) * $comments_per_page,
        // 'callback'   => 'default_comments_callback', // Use the default callback        
    ];

    $comments = get_comments($args);

    if ($comments) {
        foreach ($comments as $comment) {
            echo '<li>';
            wp_list_comments(['callback' => 'default_comments_callback'], [$comment]);
            echo '</li>';
        }
    } else {
        // No more comments
        echo '';
    }

    wp_die();
}
add_action('wp_ajax_load_more_comments', 'load_more_comments');
add_action('wp_ajax_nopriv_load_more_comments', 'load_more_comments');
