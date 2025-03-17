<?php
$title = get_sub_field('title');
$list = get_sub_field('list');
?>
<div class="post_main-content">
    <?php if($title): ?>
    <h2 class="post_main-content-title flex justify_sb align_c font_sb">
        <span class="title_inner">
            <?php echo $title; ?>
        </span>
    </h2>
    <?php endif; ?>
    <?php if($list): ?>
    <div class="post_main-content-list flex justify_sb align_c flex_wrap">
        <?php foreach ($list as $item) :
            $is_active = $item['is_active'];
            $title = $item['title'];
            $value = $item['value'];
            $subtitle = $item['subtitle'];
            $link = $item['link'];
        ?>
            <div class="post_main-inner-list-box flex dir_col justify_sb <?php if ($is_active) : echo 'active';
                                                                            endif; ?>">
                <?php if ($is_active) : ?>
                    <div class="post_main-inner-list-box-recommend font_im"><span class="text_lg">Best Price</span></div>
                <?php endif; ?>
                <div class="post_main-inner-list-box-month font_im"><?php echo $title; ?></div>
                <div>
                    <div class="post_main-inner-list-box-price font_sb"><?php echo $value; ?></div>
                    <div class="post_main-inner-list-box-type"><?php echo $subtitle; ?></div>
                </div><a href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>" class="button font_sb border_lg-o"><?php echo $link['title']; ?></a>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>