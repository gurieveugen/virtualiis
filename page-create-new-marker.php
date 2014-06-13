<?php
/*
Template Name: Create New Marker
*/

if ( !is_user_logged_in() ) {
	wp_redirect(wp_login_url());
	exit;
}else{
	global $current_user;
	global $woocommerce;
    get_currentuserinfo();
}
include(ABSPATH . '/wp-admin/includes/media.php');
$image_library_url = get_upload_iframe_src( 'image', null, 'library' );
$image_library_url = remove_query_arg( array('TB_iframe'), $image_library_url );
$image_library_url = add_query_arg( array( 'context' => 'marker', 'TB_iframe' => 1 ), $image_library_url );

//echo '<pre>';
//print_r($_POST);
//echo '</pre>';

$sError = '';
$sSuccess = 0;
$FormAction = $_POST['FormAction'];

if($FormAction == 'CreateNewMarker'){
	
	$marker_name = trim($_POST['marker_name']);
	$marker_author = trim($_POST['marker_author']);
	$marker_description = strip_tags($_POST['marker_description']);
	$marker_link = strip_tags($_POST['marker_link']);
	$marker_thumbnail_id = trim($_POST['marker_thumbnail_id']);

	//$is_optimised = $_POST['is_optimised'];
	
	$optimisation_request = $_POST['optimisation_request'];
	
	if (empty($marker_name )) {
		$sError .= '<b>Marker Name</b> is required field.<br>';
	}	
	if (empty($marker_author)) {
		$sError .= '<b>Author</b> is required field.<br>';
	}
	if (empty($marker_description)) {
		$sError .= '<b>Description</b> is required field.<br>';
	}
	if (empty($marker_link)) {
		$sError .= '<b>Link</b> is required field.<br>';
	}
	if (empty($marker_thumbnail_id)) {
		$sError .= '<b>Thumbnail</b> is required field.<br>';
	}
	if (empty($optimisation_request)) {
		$sError .= 'Please select optimisation options.<br>';
	}

	$marker_attachments = array();
	$is_attachement = false;
	foreach($_POST['marker_attachmnet'] as $attachment){
		if(!empty($attachment['att_id'])){
			$marker_attachments[] = $attachment['att_id'];
			$is_attachement = true;
		}
	}
	
	if(!$is_attachement){
		$sError .= 'Please <b>Upload</b> at list one model or video.<br>';
	}
	
	if ($sError == '') { // Craeting new Marcer as Woocommerce product
		
		$marker = array(
		  'post_title'    => $marker_name,
		  'post_content'  => $marker_description,
		  'post_status'   => 'publish',
		  'post_author'   => $current_user->ID,
		  'post_type'	  => 'product'
		);		
		
		$marker_id = wp_insert_post( $marker, $wp_error );
		
		if ( is_wp_error($marker_id) ){
			$sError .= $marker_id->get_error_message();
		}else{	
			update_post_meta( $marker_id, '_price', MARKER_PRICE );
			
			update_post_meta( $marker_id, 'customer_id', $current_user->ID );
			update_post_meta( $marker_id, 'marker_author', $marker_author );
			update_post_meta( $marker_id, 'marker_link', $marker_link );
			update_post_meta( $marker_id, 'optimisation_request', 'yes' );
			update_post_meta( $marker_id, 'marker_status', 'received' );
			
			update_post_meta( $marker_id, '_thumbnail_id', $marker_thumbnail_id );
			update_post_meta( $marker_id, '_virtual', 'yes' );
			update_post_meta( $marker_id, '_downloadable', 'yes' ); 	
			
			foreach($marker_attachments as $att_id){
				update_post_meta( $marker_id, 'marker_attachment', $att_id );
			}
			
			
			// Add new Marker to Cart
			$passed_validation 	= apply_filters( 'woocommerce_add_to_cart_validation', true, $marker_id, 1 );

				if ( $passed_validation ) {
					$woocommerce->cart->empty_cart();
					if ( $woocommerce->cart->add_to_cart( $marker_id, 1 ) ) {
						$was_added_to_cart = true;
					}
				}
			
			// Add Hostin to cart
			$woocommerce->cart->add_to_cart( 40, 1 );	
			
			// Add Optimisation to Cart			
			if($optimisation_request == 'yes'){
				$woocommerce->cart->add_to_cart( 41, 1 );
			}
			
			$sSuccess = 1;
			wp_redirect('/my-account/checkout/');
		}
	}	
		
}

?>
<?php get_header(); ?>
<div id="main" class="my-account">
	<div id="content">
		<h1>Create New Marker</h1>
		<p><span class="blue">Step 1:</span> Please fill in the fields below.</p>
		<p><span class="blue">Step 2:</span> Then complete the marker transaction.</p>
		<p><span class="blue">Step 3:</span> The models processing will begin. Please allow a minimum of 2 working for the processing of optimised models.</p>
		<p>You can log in at any time to review the status.</p>
		<?php if ($sError != '') { ?>
			  <div class="errors"><?php echo($sError); ?></div>
		<?php } ?>			
		<form action="" class="account-form" name="create_marker_form" method="POST">
		<input type="hidden" name="FormAction" value="" >		
			<div class="row">
				<label>Marker Name:</label>
				<input type="text" name="marker_name" id="marker_name" value="<?php echo $marker_name; ?>">
			</div>
			<div class="row">
				<label>Author:</label>
				<input type="text" name="marker_author" id="marker_author" value="<?php echo $marker_author; ?>">
			</div>
			<div class="row">
				<label>Description:</label>
				<textarea name="marker_description" id="marker_description"><?php echo $marker_description; ?></textarea>
			</div>
			<div class="row">
				<label>Thumbnail:</label>
				<input type="hidden" name="marker_thumbnail_url" id="image-url-0">
				<input type="hidden" name="marker_thumbnail_id" id="image-id-0" value="<?php echo $marker_thumbnail_id; ?>">
				<p><a href="" class="thickbox" id="file-0"></a></p>
				<a href="<?php echo esc_url( $image_library_url ); ?>" rel="0" class="thickbox upload-image thumb">Upload</a>
			</div>
			<div class="row">
				<label>Link:</label>
				<input type="text" name="marker_link" id="marker_link" value="<?php echo $marker_link; ?>">
			</div>
			<div class="upload-heading">
				<h3>Upload models / Videos</h3>
				<small>*Before submitting a model, please refer to the modelling guide for best practises on how to create your models for the application. Max upload file is 40mb?</small>
			</div>
			
			<?php include('upload-block.php');?>
						
			<div class="bottom-row">
				<label>Please select one of the below</label>
			</div>
			<div class="bottom-row">
				<div class="checkbox">
					<input type="radio" name="optimisation_request" value="no" <?php if ($optimisation_request == 'no'){ echo 'checked';}?> >
				</div>
				<p>I have uploaded models which are optimised in conjuction with the instructions from the <a href="#">Modelling Guide</a></p>
			</div>
			<div class="bottom-row">
				<div class="checkbox">
					<input type="radio" name="optimisation_request" value="yes" <?php if ($optimisation_request == 'yes'){ echo 'checked';}?>>
				</div>
				<p>I request Virtualiis to optimise the models to best viewing.<br><small> (Please allow a minimum 24/48hours to process the models. Virtualiis will be contact with an estimate cost for the rendering.</small> </p>
			</div>
			<div class="cf">
				<input type="button" class="submit" onclick="document.create_marker_form.FormAction.value='CreateNewMarker';document.create_marker_form.submit();" value="Submit & Pay">
			</div>
		</form>
	</div>

		
	
	
	<?php include('sidebar-my-account.php');?>
</div>
<?php get_footer(); ?>