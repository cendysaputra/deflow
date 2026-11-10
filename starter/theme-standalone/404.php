<?php
/* 404 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<section class="section">
	<div class="container stack text-center">
		<h1><?php esc_html_e( 'Halaman tidak ditemukan', 'imajiner-theme' ); ?></h1>
		<p><?php esc_html_e( 'Halaman yang kamu cari tidak tersedia.', 'imajiner-theme' ); ?></p>
		<p><a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Kembali ke beranda', 'imajiner-theme' ); ?></a></p>
	</div>
</section>
<?php
get_footer();
