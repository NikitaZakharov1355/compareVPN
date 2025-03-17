<?php
    $title = get_sub_field('title');
    $link = get_sub_field('$link');
    $content = get_sub_field('content');
?>
<div class="post_main-box">
    <div class="post_main-box-item">
        <?php if($title): ?>
        <h2 class="post_main-box-title">
        <span class="title_inner">
                <?php echo $title; ?>
            </span>
        </h2>
        <?php endif; ?>
        <?php if($content): ?>
        <?php 
        $counter = 1;
        foreach($content as $item):
         ?>
         <?php if($item['title']): ?>
            <h4 class="<?php echo $item['color']; ?>" data-toggle="list-id-<?php echo $counter; ?>">
                <div class="flex align_c title_inner font_ib">
                    <?php echo wp_get_attachment_image($item['image']['ID'], ' full'); ?>
                    <?php echo $item['title']; ?>
                </div>
            </h4>
        <?php endif; ?>
        <?php if($item['text']): ?>
            <div class="list_row" id="list-id-<?php echo $counter; ?>">
                <?php echo $item['text']; ?>
            </div>
    <?php endif; ?>
        <?php $counter++;
    endforeach; ?>
    <?php endif; ?>
		<?php if($link): ?>
	<div class="text_c">
		<a class="button font_ib" target="<?php echo $link['target']?>" href="<?php echo $link['url']?>"><?php echo $link['title']?></a>
	</div>
		<?php endif; ?>
</div>
</div>