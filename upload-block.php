			<?php if(!empty($marker_attachments)){
					$att_counter = 1;
					foreach($marker_attachments as $attachmnet_id){
					$attachmnet = get_post($attachmnet_id);
					//print_r($attachmnet);
					$path_parts = pathinfo($attachmnet->guid);
					$attachment_file_name = $path_parts["basename"];
					?>
			<div class="upload-row">
				<input type="hidden" id="image-url-<?php echo $att_counter;?>" name="marker_attachmnet[<?php echo $att_counter;?>][att_url]" value="<?php echo $attachmnet->guid; ?>">
				<input type="hidden" id="image-id-<?php echo $att_counter;?>" name="marker_attachmnet[<?php echo $att_counter;?>][att_id]" value="<?php echo $attachmnet->ID; ?>">			
				<div  id="no-attach-<?php echo $att_counter;?>" class="no-attach">
					<span class="file" id="file-<?php echo $att_counter;?>"><?php echo $attachment_file_name; ?></span>
					<p class="description" id="description-<?php echo $att_counter;?>">Description: <?php echo $attachmnet->post_content; ?></p>
					<a href="#" rel="<?php echo $att_counter;?>"  class="delete">delete</a><a href="<?php echo esc_url( $image_library_url ); ?>" rel="<?php echo $att_counter;?>" class="edit upload-image thickbox">Edit /</a>			
				</div>
				<a href="<?php echo esc_url( $image_library_url ); ?>" rel="<?php echo $att_counter;?>" style="display:none" class="thickbox upload-image">Upload</a>
			</div>			
			<?php }	
				$start_i = count($marker_attachments)+1;
				$num_att = count($marker_attachments)+5;			
			}else{
				$start_i = 1;
				$num_att = 5;
			}?>
			<?php for($i=$start_i;$i<=$num_att;$i++){ ?>				
			<div class="upload-row">
				<input type="hidden" id="image-url-<?php echo $i;?>" name="marker_attachmnet[<?php echo $i;?>][att_url]" value="">
				<input type="hidden" id="image-id-<?php echo $i;?>" name="marker_attachmnet[<?php echo $i;?>][att_id]" value="">			
				<div  id="no-attach-<?php echo $i;?>" class="no-attach" style="display:none">
					<span class="file" id="file-<?php echo $i;?>">&nbsp;</span>
					<p class="description" id="description-<?php echo $i;?>">&nbsp;</p>
					<a href="#" rel="<?php echo $i;?>"  class="delete">delete</a><a href="<?php echo esc_url( $image_library_url ); ?>" rel="<?php echo $i;?>" class="edit upload-image thickbox">Edit /</a>			
				</div>
				<a href="<?php echo esc_url( $image_library_url ); ?>" rel="<?php echo $i;?>" class="thickbox upload-image">Upload</a>
			</div>			
			<?php } ?>
<script type="text/javascript">
	//var next_template_id = <?php echo $last_template_id + 1;?>;
	jQuery(window).load(function(){

		//jQuery(document).on("click", "a.upload-image", function(){
		jQuery("a.upload-image").click(function(){
		
			jQuery("input").removeClass("current-att-id");
			jQuery("input").removeClass("current-att-url");
			jQuery("p").removeClass("current-att-description");
			jQuery(".file").removeClass("current-att-file");			
			jQuery("a").removeClass("current-upload-image");
			jQuery(".no-attach").removeClass("current-no-attach");
			jQuery(this).addClass("current-upload-image");
			
			//jQuery("image, img").removeClass("current-image");
		
			var attachmnet_id = jQuery(this).attr("rel");
			jQuery("#image-id-"+attachmnet_id).addClass("current-att-id");
			jQuery("#image-url-"+attachmnet_id).addClass("current-att-url");
			jQuery("#description-"+attachmnet_id).addClass("current-att-description");
			jQuery("#file-"+attachmnet_id).addClass("current-att-file");
			jQuery("#no-attach-"+attachmnet_id).addClass("current-no-attach");
			
			//jQuery("#template-image-"+attachmnet_id).addClass("current-image");
		});
		
		jQuery("a.delete").click(function(){
		
			var attachmnet_id = jQuery(this).attr("rel");
			jQuery("#image-id-"+attachmnet_id).val('');
			jQuery("#image-url-"+attachmnet_id).val('');
			jQuery("#description-"+attachmnet_id).html('');
			jQuery("#file-"+attachmnet_id).html('');
			jQuery("#no-attach-"+attachmnet_id).hide();	
			jQuery("a.upload-image[rel='"+attachmnet_id+"']").show();						
			return false;
		});
	
	});
</script>				