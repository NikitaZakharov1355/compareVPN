<?php
$select_vpn = get_field('select_vpn');

$logo_image = get_field('logo', $select_vpn);
$rating = round(get_post_meta($select_vpn, 'rating', true), 1);
$our_score = get_rating($select_vpn);

$best_discount = get_post_meta(get_the_ID(), 'best_discount', true) ? get_post_meta(get_the_ID(), 'best_discount', true) : 0;
$verifed_coupons = get_post_meta(get_the_ID(), 'verifed', true) ? get_post_meta(get_the_ID(), 'verifed', true) : 0;
$last_update = date('j.m.Y');

?>
<div class="coupon_aside flex_auto">
    <div class="coupon_aside-card">
        <?php if ($logo_image) : ?>
            <?php echo wp_get_attachment_image($logo_image['ID'], 'full', '', array("class" => "coupon_aside-card-image")); ?>
        <?php else : ?>
            <img class="coupon_aside-card-image" src="https://via.placeholder.com/50" alt="VPN Logo">
        <?php endif; ?>

        <div class="coupon_aside-card-rating flex align_c justify_c">
            <div class="coupon_aside-card-rating-wrap flex align_c flex_auto">
                <?php if ($our_score) : ?>
                    <div class="quick_stars-wrapper">
                        <div class="quick_stars flex justify_fs align_c" style="width: <?php echo $our_score * 10; ?>%">
                            <img decoding="async" src="<?php echo get_template_directory_uri(); ?>/website/dist/images/stars-full-l.svg">
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Score Title -->
        <?php if ($our_score) : ?>
            <div class="coupon_aside-card-rating-label text_c font_sb"><?php echo __('Our Score:','nordvpn')?> <?php echo esc_html($our_score); ?></div>
        <?php endif; ?>

        <!-- Details Section -->
        <div class="coupon_aside-card-details">
            <div class="coupon_aside-card-details-row flex justify_sb align_c">
                <span class="coupon_aside-card-details-row-label"><?php echo __('Verified coupons','nordvpn')?></span>
                <span class="coupon_aside-card-details-row-value font_im"><?php echo esc_html($verifed_coupons); ?></span>
            </div>            
            <div class="coupon_aside-card-details-row flex justify_sb align_c">
                <span class="coupon_aside-card-details-row-label"><?php echo __('Best discount','nordvpn')?></span>
                <span class="coupon_aside-card-details-row-value font_im"><?php echo esc_html($best_discount); ?>%</span>
            </div>
            <div class="coupon_aside-card-details-row flex justify_sb align_c">
                <span class="coupon_aside-card-details-row-label"><?php echo __('Last Update','nordvpn')?></span>
                <span class="coupon_aside-card-details-row-value font_im"><?php echo esc_html($last_update); ?></span>
            </div>
        </div>
    </div>
</div>