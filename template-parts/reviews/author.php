<div class="post_main-info flex align_c">

    <div class="post_main-info-author flex justify_sb align_c">
        <?php $avatar = get_user_meta(get_the_author_meta('ID'), 'custom_avatar', true); ?>
        <?php if($avatar): ?>
            <img src="<?php echo $avatar?>" alt="avatar">
        <?php else: ?>
            <?php echo get_avatar(get_the_author_meta('ID'), 32, '', get_the_author(), ['class' => 'author-avatar']); ?>
        <?php endif; ?>
        <div class="post_main-info-name font_im"><?php the_author(); ?></div>

    </div>

    <div class="post_main-info-divider font_im">•</div>

    <div class="post_main-info-date font_im"> Updated on <?php the_modified_date('jS F Y'); ?></div>

</div>