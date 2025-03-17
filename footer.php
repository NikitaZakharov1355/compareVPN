<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package nordVpn
 */

?>

<?php
$footer_text = get_field('footer_text', 'options');
$footer_socials = get_field('footer_socials', 'options');
$footer_form_shortcode = get_field('footer_form_shortcode', 'options');
$footer_copyright = get_field('footer_copyright', 'options');
$logo_alternate = get_field('logo_alternate', 'options');
$logo_white = get_field('logo_white', 'options');
?>

<div class="scroll-top-wrap">
	<a href="#scroll-top" class="scroll-top">
		<svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
			<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
			<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
			<g id="SVGRepo_iconCarrier">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M7.50716 11.6536C7.19494 11.3814 7.16249 10.9076 7.43468 10.5954L11.4347 6.00715C11.5771 5.84377 11.7833 5.75 12 5.75C12.2168 5.75 12.4229 5.84377 12.5653 6.00715L16.5653 10.5954C16.8375 10.9076 16.8051 11.3814 16.4929 11.6536C16.1806 11.9258 15.7069 11.8933 15.4347 11.5811L12.75 8.50161V17.5C12.75 17.9142 12.4142 18.25 12 18.25C11.5858 18.25 11.25 17.9142 11.25 17.5V8.50161L8.56534 11.5811C8.29315 11.8933 7.81938 11.9258 7.50716 11.6536Z" fill="#fff"></path>
			</g>
		</svg>
	</a>
</div>

<footer class="footer">
	<div class="container footer_top flex justify_sb align_fs">
		<div class="footer_info">
			<div class="footer_logo">
				<?php echo wp_get_attachment_image($logo_white['ID'], ' full'); ?>
			</div>
			<div class="footer_info-text">
				<?php echo $footer_text; ?>
			</div>

			<div class="footer_info-socials flex align_c flex_wrap">
				<?php foreach ($footer_socials as $item) : ?>
					<a class="footer_info-link flex_inline align_c justify_c" href="<?php $item['link']; ?>">
						<?php echo wp_get_attachment_image($item['image']['ID'], ' full'); ?>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="footer_nav">
			<?php
			if (is_active_sidebar('footer-company')) {
				dynamic_sidebar('footer-company');
			}
			?>
		</div>
		<div class="footer_nav">
			<?php
			if (is_active_sidebar('footer-help')) {
				dynamic_sidebar('footer-help');
			}
			?>
		</div>
		<div class="footer_subscribe">
			<?php
			if (is_active_sidebar('footer-subscribe')) {
				dynamic_sidebar('footer-subscribe');
			}
			?>
		</div>
	</div>
	<div class="footer_copyright">
		<div class="container">
			<?php
			// Get the current year
			$currentYear = date("Y");

			// Display the copyright notice
			echo __('&copy; ');
			echo $currentYear;
			echo $footer_copyright;
			?>
		</div>
	</div>
</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>