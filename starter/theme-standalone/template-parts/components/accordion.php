<?php
/* Accordion */

defined( 'ABSPATH' ) || exit;

$imj_items = array_filter(
	(array) ( $args['items'] ?? array() ),
	function ( $item ) {
		return ! empty( $item['title'] );
	}
);

if ( ! $imj_items ) {
	return;
}

$imj_name  = $args['name'] ?? '';
$imj_level = min( 6, max( 2, (int) ( $args['level'] ?? 3 ) ) );
$imj_tag   = tag_escape( 'h' . $imj_level );
?>
<div class="accordion">
	<?php foreach ( $imj_items as $imj_item ) : ?>
		<details class="accordion-item"<?php echo $imj_name ? ' name="' . esc_attr( $imj_name ) . '"' : ''; ?>>
			<summary class="accordion-trigger">
				<<?php echo $imj_tag; ?> class="accordion-title"><?php echo esc_html( $imj_item['title'] ); ?></<?php echo $imj_tag; ?>>
			</summary>
			<?php if ( ! empty( $imj_item['content'] ) ) : ?>
				<div class="accordion-panel"><?php echo wp_kses_post( $imj_item['content'] ); ?></div>
			<?php endif; ?>
		</details>
	<?php endforeach; ?>
</div>
