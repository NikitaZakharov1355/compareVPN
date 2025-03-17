<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package nordVpn
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">

		<?php
		$logo_white = get_field('logo_white', 'options');
		$logo_alternate = get_field('logo_alternate', 'options');
		$lang_switcher_shortcode = get_field('lang_switcher_shortcode', 'options');
		?>
		<header class="header">
			<div class="container flex justify_sb align_c">
				<div class="header_logo-wrap flex align_c">
					<a href="<?php echo esc_url(home_url('/')); ?>" class="header_logo ">
						<?php echo wp_get_attachment_image($logo_white['ID'], ' full'); ?>
					</a>
				</div>
				<div class="header_nav-button">
					<img src="<?php echo get_stylesheet_directory_uri() . '/website/dist/images/nav_mobile-ic.svg' ?>" alt="icon">
				</div>

				<div class="header_nav font_im">
					<?php
					wp_nav_menu(array(
						'theme_location' => 'menu-1',
						'menu_class' => 'menu',
						'container' => 'nav',
						'container_class' => 'main-nav'
					));
					?>
				</div>
				<div class="header_action flex justify_sb align_c">
					<div class="header_action-search">
						<button class="header_action-search-toggle">
							<img src="<?php echo get_stylesheet_directory_uri() . '/website/dist/images/search-ic3.svg'; ?>" />
						</button>
						<form class="header_action-search-form" method="GET" action="<?php echo esc_url(home_url('/')); ?>">
							<button class="header_action-search-btn" type="submit">
								<img src="<?php echo get_stylesheet_directory_uri() . '/website/dist/images/search-dark-ic.svg'; ?>" alt="Search">
							</button>
							<input class="header_action-search-field" type="text" name="s" placeholder="Search...">
						</form>
					</div>
					<div class="header_action-lang">
						<button class="header_action-lang-toggle">
							<img src="<?php echo get_stylesheet_directory_uri() . '/website/dist/images/lang-ic2.svg'; ?>" />
						</button>
						<div class="header_action-lang-switcher">
							<?php echo do_shortcode($lang_switcher_shortcode); ?>
							<?php
							if (is_active_sidebar('header-language-toggle')) {
								dynamic_sidebar('header-language-toggle');
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</header>

		<?php custom_breadcrumbs(); ?>