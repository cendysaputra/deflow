<?php
/* Tabs */

defined( 'ABSPATH' ) || exit;

$imj_items = array_values(
	array_filter(
		(array) ( $args['items'] ?? array() ),
		function ( $item ) {
			return ! empty( $item['label'] );
		}
	)
);

if ( ! $imj_items ) {
	return;
}

$imj_id    = sanitize_title( $args['id'] ?? wp_unique_id( 'tabs-' ) );
$imj_label = $args['label'] ?? '';
?>
<div class="tabs" data-tabs>
	<div class="tabs-list" role="tablist"<?php echo $imj_label ? ' aria-label="' . esc_attr( $imj_label ) . '"' : ''; ?> hidden>
		<?php foreach ( $imj_items as $imj_i => $imj_item ) : ?>
			<button class="tabs-tab" type="button" role="tab" id="<?php echo esc_attr( $imj_id . '-tab-' . $imj_i ); ?>" aria-controls="<?php echo esc_attr( $imj_id . '-panel-' . $imj_i ); ?>" aria-selected="<?php echo 0 === $imj_i ? 'true' : 'false'; ?>"><?php echo esc_html( $imj_item['label'] ); ?></button>
		<?php endforeach; ?>
	</div>
	<?php foreach ( $imj_items as $imj_i => $imj_item ) : ?>
		<div class="tabs-panel" role="tabpanel" id="<?php echo esc_attr( $imj_id . '-panel-' . $imj_i ); ?>" aria-labelledby="<?php echo esc_attr( $imj_id . '-tab-' . $imj_i ); ?>" tabindex="0">
			<?php echo wp_kses_post( $imj_item['content'] ?? '' ); ?>
		</div>
	<?php endforeach; ?>
</div>
