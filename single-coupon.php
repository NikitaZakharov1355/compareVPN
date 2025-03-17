<?php get_header(); ?>

<?php
$post_title = get_the_title();

?>
<div class="coupon">
    <div class="container coupon_container flex justify_sb">
        <!-- VPN Offer Card -->

        <?php get_template_part('template-parts/coupon/aside'); ?>

        <!-- Coupon Offer Section -->
        <div class="coupon_main">

            <?php get_template_part('template-parts/flexible-content'); ?>


        </div>
    </div>
</div>

<?php get_footer(); ?>