<?php
/* Accordion */

defined( 'ABSPATH' ) || exit;

${{prefix}}_items = array_filter(
	(array) ( $args['items'] ?? array() ),
	function ( $item ) {
		return ! empty( $item['title'] );
	}
);

if ( ! ${{prefix}}_items ) {
	return;
}

${{prefix}}_name  = $args['name'] ?? '';
${{prefix}}_level = min( 6, max( 2, (int) ( $args['level'] ?? 3 ) ) );
${{prefix}}_tag   = tag_escape( 'h' . ${{prefix}}_level );
?>
<div class="accordion">
	<?php foreach ( ${{prefix}}_items as ${{prefix}}_item ) : ?>
		<details class="accordion-item"<?php echo ${{prefix}}_name ? ' name="' . esc_attr( ${{prefix}}_name ) . '"' : ''; ?>>
			<summary class="accordion-trigger">
				<<?php echo ${{prefix}}_tag; ?> class="accordion-title"><?php echo esc_html( ${{prefix}}_item['title'] ); ?></<?php echo ${{prefix}}_tag; ?>>
			</summary>
			<?php if ( ! empty( ${{prefix}}_item['content'] ) ) : ?>
				<div class="accordion-panel"><?php echo wp_kses_post( ${{prefix}}_item['content'] ); ?></div>
			<?php endif; ?>
		</details>
	<?php endforeach; ?>
</div>
