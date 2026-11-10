<?php
/* Button */

defined( 'ABSPATH' ) || exit;

$dfl_link = $args['link'] ?? null;

if ( empty( $dfl_link['url'] ) || empty( $dfl_link['title'] ) ) {
	return;
}

$dfl_class = trim( 'btn ' . ( $args['class'] ?? '' ) );
$dfl_blank = '_blank' === ( $dfl_link['target'] ?? '' );
?>
<a class="<?php echo esc_attr( $dfl_class ); ?>" href="<?php echo esc_url( $dfl_link['url'] ); ?>"<?php echo $dfl_blank ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( $dfl_link['title'] ); ?></a>
