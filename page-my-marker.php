<?php
/*
Template Name: My Marker
*/

if ( !is_user_logged_in() ) {
	wp_redirect(wp_login_url());
	exit;
}else{
	global $current_user;
	global $woocommerce;
    get_currentuserinfo();
	
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
	$marker_id = get_query_var('page');
	}elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
	$marker_id = $_POST['marker_id'];
	}
	//$marker = get_post($marker_id);
	$marker = get_marker($marker_id);
	
	//echo '<pre>';
	//print_r($marker);
	//echo '</pre>';
	
	if($marker->post_author != $current_user->ID){
		echo 'Error: It\'s not your marker';
		exit;
	}
}
include(ABSPATH . '/wp-admin/includes/media.php');
$image_library_url = get_upload_iframe_src( 'image', null, 'library' );
$image_library_url = remove_query_arg( array('TB_iframe'), $image_library_url );
$image_library_url = add_query_arg( array( 'context' => 'marker', 'TB_iframe' => 1 ), $image_library_url );


	$marker_name = $marker->marker_name;
	$marker_author = $marker->marker_author;
	$marker_link = $marker->marker_link;
	$marker_description = $marker->marker_description;
	$marker_thumbnail = $marker->thumbnail;
	$marker_name = $marker->marker_name;
	$marker_attachments = $marker->marker_attachment;


$sError = '';
$sSuccess = 0;
$FormAction = $_POST['FormAction'];

	//echo '<pre>';
	//print_r($_POST);
	//echo '</pre>';

if($FormAction == 'UpdateMarker'){
	
	$marker_name = trim($_POST['marker_name']);
	$marker_author = trim($_POST['marker_author']);
	$marker_description = strip_tags($_POST['marker_description']);
	$marker_link = strip_tags($_POST['marker_link']);
	$marker_thumbnail_id = trim($_POST['marker_thumbnail_id']);
	$marker_thumbnail = $marker_thumbnail_id;

	$is_optimised = $_POST['is_optimised'];
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
		
		$up_marker = array(
		  'ID'			  => $marker_id,	
		  'post_title'    => $marker_name,
		  'post_content'  => $marker_description,
		  'post_status'   => 'publish',
		  'post_author'   => $current_user->ID,
		  'post_type'	  => 'product'
		);		
		
		wp_update_post($up_marker);

			
			update_post_meta( $marker_id, 'marker_author', $marker_author );
			update_post_meta( $marker_id, 'marker_link', $marker_link );
			
			if($marker_attachments != $marker->marker_attachment){
			update_post_meta( $marker_id, 'marker_status', 'received' );
			}
			
			update_post_meta( $marker_id, '_thumbnail_id', $marker_thumbnail_id );
			
			foreach($marker_attachments as $att_id){
				update_post_meta( $marker_id, 'marker_attachment', $att_id );
			}
						
			$sSuccess = 1;
	}	
		
}

?>
<?php get_header(); ?>
<div id="main" class="model-management">
	<div id="content">
		<h1>Virtualiis Business Card</h1>
		<div class="management-block">
		<?php if ($sError != '') { ?>
			  <div class="errors"><?php echo($sError); ?></div>
		<?php } ?>			
		<form action="" class="marker-form" name="update_marker_form" method="POST">
		<input type="hidden" name="FormAction" value="" >	
		<input type="hidden" name="marker_id" value="<?php echo $marker_id; ?>" >		
			<div class="row">
				<span class="blue">Marker Name:</span>
				<p><?php echo $marker_name;?></p>
				<input type="text" name="marker_name" id="marker_name" style="display:none" value="<?php echo $marker_name;?>">
				<a href="#" class="edit">edit</a>
			</div>
			<div class="row">
				<span class="blue">Author:</span>
				<p><?php echo $marker_author;?></p>	
				<input type="text" name="marker_author" id="marker_author" style="display:none" value="<?php echo $marker_author;?>">				
				<a href="#" class="edit">edit</a>
			</div>
			<div class="row">
				<span class="blue">Description:</span>
				<p><?php echo $marker_description;?></p>
				<input type="text" name="marker_description" id="marker_description" style="display:none" value="<?php echo $marker_description;?>">				
				<a href="#" class="edit">edit</a>
			</div>
			<div class="row">
				<span class="blue">Thumbnail:</span>
				<input type="hidden" name="marker_thumbnail_url" id="image-url-0">
				<input type="hidden" name="marker_thumbnail_id" id="image-id-0" value="<?php echo $marker_thumbnail; ?>">
				<?php 	$thumb = get_post($marker_thumbnail);
						$thumb_parts = pathinfo($thumb->guid);
						$thumb_file_name = $thumb_parts["basename"];						
				?>
				<p><a href="<?php echo $thumb->guid;?>" class="thickbox" id="file-0"><?php echo $thumb_file_name; ?></a></p>				
				<a href="<?php echo esc_url( $image_library_url ); ?>" rel="0" class="thickbox upload-image thumb">edit</a>
				

			</div>
			<div class="row">
				<span class="blue">Link:</span>
				<p><?php echo $marker_link;?></p>
				<input type="text" name="marker_link" id="marker_link" style="display:none" value="<?php echo $marker_link;?>">								
				<a href="#" class="edit">edit</a>
			</div>
			<?php if($marker->marker_status == 'live'){?>
			<div class="download-row">
				<?php
				$file_paths = get_post_meta( $marker_id, '_file_paths', true );	
				if(is_array($file_paths)){
					foreach($file_paths as $fp){ ?>
				<a href="<?php echo $fp;?>" class="download">Download Marker</a>
				<?php }
				} ?>
			</div>
			<?php } ?>
			<div class="upload-heading">
				<h4>Upload models / Videos</h4>
				<span class="status"><span class="blue">Status:</span> <?php echo $marker->marker_status;?> </span>
			</div>
			
			<?php  ?>
			<?php include('upload-block.php');?>

			<!--
			<div class="diagram-block">
				<h3>Analytics Summary</h3>
				<img src="<?php echo TDU; ?>/images/img-8.jpg" alt="image description">
				<img src="<?php echo TDU; ?>/images/img-9.jpg" alt="image description">
			</div>
			-->
			<div class="cf">
				<input type="button" class="submit" onclick="document.update_marker_form.FormAction.value='UpdateMarker';document.update_marker_form.submit();" value="submit">
			</div>
			</form>
		</div>
	</div>
<script type="text/javascript">
	jQuery(window).load(function(){
		jQuery(".row a.edit").click(function(){
			var link_text = jQuery(this).text();
			if(link_text == 'edit'){
				jQuery(this).prev().show();
				jQuery(this).parent().find("p").hide();
				jQuery(this).text('ok');
			}else{
				var content = jQuery(this).parent().find("input").val();
				jQuery(this).parent().find("p").html(content);
				jQuery(this).parent().find("p").show();
				jQuery(this).parent().find("input").hide();
				jQuery(this).text('edit');
			}
			return false;
		});
	});
</script>	
	
	<?php include('sidebar-my-account.php');?>
</div>
<?php get_footer(); ?>