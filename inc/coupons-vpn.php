<?php
function calculate_and_save_coupont_data($post_id)
{

    // Check if the flexible content field exists
    if (have_rows('flexible_content', $post_id)) {
        // Variables to hold the total rating and the count of rows

        while (have_rows('flexible_content', $post_id)) {
            the_row();

            // Check if the current row layout is 'content'
            if (get_row_layout() === 'coupon_list') {
                $list = get_sub_field('select_coupons');
                $max_percent = 0;
                $verifed = 0;
                foreach ($list as $item) {
                    $percent = get_field('percent', $item);
                    if ($max_percent < $percent) {
                        $max_percent = $percent;
                    }

                    $select_type = get_field('select_type',$item);

                    if($select_type['value'] == 'verified'){
                        $verifed++;
                    }
                }
            }
        }

        // Save the average rating to a custom field
        update_post_meta($post_id, 'best_discount', $max_percent);
        update_post_meta($post_id, 'verifed', $verifed);
    } else {
        // Default value if no rows exist
        update_post_meta($post_id, 'best_discount', '0');
        update_post_meta($post_id, 'verifed', '0');
    }
}

add_action('acf/save_post', 'calculate_and_save_coupont_data', 20);
