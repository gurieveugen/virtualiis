<?php
/*
 * @package WordPress
 * @subpackage Base_Theme
 */

define('TDU', get_bloginfo('template_url'));
define('MARKER_PRICE', 300);
define('MY_ACCOUNT_PAGE_ID', 7);
define('MODEL_OPTIMISATION_PRODUCT_ID', 41);
define('HOSTING_PRODUCT_ID', 40);

add_theme_support( 'automatic-feed-links' );
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
add_filter( 'use_default_gallery_style', '__return_false' );

add_filter( 'init', 'virtualiis_init' );

function virtualiis_init(){
	  	
}

add_action( 'add_meta_boxes', 'theme_add_custom_box' );
function theme_add_custom_box(){
	add_meta_box("marker-box", "MARKER", "marker_box", "product", "normal", "high");
}

function marker_box(){
	global $post;
	$marker_attachment = get_post_meta($post->ID, 'marker_attachment');
	//print_r($marker_attachment);
	echo '<input type="hidden" name="marker_noncename" id="marker_noncename" value="' . 
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';	
	
	$custom_filelds = get_post_custom($post->ID);
	$marker_status = $custom_filelds['marker_status'][0]

	?>
	<table style="width:auto;">
	  <tr>
	    <td>Name:</td>
	    <td><!--<input type="text" name="marker_name" style="width:400px;" value="<?php echo $post->post_title; ?>">--><?php echo $post->post_title; ?></td>
	  </tr> 
	  <tr>
	    <td>Author:</td>
	    <td><!--<input type="text" name="marker_author" style="width:400px;" value="<?php echo $custom_filelds['marker_author'][0]; ?>">--><?php echo $custom_filelds['marker_author'][0]; ?></td>
	  </tr> 
	  <tr>
	    <td>Link:</td>
	    <td><!--<input type="text" name="marker_name" style="width:400px;" value="<?php echo $custom_filelds['marker_link'][0]; ?>">--><?php echo $custom_filelds['marker_link'][0]; ?></td>
	  </tr>
	  <?php if(!empty($custom_filelds['marker_attachment'])){ ?>
	  <tr>
	    <td>ATTACHMENTS:</td>
	    <td>&nbsp;</td>
	  </tr>
	  <?php foreach($custom_filelds['marker_attachment'] as $attachmnet_id){
	  	$attachmnet = get_post($attachmnet_id);
		//print_r($attachmnet);
		$path_parts = pathinfo($attachmnet->guid);
		$attachment_file_name = $path_parts["basename"];
		?>	
	  <tr>
	    <td>File:</td>
	    <td><b><?php echo $attachment_file_name; ?></b> <?php if(!empty($attachmnet->post_content)){ echo '( Description: '.$attachmnet->post_content.' )';}?>&nbsp;&nbsp;&nbsp;<a href="<?php echo $attachmnet->guid; ?>">view</a></td>
	  </tr> 
	  <?php }?>
	  <?php }?>	  
	  <tr>
	    <td>Status:</td>
	    <td>
		<input type="radio" name="marker_status" value="received" <?php if($marker_status == 'received'){ echo 'checked';}?>>&nbsp;&nbsp;&nbsp;Received</br>
		<input type="radio" name="marker_status" value="processing" <?php if($marker_status == 'processing'){ echo 'checked';}?>>&nbsp;&nbsp;&nbsp;Processing</br>
		<input type="radio" name="marker_status" value="live" <?php if($marker_status == 'live'){ echo 'checked';}?>>&nbsp;&nbsp;&nbsp;Live</br>
		</td>
	  </tr>
	  <?php if($custom_filelds['optimisation_request'][0] == 'yes'){?>	  
	  <tr>
	    <td>Optimisation Request:</td>
	    <td>YES</td>
	  </tr> 
	  <?php }?>
	</table>
	<?php
}
add_action('save_post', 'save_marker'); 

function save_marker($post_id){
	global $post;
	
  if ( !wp_verify_nonce( $_POST['marker_noncename'], plugin_basename(__FILE__) )) {
    return $post_id;
  }
	  
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
    return $post_id;	
	
	
	if($post->post_type == 'product' && $_SERVER['REQUEST_METHOD'] == 'POST'){
	
		update_post_meta($post_id, "marker_status", $_POST["marker_status"]);
			
	}
}


add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
function theme_name_scripts() {
	wp_enqueue_style('thickbox');
	wp_enqueue_script('thickbox');
}

register_sidebar(array(
	'id' => 'right-sidebar',
	'name' => 'Right Sidebar',
	'before_widget' => '<div class="widget %2$s" id="%1$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>'
));

add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 604, 270, true );
add_image_size( 'single-post-thumbnail', 400, 9999, false );

register_nav_menus( array(
	'primary_nav' => __( 'Primary Navigation', 'theme' ),
	'top_nav' => __( 'Top Navigation', 'theme' ),
	'bottom_nav' => __( 'Bottom Navigation', 'theme' )
) );

function change_menu_classes($css_classes){
	$css_classes = str_replace("current-menu-item", "current-menu-item active", $css_classes);
	$css_classes = str_replace("current-menu-parent", "current-menu-parent active", $css_classes);
	return $css_classes;
}
add_filter('nav_menu_css_class', 'change_menu_classes');

function filter_template_url($text) {
	return str_replace('[template-url]',get_bloginfo('template_url'), $text);
}
add_filter('the_content', 'filter_template_url');
add_filter('get_the_content', 'filter_template_url');
add_filter('widget_text', 'filter_template_url');



function theme_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'theme' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'theme' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'theme' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
function theme_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'theme' ); ?></h1>
		<div class="nav-links">

			<?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'theme' ) ); ?>
			<?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'theme' ) ); ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
function theme_entry_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) )
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'theme' );
	else
		$format_prefix = '%2$s';

	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'theme' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
	);

	if ( $echo )
		echo $date;

	return $date;
}
function theme_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() )
		echo '<span class="featured-post">' . __( 'Sticky', 'theme' ) . '</span>';

	if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
		theme_entry_date();

	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'theme' ) );
	if ( $categories_list ) {
		echo '<span class="categories-links">' . $categories_list . '</span>';
	}

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'theme' ) );
	if ( $tag_list ) {
		echo '<span class="tags-links">' . $tag_list . '</span>';
	}

	// Post author
	if ( 'post' == get_post_type() ) {
		printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'theme' ), get_the_author() ) ),
			get_the_author()
		);
	}
}
function scripts_method() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', TDU.'/js/jquery-1.9.1.min.js');
	wp_enqueue_script( 'jquery' );
}
add_action('wp_enqueue_scripts', 'scripts_method');

// register tag [template-url]
function template_url($text) {
	return str_replace('[template-url]',get_bloginfo('template_url'), $text);
}
add_filter('the_content', 'template_url');
add_filter('get_the_content', 'template_url');
add_filter('widget_text', 'template_url');

function theme_default_content( $content ) {
	$content = "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ultrices, magna non porttitor commodo, massa nibh malesuada augue, non viverra odio mi quis nisl. Nullam convallis tincidunt dignissim. Nam vitae purus eget quam adipiscing aliquam. Sed a congue libero. Quisque feugiat tincidunt tortor sed sodales. Etiam mattis, justo in euismod volutpat, ipsum quam aliquet lectus, eu blandit neque libero eu justo. Nunc nibh nulla, accumsan in imperdiet vel, pretium in metus. Aenean in lacus at lacus imperdiet euismod in non nulla. Mauris luctus sodales metus, ac porttitor est lacinia non. Proin diam urna, feugiat at adipiscing in, varius vel mi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed tincidunt commodo massa interdum iaculis.</p><!--more--><p>Aliquam metus libero, elementum et malesuada fermentum, sagittis et libero. Nullam quis odio vel ipsum facilisis viverra id sit amet nibh. Vestibulum ullamcorper luctus lacinia. Etiam accumsan, orci eu blandit vestibulum, purus ante malesuada purus, non commodo odio ligula quis turpis. Vestibulum scelerisque feugiat diam, eu mollis elit cursus nec. Quisque commodo ultricies scelerisque. In hac habitasse platea dictumst. Nullam hendrerit rhoncus lacus, id lobortis leo condimentum sed. Nulla facilisi. Quisque ut velit a neque feugiat rutrum at sit amet neque. Sed at libero dictum est aliquam porttitor. Morbi tempor nulla ut tellus malesuada cursus condimentum metus luctus. Quisque dui neque, lobortis id vehicula et, tincidunt eget justo. Morbi vulputate velit eget leo fermentum convallis. Nam mauris risus, consectetur a posuere ultricies, elementum non orci.</p><p>Ut viverra elit vel mauris venenatis gravida ut quis mi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam eleifend urna sit amet nisi scelerisque pretium. Nulla facilisi. Donec et odio vel sem gravida cursus vestibulum dapibus enim. Pellentesque eget aliquet nisl. In malesuada, quam ac interdum placerat, elit metus consequat lorem, non consequat felis ipsum et ligula. Sed varius interdum volutpat. Vestibulum et libero nisi. Maecenas sit amet risus et sapien lobortis ornare vel quis ipsum. Nam aliquet euismod aliquam. Donec velit purus, convallis ac convallis vel, malesuada vitae erat.</p>";
	return $content;
}
add_filter('default_content', 'theme_default_content');

add_filter( 'wpcf7_form_class_attr', 'your_custom_form_class_attr' );

function your_custom_form_class_attr( $class ) {
	$class .= ' contact-form';
	return $class;
}

function get_thumb($attach_id, $width, $height, $crop = false) {
	if (is_numeric($attach_id)) {
		$image_src = wp_get_attachment_image_src($attach_id, 'full');
		$file_path = get_attached_file($attach_id);
	} else {
		$imagesize = getimagesize($attach_id);
		$image_src[0] = $attach_id;
		$image_src[1] = $imagesize[0];
		$image_src[2] = $imagesize[1];
		$file_path = $_SERVER["DOCUMENT_ROOT"].str_replace(get_bloginfo('siteurl'), '', $attach_id);
		
	}
	
	$file_info = pathinfo($file_path);
	$extension = '.'. $file_info['extension'];

	// image path without extension
	$no_ext_path = $file_info['dirname'].'/'.$file_info['filename'];

	$cropped_img_path = $no_ext_path.'-'.$width.'x'.$height.$extension;

	// if file size is larger than the target size
	if ($image_src[1] > $width || $image_src[2] > $height) {
		// if resized version already exists
		if (file_exists($cropped_img_path)) {
			return str_replace(basename($image_src[0]), basename($cropped_img_path), $image_src[0]);
		}

		if (!$crop) {
			// calculate size proportionaly
			$proportional_size = wp_constrain_dimensions($image_src[1], $image_src[2], $width, $height);
			$resized_img_path = $no_ext_path.'-'.$proportional_size[0].'x'.$proportional_size[1].$extension;			

			// if file already exists
			if (file_exists($resized_img_path)) {
				return str_replace(basename($image_src[0]), basename($resized_img_path), $image_src[0]);
			}
		}

		// resize image if no such resized file
		$new_img_path = image_resize($file_path, $width, $height, $crop);
		$new_img_size = getimagesize($new_img_path);
		return str_replace(basename($image_src[0]), basename($new_img_path), $image_src[0]);
	}

	// return without resizing
	return $image_src[0];
}

function virtualiis_redirect($redirect_to, $requested_redirect_to, $user ) {
	global $user;
	
    // If they're on the login page, don't do anything
    if ( !isset ( $user->user_login ) ) {
        return $redirect_to;
    }

	
	if( isset( $user->roles ) && is_array( $user->roles ) ) {
        if( in_array( "administrator", $user->roles ) ) {
            $redirect_url = get_bloginfo('siteurl').'/wp-admin/';
        } else {
            $redirect_url = get_bloginfo('siteurl').'/my-account/';
        }	
	}else{
		$redirect_url = get_bloginfo('siteurl').'/my-account/';
	}
    wp_redirect( $redirect_url );
	die();
}
add_filter('login_redirect', 'virtualiis_redirect', 10, 3);

function get_my_markers(){
	global $current_user;
	get_currentuserinfo();
	$marker_query = new WP_Query(array('post_type'=>'product', 'post__not_in'=>array(MODEL_OPTIMISATION_PRODUCT_ID, HOSTING_PRODUCT_ID), 'author'=>$current_user->ID, 'posts_per_page'=>'-1'));
	return $marker_query;
}
function get_marker($marker_id){
	$marker = get_post($marker_id);
	$custom_filelds = get_post_custom($marker_id);
	
	$marker->marker_name = $marker->post_title;
	$marker->marker_description = $marker->post_content;

	if(!empty($custom_filelds['marker_author'][0])){ 
	$marker->marker_author = $custom_filelds['marker_author'][0];
	}
	if(!empty($custom_filelds['marker_link'][0])){ 
	$marker->marker_link = $custom_filelds['marker_link'][0];
	}
	if(!empty($custom_filelds['_thumbnail_id'][0])){ 
	$marker->thumbnail = $custom_filelds['_thumbnail_id'][0];
	}
	if(!empty($custom_filelds['optimisation_request'][0])){ 
	$marker->marker_optimisation_request = $custom_filelds['optimisation_request'][0];
	}
	if(!empty($custom_filelds['marker_status'][0])){ 
	$marker->marker_status = $custom_filelds['marker_status'][0];
	}	
	if(!empty($custom_filelds['marker_attachment'])){ 
	$marker->marker_attachment = $custom_filelds['marker_attachment'];
	}
	if(!empty($custom_filelds['_file_paths'][0])){ 
	$marker->marker_file_path = $custom_filelds['_file_paths'][0];
	}	
	
	return $marker;
}

function get_order_name_by_marker($order){
	global $woocommerce;
	$order_name = '';
	foreach($order->get_items() as $item) {
		if($item['product_id'] != MODEL_OPTIMISATION_PRODUCT_ID && $item['product_id'] != HOSTING_PRODUCT_ID ){
			$order_name = $item['name'];
		}
	}
	return $order_name;
}

function ik_eyes_only( $wp_query ) {
	//are we looking at the Media Library or the Posts list?
	if ( strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/upload.php' ) !== false  
	|| strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/edit.php' ) !== false 
	|| strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/media-upload.php' ) !== false 
	) {
		//user level 5 converts to Editor
		if ( !current_user_can( 'level_4' ) ) {
			//restrict the query to current user
			global $current_user;
			$wp_query->set( 'author', $current_user->id );
		}
	}
}
add_filter('parse_query', 'ik_eyes_only' );

function short_content($content,$sz = 500,$more = '...') {
	if (strlen($content)<$sz) return $content;
	$cp = explode("<!--more-->", $content);
	//echo $content;
	//print_r($cp);
	if (count($cp>0)) return $cp[0].$more;
	$p = strpos($content, " ",$sz);
    if (!$p) return $content;
        $content = strip_tags($content);
        if (strlen($content)<$sz) return $content;
        $p = strpos($content, " ",$sz);
        if (!$p) return $content;
	return substr($content, 0, $p).$more;
}

function new_excerpt_more( $more ) {
	return '';
}
add_filter('excerpt_more', 'new_excerpt_more');