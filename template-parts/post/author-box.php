<div class="post_main-author">

<div class="post_main-author-title text_c font_sb">

    <?php echo 'About the Author'; ?>

</div>

<div class="post_main-author-descr">

<?php get_template_part('template-parts/reviews/author'); ?>

    <div class="post_main-author-descr-text">

        <p><?php echo esc_html(get_the_author_meta('description')); ?></p>

    </div>

    <?php get_author_social_links(); ?>

    <div class="post_main-author-descr-action-title font_sb text_c">

        <?php echo 'Did you like this article? Rate it!'; ?>

    </div>

    <div class="post_main-author-descr-action-rating flex align_c justify_c" data-post-id="<?php echo get_the_ID(); ?>">

        <?php for ($i = 1; $i <= 5; $i++) : ?>

            <div class="rating-star" data-rating="<?php echo $i; ?>">



            </div>

        <?php endfor; ?>

    </div>

    <div id="rating-feedback"></div>

</div>

</div>