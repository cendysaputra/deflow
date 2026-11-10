<?php
/* Accordion */

defined( 'ABSPATH' ) || exit;

$dfl_items = array_filter(
	(array) ( $args['items'] ?? array() ),
	function ( $item ) {
		return ! empty( $item['title'] );
	}
);

if ( ! $dfl_items ) {
	return;
}

$dfl_name  = $args['name'] ?? '';
$dfl_level = min( 6, max( 2, (int) ( $args['level'] ?? 3 ) ) );
$dfl_tag   = tag_escape( 'h' . $dfl_level );
?>
<div class="accordion">
	<?php foreach ( $dfl_items as $dfl_item ) : ?>
		<details class="accordion-item"<?php echo $dfl_name ? ' name="' . esc_attr( $dfl_name ) . '"' : ''; ?>>
			<summary class="accordion-trigger">
				<<?php echo $dfl_tag; ?> class="accordion-title"><?php echo esc_html( $dfl_item['title'] ); ?></<?php echo $dfl_tag; ?>>
			</summary>
			<?php if ( ! empty( $dfl_item['content'] ) ) : ?>
				<div class="accordion-panel"><?php echo wp_kses_post( $dfl_item['content'] ); ?></div>
			<?php endif; ?>
		</details>
	<?php endforeach; ?>
</div>
