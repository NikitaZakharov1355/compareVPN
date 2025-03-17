<?php
$select_vpn = get_sub_field('select_vpn');
$customizible_content = get_sub_field('customizible_content');
if ($customizible_content) {
    $title = get_sub_field('title');
    $text = get_sub_field('text');
    $content = get_sub_field('list');
    $overview_icon = get_sub_field('overview_icon');
    $link = get_sub_field('link');
} else {
    $title = get_field('title', $select_vpn);
    $text = get_field('text', $select_vpn);
    $content = get_field('list', $select_vpn);
    $overview_icon = get_field('overview_icon', $select_vpn);
    $link = get_field('link', $select_vpn);
}
$banner_logo = get_field('banner_logo', $select_vpn);
$banner_image = get_field('banner_image', $select_vpn);
$banner_list = get_field('banner_list', $select_vpn);
$banner_link = get_field('banner_link', $select_vpn);
?>

<div class="post_main-box">
    <div class="post_main-box-item">
        <?php if ($title) : ?>
            <h3><?php echo wp_get_attachment_image($overview_icon['ID'], ' full'); ?>
                <?php echo $title; ?>
            </h3>
        <?php endif; ?>
        <?php if ($banner_logo && $banner_image && $banner_list) : ?>
            <div class="post_main-box-banner flex justify_sb align_c">
                <div class="post_main-box-banner-attach">
                    <div class="post_main-box-banner-attach-logo">
                        <?php echo wp_get_attachment_image($banner_logo['ID'], ' full'); ?>
                    </div>
                    <div class="post_main-box-banner-attach-image">
                        <?php echo wp_get_attachment_image($banner_image['ID'], ' full'); ?>
                    </div>
                </div>
                <div class="post_main-box-banner-info flex_auto flex justify_sb align_c dir_col">
                    <?php foreach ($banner_list as $item) : ?>
                        <div class="post_main-box-banner-info-row flex justify_sb align_c font_sb">
                            <div><?php echo $item['title']; ?></div>
                            <div><?php echo $item['value']; ?></div>
                        </div>
                    <?php endforeach; ?>
                    <?php if ($banner_link) : ?>
                        <a target="<?php echo $banner_link['target']; ?>" class="button font_ib" href="<?php echo $banner_link['url']; ?>">
                            <?php echo $banner_link['title']; ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>		
        <?php if ($text) : ?>
            <div class="post_main-box-text">
                <?php echo $text; ?>
            </div>
        <?php endif; ?>
        <?php if ($content) : ?>
            <?php
            $counter = 1;
            foreach ($content as $item) :
            ?>
                <h4 class="<?php echo $item['color']; ?>">
                    <div class="flex align_c title_inner font_ib">
                        <?php echo $item['title']; ?>
                    </div>
                </h4>
                <div class="list_row">
                    <?php echo $item['text']; ?>
                </div>
            <?php $counter++;
            endforeach; ?>
        <?php endif; ?>
        <?php if ($link) : ?>
            <div class="text_c">
                <a class="button font_ib" target="<?php echo $link['target'] ?>" href="<?php echo $link['url'] ?>"><?php echo $link['title'] ?></a>
            </div>
        <?php endif; ?>
    </div>
</div>