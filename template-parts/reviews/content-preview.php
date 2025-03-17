<?php
$title = get_sub_field('title');
$text = get_sub_field('text');
$link = get_sub_field('link');
$text_additional = get_sub_field('text_additional');
?>

<?php get_template_part('template-parts/reviews/author'); ?>

<div class="post_main-inner font_im">
    <?php if ($title) : ?>
    <h2 class="post_main-inner-title flex align_c justify_sb font_sb">
        <?php echo $title; ?>
    </h2>
    <?php endif; ?>
    <?php if ($text) : ?>
    <div class="post_main-inner-text">
        <?php echo $text; ?>
    </div>
    <?php endif; ?>
    <?php if ($link) : ?>
        <div class="text_c">
            <a target="<?php echo $link['target']; ?>" href="<?php echo $link['url']; ?>" class="button"><?php echo $link['title']; ?></a>
        </div>
    <?php endif; ?>
    <?php if($text_additional): ?>
    <div class="post_main-inner-text">
        <?php echo $text_additional; ?>
    </div>
    <?php endif; ?>
</div>