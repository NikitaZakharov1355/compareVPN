<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package nordVpn
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function nordvpn_body_classes($classes)
{
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter('body_class', 'nordvpn_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function nordvpn_pingback_header()
{
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'nordvpn_pingback_header');

function custom_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'custom_excerpt_more');

function custom_excerpt_length($length)
{
    return 20; // Change 20 to the desired number of words
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);

function custom_breadcrumbs()
{
    // Settings
    $separator = ' / ';
    $home_title = 'Home';

    // Get the query & post information
    global $post;

    // Breadcrumbs
    echo '<div class="breadcrumbs font_im"><div class="container"><div class="breadcrumbs_nav">';

    // Home
    echo '<p><a href="' . home_url() . '">' . $home_title . '</a>' . $separator;

    if (is_singular('post')) {
        // Posts
        echo '<a href="' . get_permalink(get_option('page_for_posts')) . '?type=post">' . __('Blog', 'textdomain') . '</a>' . $separator;
        echo get_the_title();
    } elseif (is_singular('vpn')) {
        // Custom Post Type: VPN
        echo '<a href="' . get_permalink(get_option('page_for_posts')) . '?type=vpn">' . __('Best VPNs', 'textdomain') . '</a>' . $separator;
        echo get_the_title();
    } elseif (is_singular('coupon')) {
        // Custom Post Type: VPN
        echo '<a href="' . get_permalink(get_option('page_for_posts')) . '?type=coupons">' . __('Coupons', 'textdomain') . '</a>' . $separator;
        echo get_the_title();
    } elseif (is_search()) {
        // Custom Post Type: VPN
        $search_query = get_search_query();
        printf(esc_html__('Search Results for: %s', 'nordvpn'), '<span>' . esc_html($search_query) . '</span>');
    } elseif (is_archive()) {
        // Archives
        if (is_post_type_archive('vpn')) {
            echo __('Best VPNs', 'textdomain');
        } elseif (is_category()) {
            echo single_cat_title('', false);
        } elseif (is_tag()) {
            echo single_tag_title('', false);
        } elseif (is_author()) {
            echo __('Author: ', 'textdomain') . get_the_author();
        } elseif (is_date()) {
            echo get_the_date();
        }
    } elseif (is_home()) {
        // Blog Home
        echo __('Blog', 'textdomain');
    } elseif (is_front_page()) {
        // Front Page
        echo $home_title;
    } elseif (is_404()) {
        // 404 Page
        echo __('Error 404', 'textdomain');
    }

    echo '</p></div></div></div>';
}


// user meta

require 'functions-post.php';

require 'functions-vpn.php';

require 'coupons-vpn.php';

function get_rating($id)
{
    if (get_post_meta($id, 'average_rating', true) && get_post_meta($id, 'average_rating', true) != 0) {
        $rating = round(get_post_meta($id, 'average_rating', true), 1);
    } elseif (get_field('overall_rating', $id)) {
        $rating = get_field('overall_rating', $id);
        $rating = floatval(str_replace(',', '.', $rating));
    } else {
        $rating = 0.0;
    }
    return $rating;
}


function custom_mce_button($buttons)
{
    array_push($buttons, 'custom_button_class');
    return $buttons;
}

function custom_mce_plugin($plugins)
{
    $plugins['custom_button_class'] = get_template_directory_uri() . '/admin/custom-mce-button.js';
    return $plugins;
}

function custom_mce_editor_buttons()
{
    add_filter('mce_buttons', 'custom_mce_button');
    add_filter('mce_external_plugins', 'custom_mce_plugin');
}
add_action('admin_init', 'custom_mce_editor_buttons');


function load_more_posts()
{
    $paged = intval($_POST['page']);
    $search = sanitize_text_field($_POST['search']);
    $tags = isset($_POST['tags']) ? explode(',', $_POST['tags']) : [];
    $types = isset($_POST['types']) ? explode(',', $_POST['types']) : ['post', 'vpn'];

    $args = array(
        'post_type' => $types, // Filter by selected post types
        'paged' => $paged,
        'post_status' => 'publish',
        'has_password' => false,
        'posts_per_page' => 6,
        's' => $search,
    );

    if (!empty($tags)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'post_tag',
                'field' => 'term_id',
                'terms' => $tags,
                'operator' => 'AND',
            ),
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) : $query->the_post();
            get_template_part('template-parts/content', 'search');
        endwhile;
        wp_reset_postdata();
        $posts = ob_get_clean();
        wp_send_json_success(array('posts' => $posts, 'has_posts' => true));
    } else {
        wp_send_json_success(array('message' => __('No posts found', 'nordvpn'), 'has_posts' => false));
    }

    wp_die();
}

add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');



function get_author_social_links()
{
?>
    <?php
    // Retrieve author social links
    $social_links = [
        'facebook' => get_the_author_meta('facebook'),
        'twitter' => get_the_author_meta('twitter'),
        'instagram' => get_the_author_meta('instagram'),
        'linkedin' => get_the_author_meta('linkedin'),
    ];
    ?>

    <?php if (array_filter($social_links)) : ?>
        <div class="post_main-author-descr-socials flex align_c">
            <?php if (!empty($social_links['facebook'])) : ?>
                <a href="<?php echo esc_url($social_links['facebook']); ?>" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/website/dist/images/fb-ic2.svg'; ?>" alt="Facebook" />
                </a>
            <?php endif; ?>
            <?php if (!empty($social_links['twitter'])) : ?>
                <a href="<?php echo esc_url($social_links['twitter']); ?>" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/website/dist/images/tw-ic2.svg'; ?>" alt="Twitter" />
                </a>
            <?php endif; ?>
            <?php if (!empty($social_links['instagram'])) : ?>
                <a href="<?php echo esc_url($social_links['instagram']); ?>" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/website/dist/images/inst-ic2.svg'; ?>" alt="Instagram" />
                </a>
            <?php endif; ?>
            <?php if (!empty($social_links['linkedin'])) : ?>
                <a href="<?php echo esc_url($social_links['linkedin']); ?>" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/website/dist/images/ld-ic2.svg'; ?>" alt="LinkedIn" />
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php }

// Add custom avatar field to user profile
add_action('show_user_profile', 'custom_avatar_field');
add_action('edit_user_profile', 'custom_avatar_field');
function custom_avatar_field($user) {
    $avatar = get_user_meta($user->ID, 'custom_avatar', true);
    ?>
    <h3>Custom Avatar</h3>
    <table class="form-table">
        <tr>
            <th><label for="custom_avatar">Upload Avatar</label></th>
            <td>
                <input type="file" name="custom_avatar" id="custom_avatar" /><br />
                <?php if ($avatar) { ?>
                    <img src="<?php echo esc_url($avatar); ?>" width="96" style="border-radius: 50%;" /><br />
                    <input type="checkbox" name="remove_avatar" value="1" /> Remove Avatar
                <?php } ?>
            </td>
        </tr>
    </table>
    <?php
}

// Save custom avatar using profile update hooks
add_action('personal_options_update', 'save_custom_avatar');
add_action('edit_user_profile_update', 'save_custom_avatar');
function save_custom_avatar($user_id) {
	
    if (!empty($_FILES['custom_avatar']['name'])) {
        $upload = wp_upload_bits($_FILES['custom_avatar']['name'], null, file_get_contents($_FILES['custom_avatar']['tmp_name']));
        if (!$upload['error']) {
            update_user_meta($user_id, 'custom_avatar', $upload['url']);
        }
    }
    if (isset($_POST['remove_avatar'])) {
        delete_user_meta($user_id, 'custom_avatar');
    }
}

// Display custom avatar
add_filter('get_avatar', 'custom_avatar', 10, 5);

function custom_avatar($avatar, $id_or_email, $size, $default, $alt) {
    $user = is_numeric($id_or_email) ? get_user_by('id', (int)$id_or_email) : get_user_by('email', $id_or_email);
    $custom_avatar = $user ? get_user_meta($user->ID, 'custom_avatar', true) : false;
    if ($custom_avatar) {
        $avatar = '<img src="' . esc_url($custom_avatar) . '" alt="' . esc_attr($alt) . '" width="' . (int)$size . '" style="border-radius: 50%;" />';
    }
    return $avatar;
}

function custom_avatar_enqueue_script() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#your-profile').attr('enctype', 'multipart/form-data');
        });
    </script>
    <?php
}
add_action('admin_footer', 'custom_avatar_enqueue_script');