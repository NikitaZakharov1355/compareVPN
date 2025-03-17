<?php
    $title = get_sub_field('title');
    $text = get_sub_field('text');
    $link = get_sub_field('link');
    $image = get_sub_field('image');
?>

<div class="post_main-hero flex align_c justify_sb">
    <div class="post_main-hero-descr flex_auto">
    <?php if($title): ?>
        <div class="post_main-hero-descr-title font_sb">
            <?php echo $title; ?>
        </div>
    <?php endif; ?>
    <?php if($link): ?>
        <a class="button font_sb" href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>" rel="nofollow">
            <?php echo $link['title']; ?>
        </a>
    <?php endif; ?>
    <?php if($text): ?>
        <div class="post_main-hero-descr-text"><?php echo $text; ?></div>
    </div>
    <?php endif; ?>
    <?php if($image): ?>
    <div class="post_main-hero-image">
        <?php echo wp_get_attachment_image($image['ID'], ' full'); ?>
    </div>
    <?php endif; ?>
</div>