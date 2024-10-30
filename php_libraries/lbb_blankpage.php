<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php 
    
    if ( ! get_theme_support( 'title-tag' ) ) {
        echo '<title> ' . wp_title() . '</title>';
    }
    wp_head(); 
    
    ?>
</head>
<body <?php body_class( 'lbb-blankpage' ); ?>>


<?php 
if(have_posts()){
   while ( have_posts() ) {
    	the_post(); ?>
        <article id="post- <?php the_ID();?>" <?php post_class(); ?>>
    	<?php  the_content(); ?>
        </article>
        
<?php } 
}



 wp_footer(); 
 
?>

</body>
</html>