<?php



/**

 * Template Name: vpn

 * Template for displaying VPN posts.

 */



get_header(); ?>

<div class="post">

    <div class="container post_container flex justify_sb align_fs">

        <?php get_sidebar(); ?>

        <div class="post_main">



            <?php get_template_part('template-parts/flexible-content'); ?>

            <?php

                $logo = get_field('logo');

                $rating = get_post_meta(get_the_ID(), 'rating', true) ? round(get_post_meta(get_the_ID(), 'rating', true),1) : 0.0;

            ?>

            <section class="total flex justify_sb align_c">

                <div class="total-left flex justify_sb align_c">

                    <div class="total_logo flex_auto">

                        <?php echo wp_get_attachment_image($logo['ID'], ' full'); ?>

                    </div>

                    <div class="total_title font_im">

                        <?php echo get_the_title(); ?>

                        <?php echo __('User Reviews', 'nordvpn'); ?>

                    </div>

                </div>

                <div class="total-right flex justify_sb align_c">

                    <div class="total_rating flex">

                        <img class="flex_auto" src="<?php echo get_template_directory_uri(); ?>/website/dist/images/star-ic.svg">

                        <?php echo $rating; ?>

                    </div>

                    <div class="total_comments">

                        <?php echo __('(Based on '); ?>

                        <?php echo get_comments_number(); ?>

                        <?php echo __(' reviews)'); ?>

                    </div>

                </div>

            </section>

            <?php get_template_part('template-parts/post/author-box'); ?> 

            <div class="post_main-comments">

                <?php

                // if (comments_open() || get_comments_number()) :

                comments_template();

                // endif;

                ?>

            </div>

        </div>

    </div>

</div>

</div>

<?php get_footer(); ?>