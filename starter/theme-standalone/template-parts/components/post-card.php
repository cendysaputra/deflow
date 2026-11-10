<?php
/* Post card */

defined( 'ABSPATH' ) || exit;

$imj_level = min( 6, max( 2, (int) ( $args['level'] ?? 2 ) ) );
$imj_tag   = tag_escape( 'h' . $imj_level );
?>
<article <?php post_class( 'card' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<figure class="card-media"><?php the_post_thumbnail( 'medium_large' ); ?></figure>
	<?php endif; ?>
	<header class="stack stack-sm">
		<<?php echo $imj_tag; ?> class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></<?php echo $imj_tag; ?>>
		<time class="text-sm" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
	</header>
	<?php the_excerpt(); ?>
</article>
