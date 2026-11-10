<?php
/* Archive */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<section class="section">
	<div class="container stack stack-lg">
		<header class="stack stack-sm">
			<?php the_archive_title( '<h1>', '</h1>' ); ?>
			<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
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
