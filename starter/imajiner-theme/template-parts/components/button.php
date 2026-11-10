<?php
/* Button */

defined( 'ABSPATH' ) || exit;

$imj_link = $args['link'] ?? null;

if ( empty( $imj_link['url'] ) || empty( $imj_link['title'] ) ) {
	return;
}

$imj_class = trim( 'btn ' . ( $args['class'] ?? '' ) );
$imj_blank = '_blank' === ( $imj_link['target'] ?? '' );
?>
<a class="<?php echo esc_attr( $imj_class ); ?>" href="<?php echo esc_url( $imj_link['url'] ); ?>"<?php echo $imj_blank ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( $imj_link['title'] ); ?></a>
