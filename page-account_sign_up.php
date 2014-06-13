<?php
/*
Template Name: Account Sign Up Page
*/

//echo '<pre>';
//print_r($_POST);
//echo '</pre>';
if ( is_user_logged_in() ) {
	wp_redirect('/my-account/');
	exit;
}	

$sError = '';
$sSuccess = 0;


$FormAction = $_POST['FormAction'];

if($FormAction == 'CreateUser'){

	$new_user_login = trim($_POST['user_login']);
	$new_user_name = trim($_POST['user_name']);
	$new_user_position = $_POST['user_position'];
	$new_user_company = $_POST['user_company'];
	$new_user_abn = $_POST['user_abn'];
	$new_user_address = $_POST['user_address'];
	$new_user_email = $_POST['user_email'];
	$new_user_phone = $_POST['user_phone'];
	$new_user_billing_contact = $_POST['user_billing_contact'];
	$agree = $_POST['agree'];
	
	if (!strlen($new_user_login)) {
		$sError .= '<b>Login</b> is required field.<br>';
	}elseif( username_exists( $new_user_login )) {
		$sError .= '<b>Login in use!</b> Select other login please.<br>';
	}
	if (!strlen($new_user_name)) {
		$sError .= '<b>Name</b> is required field.<br>';
	}	
	if (!strlen($new_user_email)) {
		$sError .= '<b>Email</b> is required field.<br>';
	} else if (!ereg("^[a-zA-Z0-9\.\_\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$", $new_user_email)) {
		$sError .= '<b>email address</b> is incorrect.<br>';
	} elseif(email_exists($new_user_email) !== false){
		$sError .= '<b>This email already in use</b><br>';	
	}
	if (!strlen($new_user_position)) {
		$sError .= '<b>Position</b> is required field.<br>';
	}
	if (!strlen($new_user_company)) {
		$sError .= '<b>Company</b> is required field.<br>';
	}
	if (!strlen($new_user_abn)) {
		$sError .= '<b>ABN/ACN</b> is required field.<br>';
	}
	if (!strlen($new_user_address)) {
		$sError .= '<b>Address</b> is required field.<br>';
	}
	if (!strlen($new_user_phone)) {
		$sError .= '<b>Phone</b> is required field.<br>';
	}
	if (!strlen($new_user_billing_contact)) {
		$sError .= '<b>Billing Contact</b> is required field.<br>';
	}	
	if ($agree != 'yes'){
		$sError .= '<b>Please agree with the Terms & Conditions<br>';	
	}
	
	if ($sError == '') {	
	
		$user_name_array = explode(" ", $new_user_name, 2);
		$user_firstname = $user_name_array[0];
		$user_lastname = $user_name_array[1];		
		
		$random_password = wp_generate_password( 6, $include_standard_special_chars=false );
		$user_id = wp_create_user( $new_user_login, $random_password, $new_user_email );

		wp_new_user_notification( $user_id, $random_password );	
		
		add_user_meta( $user_id, 'display_name', $new_user_name );
		add_user_meta( $user_id, 'user_firstname', $user_firstname );
		add_user_meta( $user_id, 'user_lastname', $user_lastname );
		
		add_user_meta( $user_id, 'user_position', $new_user_position );
		add_user_meta( $user_id, 'user_company', $new_user_company );
		add_user_meta( $user_id, 'user_abn', $new_user_abn );
		add_user_meta( $user_id, 'user_address', $new_user_address );
		add_user_meta( $user_id, 'user_phone', $new_user_phone );
		add_user_meta( $user_id, 'user_billing_contact', $new_user_billing_contact );
		$sSuccess = 1;

		/*
		$creds = array();
		$creds['user_login'] = $new_user_name;
		$creds['user_password'] = $random_password;
		$creds['remember'] = true;
		$user = wp_signon( $creds, false );
		*/
		wp_redirect(get_bloginfo('url').'/thank-you-for-registration');
		exit();
	}

}

?>
<?php get_header(); ?>
<div id="main">
	<div class="account-signup-block">
		<h1>Account Sign Up</h1>
		<?php if ($sError != '') { ?>
			  <div class="errors"><?php echo($sError); ?></div>
		<?php } ?>		
		<form action="" class="account-signup-form" name="signup_form" method="POST">
		<input type="hidden" name="FormAction" value="" >
			<div class="row">
				<label>Login name:</label>
				<input type="text" name="user_login" id="user_login" value="<?php echo $new_user_login; ?>">
			</div>		
			<div class="row">
				<label>NAme:</label>
				<input type="text" name="user_name" id="user_name" value="<?php echo $new_user_name; ?>">
			</div>
			<div class="row">
				<label>Position:</label>
				<input type="text" name="user_position" id="user_position" value="<?php echo $new_user_position; ?>">
			</div>
			<div class="row">
				<label>Company:</label>
				<input type="text" name="user_company" id="user_company" value="<?php echo $new_user_company; ?>">
			</div>
			<div class="row">
				<label>ABN/ACN:</label>
				<input type="text" name="user_abn" id="user_abn" value="<?php echo $new_user_abn; ?>">
			</div>
			<div class="row">
				<label>Address:</label>
				<input type="text" name="user_address" id="user_address" value="<?php echo $new_user_address; ?>">
			</div>
			<div class="row">
				<label>Email:</label>
				<input type="email" name="user_email" id="user_email" value="<?php echo $new_user_email; ?>">
			</div>
			<div class="row">
				<label>Phone:</label>
				<input type="text" name="user_phone" id="user_phone" value="<?php echo $new_user_phone; ?>">
			</div>
			<div class="row">
				<label>Billing Contact:</label>
				<input type="text" name="user_billing_contact" id="user_billing_contact" value="<?php echo $new_user_billing_contact; ?>">
			</div>
		<div class="bottom-row">
			<div class="checkbox">
				<input type="checkbox" name="agree" id="agree" value="yes">
			</div>
			<p>I Agree to the <a href="<?php bloginfo('url');?>/terms-and-conditions/">Terms &amp; Conditions</a></p>
		</div>
		<input type="button" class="submit" onclick="document.signup_form.FormAction.value='CreateUser';document.signup_form.submit();" value="Sign Up">
		</form>
	</div>
</div>
<?php get_footer(); ?>