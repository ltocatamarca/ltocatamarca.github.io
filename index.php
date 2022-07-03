<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package streamit
 */

namespace Streamit\Utility;

$streamit_options = get_option('streamit_options');
$is_sidebar = streamit()->is_primary_sidebar_active();
$post_section = streamit()->post_style();
get_header();
$streamit_layout = '';
$options_streamit_load = '';
if (isset($streamit_options['streamit_blog'])) {
	$streamit_layout = $streamit_options['streamit_blog'];
}
if (isset($streamit_options['streamit_display_pagination'])) {
	$options_streamit_load = $streamit_options['streamit_display_pagination'];
}
?>
<div class="site-content-contain">
	<div id="content" class="site-content">
		<div id="primary" class="content-area">
			<main id="main" class="site-main <?php echo esc_attr(!is_singular()?'streamit_datapass_blog':'',)?> " data-options="<?php echo esc_attr($options_streamit_load); ?>">
				<div class="container">
					<div class="row <?php echo esc_attr($post_section['row_reverse']); ?>">
						<?php
						
						if ($is_sidebar) {
							echo '<div class="col-xl-8 col-sm-12 streamit-blog-main-list">';
						} else if ($streamit_layout != '4' && $streamit_layout != '5') {
							echo '<div class="col-lg-12 col-sm-12 streamit-blog-main-list">';
						}

						if (have_posts()) {
							while (have_posts()) {
								the_post();
								get_template_part('template-parts/content/entry', get_post_type(), $post_section['post']);
							}
						} else {
							get_template_part('template-parts/content/error');
						}

						if ($is_sidebar || $streamit_layout != '4' && $streamit_layout != '5') {
							echo '</div>';
						}
						get_sidebar();

						?>
					</div>
					<?php
					if (!is_singular()) {
						if (isset($streamit_options['streamit_display_pagination'])) {
							$options = $streamit_options['streamit_display_pagination'];
							if ($options == "load_more") {
								if ($wp_query->max_num_pages > 1)
									echo '<a class="streamit_loadmore_btn_blog btn btn-hover iq-button" tabindex="0" data-loading-text="' . $streamit_options['streamit_display_blog_loadmore_text_2'] . '"><span>' . $streamit_options['streamit_display_blog_loadmore_text'] . '</span></a>';
							} elseif ($options == "infinite_scroll") {

								echo '<div class="loader-wheel-container"></div>';
							} else {
								get_template_part('template-parts/content/pagination');
							}
						} else {
							get_template_part('template-parts/content/pagination');
						}
					}

					?>
				</div>
			</main><!-- #primary -->
		</div>
	</div>
</div>
<?php
get_footer();
