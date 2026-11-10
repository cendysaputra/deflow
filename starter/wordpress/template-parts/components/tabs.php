<?php
/* Tabs */

defined( 'ABSPATH' ) || exit;

${{prefix}}_items = array_values(
	array_filter(
		(array) ( $args['items'] ?? array() ),
		function ( $item ) {
			return ! empty( $item['label'] );
		}
	)
);

if ( ! ${{prefix}}_items ) {
	return;
}

${{prefix}}_id    = sanitize_title( $args['id'] ?? wp_unique_id( 'tabs-' ) );
${{prefix}}_label = $args['label'] ?? '';
?>
<div class="tabs" data-tabs>
	<div class="tabs-list" role="tablist"<?php echo ${{prefix}}_label ? ' aria-label="' . esc_attr( ${{prefix}}_label ) . '"' : ''; ?> hidden>
		<?php foreach ( ${{prefix}}_items as ${{prefix}}_i => ${{prefix}}_item ) : ?>
			<button class="tabs-tab" type="button" role="tab" id="<?php echo esc_attr( ${{prefix}}_id . '-tab-' . ${{prefix}}_i ); ?>" aria-controls="<?php echo esc_attr( ${{prefix}}_id . '-panel-' . ${{prefix}}_i ); ?>" aria-selected="<?php echo 0 === ${{prefix}}_i ? 'true' : 'false'; ?>"><?php echo esc_html( ${{prefix}}_item['label'] ); ?></button>
		<?php endforeach; ?>
	</div>
	<?php foreach ( ${{prefix}}_items as ${{prefix}}_i => ${{prefix}}_item ) : ?>
		<div class="tabs-panel" role="tabpanel" id="<?php echo esc_attr( ${{prefix}}_id . '-panel-' . ${{prefix}}_i ); ?>" aria-labelledby="<?php echo esc_attr( ${{prefix}}_id . '-tab-' . ${{prefix}}_i ); ?>" tabindex="0">
			<?php echo wp_kses_post( ${{prefix}}_item['content'] ?? '' ); ?>
		</div>
	<?php endforeach; ?>
</div>
