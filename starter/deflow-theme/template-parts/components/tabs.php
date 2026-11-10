<?php
/* Tabs */

defined( 'ABSPATH' ) || exit;

$dfl_items = array_values(
	array_filter(
		(array) ( $args['items'] ?? array() ),
		function ( $item ) {
			return ! empty( $item['label'] );
		}
	)
);

if ( ! $dfl_items ) {
	return;
}

$dfl_id    = sanitize_title( $args['id'] ?? wp_unique_id( 'tabs-' ) );
$dfl_label = $args['label'] ?? '';
?>
<div class="tabs" data-tabs>
	<div class="tabs-list" role="tablist"<?php echo $dfl_label ? ' aria-label="' . esc_attr( $dfl_label ) . '"' : ''; ?> hidden>
		<?php foreach ( $dfl_items as $dfl_i => $dfl_item ) : ?>
			<button class="tabs-tab" type="button" role="tab" id="<?php echo esc_attr( $dfl_id . '-tab-' . $dfl_i ); ?>" aria-controls="<?php echo esc_attr( $dfl_id . '-panel-' . $dfl_i ); ?>" aria-selected="<?php echo 0 === $dfl_i ? 'true' : 'false'; ?>"><?php echo esc_html( $dfl_item['label'] ); ?></button>
		<?php endforeach; ?>
	</div>
	<?php foreach ( $dfl_items as $dfl_i => $dfl_item ) : ?>
		<div class="tabs-panel" role="tabpanel" id="<?php echo esc_attr( $dfl_id . '-panel-' . $dfl_i ); ?>" aria-labelledby="<?php echo esc_attr( $dfl_id . '-tab-' . $dfl_i ); ?>" tabindex="0">
			<?php echo wp_kses_post( $dfl_item['content'] ?? '' ); ?>
		</div>
	<?php endforeach; ?>
</div>
