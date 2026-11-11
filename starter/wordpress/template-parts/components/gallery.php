<?php
/* Gallery */

defined( 'ABSPATH' ) || exit;

${{prefix}}_images = array_filter( array_map( 'absint', (array) ( $args['images'] ?? array() ) ) );

if ( ! ${{prefix}}_images ) {
	return;
}

{{prefix}}_use( 'lightbox' );

${{prefix}}_group   = sanitize_title( $args['group'] ?? wp_unique_id( 'gallery-' ) );
${{prefix}}_columns = min( 4, max( 2, (int) ( $args['columns'] ?? 3 ) ) );
${{prefix}}_sizes   = '(max-width: 544px) 100vw, (max-width: 921px) 50vw, ' . round( 1200 / ${{prefix}}_columns ) . 'px';
?>
<ul class="grid grid-<?php echo esc_attr( ${{prefix}}_columns ); ?> gallery-list">
	<?php foreach ( ${{prefix}}_images as ${{prefix}}_id ) : ?>
		<?php ${{prefix}}_caption = wp_get_attachment_caption( ${{prefix}}_id ); ?>
		<li>
			<figure class="gallery-item">
				<a href="<?php echo esc_url( wp_get_attachment_image_url( ${{prefix}}_id, 'full' ) ); ?>" data-lightbox data-gallery="<?php echo esc_attr( ${{prefix}}_group ); ?>"<?php echo ${{prefix}}_caption ? ' data-description="' . esc_attr( ${{prefix}}_caption ) . '"' : ''; ?>>
					<?php echo wp_get_attachment_image( ${{prefix}}_id, 'medium_large', false, array( 'sizes' => ${{prefix}}_sizes ) ); ?>
				</a>
				<?php if ( ${{prefix}}_caption ) : ?>
					<figcaption class="text-sm"><?php echo esc_html( ${{prefix}}_caption ); ?></figcaption>
				<?php endif; ?>
			</figure>
		</li>
	<?php endforeach; ?>
</ul>
