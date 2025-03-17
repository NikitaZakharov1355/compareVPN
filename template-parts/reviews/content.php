<?php
$enable_title_line = get_sub_field('enable_title_line');
$title = get_sub_field('title');
$rating = get_sub_field('rating');
$text = get_sub_field('text');
$link = get_sub_field('link');
?>

<div class="post_main-content font_im">
    <?php if ($title) : ?>
        <h2 class="post_main-content-title flex align_c justify_fs font_sb<?php if ($enable_title_line) : echo ' lined'; endif; ?>">
            <?php if ($rating) : ?>
                <span class="flex_auto">
                    <img src="<?php echo get_template_directory_uri(); ?>/website/dist/images/star.svg">
                    <?php echo $rating; ?>
                </span>
            <?php endif; ?>
            <span class="title_inner">
                <?php echo $title; ?>
            </span>
        </h2>
    <?php endif; ?>
    <?php if ($text) : ?>
    <div class="post_main-content-text">
        <?php echo $text; ?>
    </div>
    <?php endif; ?>
    <?php if ($link) : ?>
        <div class="text_c">
            <a target="<?php echo $link['target']; ?>" href="<?php echo $link['url']; ?>" class="button"><?php echo $link['title']; ?></a>
        </div>
    <?php endif; ?>
</div>