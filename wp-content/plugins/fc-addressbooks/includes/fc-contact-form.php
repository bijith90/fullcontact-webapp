<?php
// Address Form
function fc_contact_form() {
	?>
	<form name="address_form" id="address_form" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" method="post">
		<div class="form-group row">
			<div class="col-sm-12">
		    	<input type="text" name="firstname" id="firstname" class="form-control" placeholder="First Name" required data-parsley-required-message="First Name is required" value="<?php isset( $_POST["firstname"] ) ? esc_attr( $_POST["firstname"] ) : '' ; ?>">
		  	</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
		    	<input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last Name" required data-parsley-required-message="Last Name is required" value="<?php isset( $_POST["lastname"] ) ? esc_attr( $_POST["lastname"] ) : '' ; ?>">
		  	</div>
		</div>
		<div class="form-group row">
		  	<div class="col-sm-12">
		    	<input type="email" name="address-email" id="address-email" class="form-control" placeholder="Email" required data-parsley-type="email" data-parsley-required-message="Email ID is required" data-parsley-type-message="Invalid Email ID" value="<?php isset( $_POST["address-email"] ) ? esc_attr( $_POST["address-email"] ) : '' ; ?>">
		  	</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
		    	<input type="tel" name="phone" id="phone" class="form-control" placeholder="Phone" required data-parsley-required-message="Phone number is required" value="<?php isset( $_POST["phone"] ) ? esc_attr( $_POST["phone"] ) : '' ; ?>" >
		  	</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				<?php wp_nonce_field( 'check_the_user', 'fc_form_verifier_nonce' ); ?>
		      	<button type="submit" name="fc-contact-form-submit" class="btn btn-primary">SUBMIT</button>
		    </div>
		</div>
	</form>

	<script>
		jQuery(function($){
			$("#address_form").parsley();
		});
	</script>
	<?php
}

// Check if key value already exist
function fc_check_keyvalue_exist($key, $value) {

	$email_check_args = array(
	  'post_type' => 'fc_address',
	  'meta_query' => array(
	      array(
	          'key' => $key,
	          'value' => $value
	      )
	  ),
	  'fields' => 'ids'
	);

	$email_check_query = new WP_Query( $email_check_args );

	if ( $email_check_query->post_count > 0 ) {
	    
	    return true;

	} else {

		return false;
	}
}

// Call fullcontact api using email id and get additional address info
function fc_get_additional_address_info($email) {

	$data = array('emails'=> array($email));
	 
	$data_json = json_encode($data);
	 
	$url = 'https://api.fullcontact.com/v3/person.enrich';
	 
	$ch = curl_init();
	 
	curl_setopt($ch, CURLOPT_URL, $url);
	 
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer RzLfgEPtARK0JyWXlPcVAN8C0SXvaiiu', 'Content-Type: application/json'));
	 
	curl_setopt($ch, CURLOPT_POST, 1);
	 
	curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
	 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 
	$response  = curl_exec($ch);

	$response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	 
	curl_close($ch);

	if( $response_code == 200) {
		return $response;
	} else {
		return false;
	}
} 

// Submit and save address form data
function fc_submit_contact_form() {

	if( isset( $_POST['fc-contact-form-submit'] ) && wp_verify_nonce( $_POST['fc_form_verifier_nonce'], 'check_the_user' ) ) {

		// Variables
		$address_fields = array();

		// Sanitize fields
		$firstname = sanitize_text_field( $_POST["firstname"] );
		$lastname = sanitize_text_field( $_POST["lastname"] );
        $email = sanitize_email( $_POST["address-email"] );
        $phone = sanitize_text_field( $_POST["phone"] );

        // Check if email exist
        $check_email_exist = fc_check_keyvalue_exist('address_email', $email);

        if( $check_email_exist ) {
        	echo '<div class="response"><p class="error">Email already exist</p></div>';
        	return;
        }

        // Check if phone exist
        $check_phone_exist = fc_check_keyvalue_exist('address_phone', $phone);

        if( $check_phone_exist ) {
        	echo '<div class="response"><p class="error">Phone number already exist</p></div>';
        	return;
        }

        $address_fields = array(
    		'firstname' => $firstname,
    		'lastname' => $lastname,
    		'address_email' => $email,
    		'address_phone' => $phone
        );

        // Call API and get additional address info
        $additional_address_info = fc_get_additional_address_info($email);

        // Enrich address
        if( $additional_address_info ) {

        	$additional_address_info = json_decode($additional_address_info);

        	$address_extra_fields = array(
        		'full_name' => $additional_address_info->fullName,
        		'age_range' => $additional_address_info->ageRange,
        		'gender' => $additional_address_info->gender,
        		'location' => $additional_address_info->location,
        		'organization' => $additional_address_info->organization,
        		'twitter' => $additional_address_info->twitter,
        		'linkedin' => $additional_address_info->linkedin,
        		'facebook' => $additional_address_info->facebook,
        		'bio' => $additional_address_info->bio,
        		'avatar' => $additional_address_info->avatar,
        		'website' => $additional_address_info->website,
        		'details' => json_encode($additional_address_info->details)
        	);

        	$address_fields = array_merge($address_fields, $address_extra_fields);
        }
        
       
        // Saving the address
        $address_array = array(
        	'post_title' => $firstname." ".$firstname,
        	'post_status' => 'publish',
        	'post_type' => 'fc_address',
        	'meta_input' => $address_fields	
        );

        $save_address = wp_insert_post($address_array);

        if( $save_address ) {
        	echo '<div class="response"><p class="success">Contact Saved</p></div>';
        } else {
        	echo '<div class="response"><p class="success">Error! Please try again</p></div>';
        }
	}
}

// Address form shortcode
function fc_address_form_shortcode() {

	ob_start();
	fc_contact_form();
    fc_submit_contact_form();
    return ob_get_clean();

}

add_shortcode( 'fc_address_form', 'fc_address_form_shortcode' ); // Use shortcode [fc_address_form]