<div class="post_main-loop-aside flex_auto">
    <!-- <div class="post_main-loop-aside-filter-open" data-toggle="filters">
        <svg fill="#000000" width="64px" height="64px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <path d="M12,25l6.67,6.67a1,1,0,0,0,.7.29.91.91,0,0,0,.39-.08,1,1,0,0,0,.61-.92V13.08L31.71,1.71A1,1,0,0,0,31.92.62,1,1,0,0,0,31,0H1A1,1,0,0,0,.08.62,1,1,0,0,0,.29,1.71L11.67,13.08V24.33A1,1,0,0,0,12,25ZM3.41,2H28.59l-10,10a1,1,0,0,0-.3.71V28.59l-4.66-4.67V12.67a1,1,0,0,0-.3-.71Z"></path>
            </g>
        </svg>
        <?php echo __('Filters:', 'nordvpn'); ?>
    </div> -->
    <form id="filters" class="search-form-wrap" method="POST" action="<?php echo esc_url(home_url('/')); ?>">
        <div class="text_c search_top">
            <?php if (is_search()) : ?>
                <span class="title_inner">
                <h1 class="search_title">
                    <?php
                    /* translators: %s: search query. */
                    $search_query = get_search_query();
                    printf(esc_html__('Search Results for: %s', 'nordvpn'), '<span>' . esc_html($search_query) . '</span>');
                    ?>
                    </h1>
                <?php else : ?>
                    <h1 class="search_title"><?php echo get_field('blog_title','options'); ?></h1>
                <?php endif; ?>
                <div class="search_subtext">
                    <?php echo get_field('blog_subtext', 'options'); ?>
                </div>
                <div class="search-form">
                    <div class="search-form-btn" type="submit">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/website/dist/images/search-dark-ic.svg'; ?>" alt="Search">
                    </div>
                    <input class="search-form-field" type="text" name="s" placeholder="Search..." value="<?php echo get_search_query(); ?>">
                </div>
        </div>
        <div class="tag-filter tag-filter-tabs">
            <div class="toggle_inner flex align_c justify_c" id="types">
                <?php
                    $type = isset($_GET['type']) ? $_GET['type'] : 'post';
                ?>
                <div class="tag-filter-tab">
                    <label class="custom-checkbox tag-filter-tab-title <?php echo ($type === 'vpn') ? 'active' : ''; ?>">
                        <input class="custom-checkbox-input" type="radio" name="types[]" <?php echo ($type === 'vpn') ? 'checked' : ''; ?> value="<?php echo __('vpn', 'nordvpn'); ?>">
                        <span class="custom-checkbox-box"></span>
                        <?php echo __('Reviews', 'nordvpn'); ?>
                    </label>
                </div>
                <div class="tag-filter-tab">
                    <label class="custom-checkbox tag-filter-tab-title <?php echo ($type === 'post') ? 'active' : ''; ?> tag-filter-tab-post">
                        <input class="custom-checkbox-input" type="radio" <?php echo ($type === 'post') ? 'checked' : ''; ?> name="types[]" value="<?php echo __('post', 'nordvpn'); ?>">
                        <span class="custom-checkbox-box"></span>
                        <?php echo __('Posts', 'nordvpn'); ?>
                    </label>
                </div>
            </div>
        </div>
        <div class="tab-filter-post-wrap" <?php echo ($type === 'vpn') ? 'style="display:none;"' : ''; ?>>
            <div class="tab-filter-post flex align_c justify_sb">
                <div class="tag-filter">
                    <div class="toggle_inner flex align_c justify_sb" id="tags">
                        <?php
                        $tags = get_tags();
                        if ($tags) :
                            foreach ($tags as $tag) :
                                $checked = isset($_GET['tags']) && in_array($tag->term_id, $_GET['tags']) ? 'checked' : '';
                        ?>
                                <label class="custom-checkbox">
                                    <input class="custom-checkbox-input" type="checkbox" name="tags[]" value="<?php echo esc_attr($tag->term_id); ?>" <?php echo $checked; ?>>
                                    <span class="custom-checkbox-box"></span>
                                    <?php echo esc_html($tag->name); ?>
                                </label>
                        <?php endforeach;
                        endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>