<?php
/* Button */

defined( 'ABSPATH' ) || exit;

${{prefix}}_link = $args['link'] ?? null;

if ( empty( ${{prefix}}_link['url'] ) || empty( ${{prefix}}_link['title'] ) ) {
	return;
}

${{prefix}}_class = trim( 'btn ' . ( $args['class'] ?? '' ) );
${{prefix}}_blank = '_blank' === ( ${{prefix}}_link['target'] ?? '' );
?>
<a class="<?php echo esc_attr( ${{prefix}}_class ); ?>" href="<?php echo esc_url( ${{prefix}}_link['url'] ); ?>"<?php echo ${{prefix}}_blank ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( ${{prefix}}_link['title'] ); ?></a>
