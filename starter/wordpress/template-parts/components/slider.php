<?php
/* Slider */

defined( 'ABSPATH' ) || exit;

${{prefix}}_items = (array) ( $args['items'] ?? array() );
${{prefix}}_part  = $args['part'] ?? '';

if ( ! ${{prefix}}_items || ! ${{prefix}}_part ) {
	return;
}

{{prefix}}_use( 'slider' );

${{prefix}}_view  = implode( ',', array_map( 'absint', (array) ( $args['per_view'] ?? array( 3, 2, 1 ) ) ) );
${{prefix}}_label = $args['label'] ?? '';
?>
<div class="slider" data-slider data-per-view="<?php echo esc_attr( ${{prefix}}_view ); ?>">
	<div class="swiper"<?php echo ${{prefix}}_label ? ' aria-label="' . esc_attr( ${{prefix}}_label ) . '"' : ''; ?>>
		<ul class="swiper-wrapper slider-list">
			<?php foreach ( ${{prefix}}_items as ${{prefix}}_item ) : ?>
				<li class="swiper-slide"><?php {{prefix}}_component( ${{prefix}}_part, (array) ${{prefix}}_item ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div class="slider-controls">
		<button class="slider-arrow slider-prev" type="button" aria-label="<?php esc_attr_e( 'Slide sebelumnya', '{{PROJECT_SLUG}}-theme' ); ?>" data-slider-prev></button>
		<div class="slider-progress" data-slider-progress></div>
		<button class="slider-arrow slider-next" type="button" aria-label="<?php esc_attr_e( 'Slide berikutnya', '{{PROJECT_SLUG}}-theme' ); ?>" data-slider-next></button>
	</div>
</div>
