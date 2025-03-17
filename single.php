<?php



/**

 *Template Name: duplicate Template

 * Description: A custom page template for special layouts

 */



get_header(); ?>



<div class="post">

    <div class="container post_container flex justify_sb align_fs">

        <?php get_sidebar(); ?>

        <div class="post_main">

            <h1 class="post_main-title font_sb"><?php the_title(); ?></h1>

            <?php get_template_part('template-parts/reviews/author'); ?>

            <?php if (get_the_post_thumbnail()) : ?>

                <div class="featured_image">

                    <?php echo get_the_post_thumbnail(); ?>

                </div>

            <?php endif; ?>

            <?php get_template_part('template-parts/flexible-content'); ?>

            <?php get_template_part('template-parts/post/author-box'); ?>

            <div class="post_main-comments">

                <?php

                if (comments_open() || get_comments_number()) :

                    comments_template();

                endif;

                ?>

            </div>

        </div>

    </div>

</div>



<?php get_footer(); ?>