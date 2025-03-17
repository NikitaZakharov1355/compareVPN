<?php

// Check value exists.
if (have_rows('flexible_content')) :

    // Loop through rows.
    while (have_rows('flexible_content')) : the_row();

        // Case: Paragraph layout.
        if (get_row_layout() == 'hero_banner') :
            get_template_part('template-parts/reviews/hero');
        endif;
        if (get_row_layout() == 'author_info') :
            get_template_part('template-parts/reviews/author');
        endif;
        if (get_row_layout() == 'inline_banner') :
            get_template_part('template-parts/banner/inline_banner');
        endif;
        if (get_row_layout() == 'preview_content') :
            get_template_part('template-parts/reviews/content-preview');
        endif;
        if (get_row_layout() == 'content') :
            get_template_part('template-parts/reviews/content');
        endif;
        if (get_row_layout() == 'pricing') :
            get_template_part('template-parts/reviews/pricing');
        endif;
        if (get_row_layout() == 'faq') :
            get_template_part('template-parts/reviews/faq');
        endif;
        if (get_row_layout() == 'overview_on_vpn_page') :
            get_template_part('template-parts/reviews/overview');
        endif;

        // post
        if (get_row_layout() == 'post_list') :
            get_template_part('template-parts/post/list');
        endif;
        if (get_row_layout() == 'overview') :
            get_template_part('template-parts/post/overview');
        endif;          

        // coupon
        if (get_row_layout() == 'banner') :
            get_template_part('template-parts/coupon/banner');
        endif;  
        if (get_row_layout() == 'coupon_list') :
            get_template_part('template-parts/coupon/coupon-list');
        endif;          

    // End loop.
    endwhile;

// No value.
else :
// Do something...
endif;
