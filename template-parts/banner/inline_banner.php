<?php
$banner_id = get_sub_field('banner_select');
$banner_view = get_field('banner_select', $banner_id);
?>
<?php if ($banner_view == 'oneLink') :
    $link = get_field('link', $banner_id);
    $title = get_field('title', $banner_id);
?>
    <div class="post_main-cta inline_banner flex align_c justify_sb border_lg-o">
        <?php if ($title) : ?>
            <div class="post_main-cta-title"><?php echo $title; ?></div>
        <?php endif; ?>
        <?php if ($link) : ?>
            <a target="<?php echo $link['target']; ?>" href="<?php echo $link['url']; ?>" class="button flex_auto"><?php echo $link['title']; ?></a>
        <?php endif; ?>
    </div>
<?php elseif ($banner_view == 'quickGuide') :
    $title = get_field('title', $banner_id);
    $text = get_field('text', $banner_id);
?>
    <div class="post_main-notice inline_banner">
        <?php if ($title) : ?>
            <div class="post_main-notice-title font_sb">
                <?php echo $title; ?>
            </div>
        <?php endif; ?>
        <?php if ($text) : ?>
            <div class="post_main-notice-text font_im">
                <?php echo $text; ?>
            </div>
        <?php endif; ?>
    </div>
<?php elseif ($banner_view == 'proTip') :
    $image = get_field('image', $banner_id);
    $text = get_field('text', $banner_id);
?>
    <div class="post_main-notice inline_banner flex justify_sb align_c">
        <?php if ($image) : ?>
            <div class="post_main-notice-image flex_auto">
                <?php echo wp_get_attachment_image($image['ID'], ' full'); ?>
            </div>
        <?php endif; ?>
        <?php if ($text) : ?>
            <div class="post_main-notice-text">
                <?php echo $text; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>