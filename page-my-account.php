<?php
/*
Template Name: My Account Page
*/

if ( !is_user_logged_in() ) {
	wp_redirect(wp_login_url());
	exit;
}else{
	global $current_user;
	global $woocommerce;
    get_currentuserinfo();
}	

	$user_name = $current_user->display_name;
	$user_email = $current_user->user_email;
	$user_position = get_user_meta($current_user->ID, 'user_position', true);
	$user_company = get_user_meta($current_user->ID, 'user_company', true);
	$user_abn = get_user_meta($current_user->ID, 'user_abn', true);
	$user_address = get_user_meta($current_user->ID, 'user_address', true);
	$user_phone = get_user_meta($current_user->ID, 'user_phone', true);
	
	//echo '<pre>';
	//print_r($current_user);
	//echo '</pre>';
	
$FormAction = $_POST['FormAction'];

if($FormAction == 'UpdateUser'){
	//echo '<pre>';
	//print_r($_POST);
	//echo '</pre>';

	$user_name = trim($_POST['user_name']);
	$user_position = $_POST['user_position'];
	$user_company = $_POST['user_company'];
	$user_abn = $_POST['user_abn'];
	$user_address = $_POST['user_address'];
	$user_email = $_POST['user_email'];
	$user_phone = $_POST['user_phone'];
	//$new_user_billing_contact = $_POST['user_billing_contact'];
	
	if (!strlen($user_name)) {
		$sError .= '<b>Name</b> is required field.<br>';
	}	
	if (!strlen($user_email)) {
		$sError .= '<b>Email</b> is required field.<br>';
	} else if (!ereg("^[a-zA-Z0-9\.\_\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$", $user_email)) {
		$sError .= '<b>email address</b> is incorrect.<br>';
	} elseif(email_exists($user_email) !== false && $user_email != $current_user->user_email){
		$sError .= '<b>This email already in use</b><br>';	
	}
	if (!strlen($user_position)) {
		$sError .= '<b>Position</b> is required field.<br>';
	}
	if (!strlen($user_company)) {
		$sError .= '<b>Company</b> is required field.<br>';
	}
	if (!strlen($user_abn)) {
		$sError .= '<b>ABN/ACN</b> is required field.<br>';
	}
	if (!strlen($user_address)) {
		$sError .= '<b>Address</b> is required field.<br>';
	}
	if (!strlen($user_phone)) {
		$sError .= '<b>Phone</b> is required field.<br>';
	}
	//if (!strlen($new_user_billing_contact)) {
	//	$sError .= '<b>Billing Contact</b> is required field.<br>';
	//}	

	
	if ($sError == '') {	
	
		$user_name_array = explode(" ", $user_name, 2);
		$user_firstname = $user_name_array[0];
		$user_lastname = $user_name_array[1];		
		
		
		update_user_meta( $current_user->ID, 'display_name', $user_name );
		update_user_meta( $current_user->ID, 'user_firstname', $user_firstname );
		update_user_meta( $current_user->ID, 'user_lastname', $user_lastname );
		
		update_user_meta( $current_user->ID, 'user_position', $user_position );
		update_user_meta( $current_user->ID, 'user_company', $user_company );
		update_user_meta( $current_user->ID, 'user_abn', $user_abn );
		update_user_meta( $current_user->ID, 'user_address', $user_address );
		update_user_meta( $current_user->ID, 'user_phone', $user_phone );
		//update_user_meta( $user_id, 'user_billing_contact', $new_user_billing_contact );
		$sSuccess = 1;
		
	}
/*
		$user_name = trim($_POST['user_name']);
		$user_position = $_POST['user_position'];
		$user_company = $_POST['user_company'];
		$user_abn = $_POST['user_abn'];
		$user_address = $_POST['user_address'];
		$user_email = $_POST['user_email'];
		$user_phone = $_POST['user_phone'];
	*/	
	
}
?>
<?php get_header(); ?>
<div id="main" class="account-page">
	<div id="content">
		<h1>My Account</h1>
		<div class="info-blocks">
		<?php if ($sError != '') { ?>
			  <div class="errors"><?php echo($sError); ?></div>
		<?php } ?>	
		<?php if($sSuccess == 1){?>
			  <div class="success">Your data successfully updated</div>
		<?php }?>	
		<form action="" class="account-form" name="account_form" method="POST">
		<input type="hidden" name="FormAction" value="" >
		<input type="hidden" name="user_id" value="<?php echo $current_user->ID;?>" >		
			<div class="info-row">
				<span class="blue">Name:</span>
				<span class="value"><?php echo $user_name;?></span>
				<input type="text" name="user_name" id="user_name" style="display:none" value="<?php echo $user_name;?>">
				<a href="#" class="edit">Edit</a>
			</div>
			<div class="info-row">
				<span class="blue">Position:</span>
				<span class="value"><?php echo $user_position; ?></span>
				<input type="text" name="user_position" id="user_position" style="display:none" value="<?php echo $user_position;?>">				
				<a href="#" class="edit">Edit</a>
			</div>			
			<div class="info-row">
				<span class="blue">Company:</span>
				<span class="value"><?php echo $user_company; ?></span>
				<input type="text" name="user_company" id="user_company" style="display:none" value="<?php echo $user_company;?>">				
				<a href="#" class="edit">Edit</a>
			</div>
			<div class="info-row">
				<span class="blue">ABN/ACN:</span>
				<span class="value"><?php echo $user_abn; ?></span>
				<input type="text" name="user_abn" id="user_abn" style="display:none" value="<?php echo $user_abn;?>">				
				<a href="#" class="edit">Edit</a>
			</div>
			<div class="info-row">
				<span class="blue">Address:</span>
				<span class="value"><?php echo $user_address; ?></span>
				<input type="text" name="user_address" id="user_address" style="display:none" value="<?php echo $user_address;?>">				
				<a href="#" class="edit">Edit</a>
			</div>			
			<div class="info-row">
				<span class="blue">Email:</span>
				<span  class="value"><a href="mailto:<?php echo $user_email;?>"><?php echo $user_email;?></a></span>
				<input type="text" name="user_email" id="user_email" style="display:none" value="<?php echo $user_email;?>">				
				<a href="#" class="edit">Edit</a>
			</div>
			<div class="info-row">
				<span class="blue">Phone:</span>
				<span class="value"><?php echo $user_phone; ?></span>
				<input type="text" name="user_phone" id="user_phone" style="display:none" value="<?php echo $user_phone;?>">				
				<a href="#" class="edit">Edit</a>
			</div>
			<div class="cf">
				<input type="button" class="submit" value="submit" onclick="document.account_form.FormAction.value='UpdateUser';document.account_form.submit();">
			</div>			
		</form>
		</div>
		<div class="reset-password">
			<a href="/my-account/change-password/">Reset Password </a>
		</div>
		
		<?php echo do_shortcode('[woocommerce_edit_address]'); ?>
		
		<?php echo do_shortcode('[woocommerce_view_order]'); ?>
		
		<p>(If you delete an order, how can this update the billing System?</p>
		<p>Possibly an email request for starters?</p>
		<p>AS WE NEED TO BILL FOR THE HOSTING.</p>
	</div>
<script type="text/javascript">
	jQuery(window).load(function(){
		jQuery(".info-row a.edit").click(function(){
			var link_text = jQuery(this).text();
			if(link_text == 'Edit'){
				jQuery(this).prev().show();
				jQuery(this).parent().find("span.value").hide();
				jQuery(this).text('OK');
			}else{
				var content = jQuery(this).parent().find("input").val();
				jQuery(this).parent().find("span.value").html(content);
				jQuery(this).parent().find("span.value").show();
				jQuery(this).parent().find("input").hide();
				jQuery(this).text('Edit');
			}
			return false;
		});
	});
</script>	
	<?php include('sidebar-my-account.php');?>
	
</div>
<?php get_footer(); ?>