<?php
/* Marquee */

defined( 'ABSPATH' ) || exit;

${{prefix}}_items = array_filter(
	(array) ( $args['items'] ?? array() ),
	function ( $item ) {
		return ! empty( $item['image'] );
	}
);

if ( ! ${{prefix}}_items ) {
	return;
}

{{prefix}}_use( 'marquee' );

${{prefix}}_label = $args['label'] ?? '';
?>
<div class="marquee" data-marquee data-speed="<?php echo esc_attr( absint( $args['speed'] ?? 5000 ) ); ?>">
	<button class="marquee-toggle screen-reader-text" type="button" aria-pressed="false" data-marquee-toggle hidden><?php esc_html_e( 'Jeda animasi', '{{PROJECT_SLUG}}-theme' ); ?></button>
	<div class="swiper"<?php echo ${{prefix}}_label ? ' aria-label="' . esc_attr( ${{prefix}}_label ) . '"' : ''; ?>>
		<ul class="swiper-wrapper marquee-list">
			<?php foreach ( ${{prefix}}_items as ${{prefix}}_item ) : ?>
				<li class="swiper-slide marquee-item">
					<?php if ( ! empty( ${{prefix}}_item['link']['url'] ) ) : ?>
						<a href="<?php echo esc_url( ${{prefix}}_item['link']['url'] ); ?>"><?php echo wp_get_attachment_image( (int) ${{prefix}}_item['image'], 'medium', false, array( 'class' => 'marquee-logo' ) ); ?></a>
					<?php else : ?>
						<?php echo wp_get_attachment_image( (int) ${{prefix}}_item['image'], 'medium', false, array( 'class' => 'marquee-logo' ) ); ?>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
