<?php
/* Index */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<section class="section">
	<div class="container stack stack-lg">
		<header>
			<h1><?php echo esc_html( is_home() && ! is_front_page() ? single_post_title( '', false ) : get_bloginfo( 'name' ) ); ?></h1>
		</header>

		<?php if ( have_posts() ) : ?>
			<ul class="grid grid-3">
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>
					<li><?php imj_component( 'post-card' ); ?></li>
				<?php endwhile; ?>
			</ul>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Belum ada konten.', 'imajiner-theme' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
