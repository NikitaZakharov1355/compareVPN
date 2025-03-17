<?php
    $image = get_sub_field('image');
    $title = get_sub_field('title');
    $subtitle = get_sub_field('subtitle');
?>
<div class="coupon_main-banner flex justify_sb align_c text_c">
    <div class="coupon_main-banner-logo flex_auto">
        <?php if ($image) : ?>
            <?php echo wp_get_attachment_image($image['ID'], 'full', '', array("class" => "coupon_main-banner-logo-image")); ?>
        <?php else : ?>
           
        <?php endif; ?>
    </div>
    <div class="coupon_main-banner-text">
        <?php if($title): ?>
        <h2 class="coupon_main-banner-text-title font_sb"><?php echo $title; ?></h2>
        <?php endif; ?>
        <?php if($subtitle): ?>
        <p class="coupon_main-banner-text-inner font_im"><?php echo $subtitle; ?></p>
        <?php endif; ?>
    </div>
</div>