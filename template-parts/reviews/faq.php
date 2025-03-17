<?php
    // $is_static = get_sub_field('is_static');
    // $is_static = false;
    // if($is_static){
    //     $title = get_field('faq_title','options');
    //     $list = get_field('faq_list','options');
    // } else{
    //     $title = get_sub_field('title');
    //     $list = get_sub_field('list');
    // }

    $title = get_sub_field('title');
    $list = get_sub_field('list');
?>
<?php if($list): ?>
<div class="faq post_main-content" id="faq">
    <?php if($title): ?>
    <h2 class="post_main-content-title flex justify_sb align_c font_sb" data-toggle="faq-list">
    <span class="title_inner">
                <?php echo $title; ?>
            </span>
    </h2>
    <?php endif; ?>
    <div id="faq-list">
    <?php foreach($list as $item): ?>
        <div class="faq_item font_im">
        <div class="faq_item-head"><?php echo $item['title']; ?></div>
        <div class="faq_item-content">
            <?php echo $item['text']; ?>
        </div>
    </div>
    <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>