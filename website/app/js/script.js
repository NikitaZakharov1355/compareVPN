jQuery(document).ready(function($){

    // scrollTop

    $('.scroll-top').click(function(){
        $('html, body').animate({ scrollTop: 0 }, 600); 
    })

    // load more

    $('.search-form-wrap').submit(function(){
        $('.search-form-btn').click();
        return false;
    });

    var page = 1;



    // Ensure no duplicate event listeners are attached
$('.tag-filter input, .search-form-btn').off('click').on('click', function () {

    if($(this).parent().hasClass('tag-filter-tab-title')){
        $('.tag-filter-tab-title').removeClass('active');
        $(this).parent().addClass('active');
    }

    if($('.tag-filter-tab-post').hasClass('active')){
        $('.tab-filter-post-wrap').fadeIn();
    } else {
        $('.tab-filter-post-wrap').fadeOut();
    }

    page = 1;
    get_resources_list(page, $(this));
});


$('.load_more-post').off('click').on('click', function () {
    page++;
    get_resources_list(page, $(this));
});

function get_resources_list(page, el) {
    var search = $('.search-form-field').val();
    var tags = [];
    var types = [];
    
    // Collect selected tags
    $('.tag-filter input[name="tags[]"]:checked').each(function () {
        tags.push($(this).val());
    });

    // Collect selected types
    $('.tag-filter input[name="types[]"]:checked').each(function () {
        types.push($(this).val());
    });

    if(types.length == 0) {
        types = ['post', 'vpn'];
    }

    var data = {
        'action': 'load_more_posts',
        'page': page,
        'search': search,
        'tags': tags.join(','), // Send tags as a comma-separated string
        'types': types.join(',') // Send types as a comma-separated string
    };

    $('.post_loop').addClass('loading');

    $.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: 'POST',
        data: data,
        success: function (response) {
            $('.post_main-title-h2 .title_inner span').text($('.search-form-field').val());
            console.log(response.data);

            if (response.success) {
                if (response.data.has_posts) {
                    if (el.hasClass('custom-checkbox-input') || el.hasClass('search-form-btn')) {
                        $('.post_loop').html(''); // Clear existing posts
                    }
                    $('.post_loop').append(response.data.posts); // Append new posts
                    $('.load_more-post').show();
                    $('.load_more-post').removeAttr('disabled');
                } else if(page == 1){
                    $('.post_loop').html('');
                } else {
                    $('.load_more-post').hide();
                }
            } else {
                $('.load_more-post').attr('disabled', true);
            }

            $('.post_loop').removeClass('loading');
        },
        error: function () {
            $('.load_more-post').attr('disabled', true);
            alert('An error occurred. Please try again.');
        }
    });
}

    // ajax load more comments

    var paged = 1; // Start from the second page

    $('.load_more-comments').on('click', function () {
        var button = $(this);
        var postId = button.data('post-id');

        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'load_more_comments',
                // security: loadMoreComments.nonce,
                post_id: postId,
                paged: paged,
            },
            beforeSend: function () {
                button.text('Loading...');
            },
            success: function (response) {
                if (response) {
                    $('.comment-list').append(response);
                    paged++; // Increment the page number
                    button.text('Load More');
                } else {
                    button.text('No More Comments').attr('disabled', true);
                }
            },
        });
    });

    // comment form

    $('.rating-star').on('click', function () {
        var rating = $(this).data('rating');
        $('#comment_rating').val(rating); // Set the rating in the hidden input
        $('.rating-star').removeClass('selected'); // Clear previous selection
        $(this).addClass('selected').prevAll().addClass('selected'); // Add selected class to clicked star

        // Update the feedback message
        $('#rating-feedback').text('You selected ' + rating + ' star' + (rating > 1 ? 's' : ''));
    });

    $("body").on("click", ".comment-like-button", function (e) {
        e.preventDefault(); // Prevent the default action
    
        $(this).addClass('active');
    
        var button = $(this);
        var commentId = button.data('comment-id');
    
        $.ajax({
            type: 'POST',
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: 'like_comment',
                comment_id: commentId,
                // nonce: likeComment.nonce
            },
            success: function (response) {
                if (response.success) {
                    // Update like counter
                    button.closest('.comment').find('.comment-actions-like-counter').text(response.data.like_count + ' liked');
                } else {
                    console.log(response.data); // Show error message
                }
            },
            error: function () {
                console.log('An error occurred. Please try again.');
            }
        });
    });
    

    // media
        $('table').wrap('<div class="vpn-table-wrapper-inner"></div>').wrap('<div class="vpn-table-wrapper"></div>');

        function update_mobile(){
            if($(window).width() < 768){
                $('.header').append('<div class="header_nav-mobile"></div>');
                
                var nav = $('.header_nav');
                var action = $('.header_action');
                $('.header_nav-mobile').append(nav).append(action);
    
                $('.header_nav-button').click(function(){
                    $('.header_nav-mobile').toggleClass('active')
                })
                
                $('.header_nav-mobile ul:not(.sub-menu) > li.menu-item-has-children > a').click(function(){
                    if($(this).next('.sub-menu').hasClass('active')){
                        return true;
                    } else {
                        $(this).next('.sub-menu').addClass('active');
                        return false;
                    }
                })
    
                $('.header_nav-mobile ul:not(.sub-menu) > li.menu-item-has-children').click(function(){
                    if($(this).children('.sub-menu').hasClass('active')){
                        $(this).children('.sub-menu').removeClass('active');
                    } else {
                        $(this).children('.sub-menu').addClass('active');
                    }
                })
    
                $('.footer_info-socials').appendTo($('.footer_top'))
            }
        }
        update_mobile();
    // 

    $('.header_action-search-toggle, .header_action-lang-toggle').click(function(){
        $(this).next().slideToggle();
    })

    $('*[data-toggle]').click(function() {
        var id = $(this).data('toggle'); // Retrieve the value of the data-toggle attribute
        $('#' + id).slideToggle(); // Toggle visibility of the target element
    });
    
    $('.comment-form-cookies-consent input').click(function(){
        $(this).parent().toggleClass('checked');
    })

    $('.faq_item-head').click(function(){
        $(this).next().slideToggle();
    })

    var index = 1;
    $('.post_main h2').each(function(){
        
        if($(this).find('.title_inner').length > 0){
            var text = $(this).find('.title_inner').text();
        } else {
            var text = $(this).text();
        }
        if(text == ''){
            return true; 
        }
        var id = 'section-' + index;
        index++;
        $(this).attr('id',id); 
        $('#toc-list').append(`<li><a href="#${id}">${text}</a></li`);
    })

    if($('.post_aside-contents-list-scroll').height() < 432){
        $('.post_aside-contents-list-scroll').parent().addClass('scrolled-to-bottom');
    }

    $(window).scroll(function(){
        if($(this).scrollTop() > 0){
            $('.scroll-top-wrap').fadeIn();
        } else {
            $('.scroll-top-wrap').fadeOut();
        }
        var links = $('.post_aside-contents-list-scroll a')
        const scrollPos = $(window).scrollTop(); // Current scroll position
        // console.log(scrollPos)
        links.each(function () {
            const target = $($(this).attr('href')); // Get the target section
           
            // Check if the target is in view
            if (target.offset().top <= scrollPos + 10) {
                $(this).parent().nextAll().removeClass('active');
                $(this).parent().addClass('active'); // Add active class to the current link
                $(this).parent().prevAll().addClass('active');
               
            }
        });

        if(scrollPos > 0 && !$('#contents-list').hasClass('toggled_nav') && !$('body').hasClass('single-vpn')){
            $('#contents-list').fadeOut().addClass('toggled_nav')
        }

    })

    $('.post_aside-contents-list-scroll').on('scroll', function() {
        var $block = $('.post_aside-contents-list-scroll'); // The container you're checking
        var scrollHeight = $block[0].scrollHeight; // Total height of the content
        var scrollTop = $block.scrollTop(); // Current scroll position from the top
        var blockHeight = $block.parent().height(); // Height of the visible part of the block
        if (scrollTop + blockHeight == scrollHeight) {
          // Add a class when scrolled to the bottom
          $block.parent().addClass('scrolled-to-bottom');
        } else {
          // Remove the class when not at the bottom
          $block.parent().removeClass('scrolled-to-bottom');
        }
      });

      $('#commentform').on('submit', function (event) {
        // You can perform any checks here if needed (e.g., validations)
        // If the post type is 'vpn', proceed to handle the rating
        const postType = $('body').hasClass('single-vpn'); // Ensure your form has this data attribute

        if (postType) {
            const postID = $('.post_main-author-descr-action-rating').data('post-id');
            const rating = $('.rating-star.selected').last().data('rating');
    
            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                method: 'POST',
                data: {
                    action: 'vpn_rating',
                    // nonce: vpnRating.nonce,
                    post_id: postID,
                    rating: rating,
                },
                success: function (response) {
                    if (response.success) {
                        $('#rating-feedback').text(response.data.message);
                    } else {
                        $('#rating-feedback').text(response.data.message);
                    }
                },
            });
        }
    });

      $('.rating-star').on('click', function () {
        const postType = $('body').hasClass('single-vpn');
        if(!postType){
            const postID = $(this).closest('.post_main-author-descr-action-rating').data('post-id');
            const rating = $(this).data('rating');
    
            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                method: 'POST',
                data: {
                    action: 'vpn_rating',
                    // nonce: vpnRating.nonce,
                    post_id: postID,
                    rating: rating,
                },
                success: function (response) {
                    if (response.success) {
                        $('#rating-feedback').text(response.data.message);
                    } else {
                        $('#rating-feedback').text(response.data.message);
                    }
                },
            });
        }
    });

})