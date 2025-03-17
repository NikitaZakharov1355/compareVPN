<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package nordVpn
 */

get_header();
?>
<?php
	$type = isset($_GET['type']) ? $_GET['type'] : 'post';
?>
<main id="primary" class="site-main">

<div class="container post_main-wrap">

    <?php get_template_part('template-parts/search/filters');?>

    <div class="post_main-loop-wrap">
        <?php
        // Get the search query and tags from the URL
        $search_query = get_search_query();
        $tags = isset($_POST['tags']) ? array_map('intval', $_POST['tags']) : [];

        // Modify the query with tag filtering
        $args = array(
            'post_type' => array($type),
            's' => $search_query,
            'posts_per_page' => 6,
            'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) : ?>

            <div class="post_loop">
                <?php
                /* Start the Loop */
                while ($query->have_posts()) :
                    $query->the_post();

                    // Include the content template for search results
                    get_template_part('template-parts/content', 'search');

                endwhile;
                ?>
            </div>

            <div class="text_c load_more-wrap">
                <button class="load_more-post button"><?php echo __('Load More', 'nordvpn'); ?></button>
            </div>

            <?php

        else :
            get_template_part('template-parts/content', 'none');
        endif;

        // Reset post data
        wp_reset_postdata();
        ?>

    </div>
</div>
</main><!-- #main -->


<?php
// get_sidebar();
get_footer();
