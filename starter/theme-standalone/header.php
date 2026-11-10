<?php
/* Header */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main-content"><?php esc_html_e( 'Langsung ke konten', 'imajiner-theme' ); ?></a>

<header class="imj-header">
	<div class="container imj-header-inner">
		<?php if ( has_custom_logo() ) : ?>
			<?php the_custom_logo(); ?>
		<?php else : ?>
			<a class="imj-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		<?php endif; ?>

		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<nav class="imj-nav" aria-label="<?php esc_attr_e( 'Menu utama', 'imajiner-theme' ); ?>" data-nav>
				<button class="imj-nav-toggle" type="button" aria-expanded="false" aria-controls="imj-menu" data-nav-toggle hidden><?php esc_html_e( 'Menu', 'imajiner-theme' ); ?></button>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_id'        => 'imj-menu',
						'menu_class'     => 'imj-menu',
						'depth'          => 1,
					)
				);
				?>
			</nav>
		<?php endif; ?>
	</div>
</header>

<main id="main-content" tabindex="-1">
