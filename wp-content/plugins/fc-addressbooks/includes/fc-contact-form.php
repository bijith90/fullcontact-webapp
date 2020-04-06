<?php
// Address Form
function fc_contact_form() {
	?>
	<form name="address_form" id="address_form" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" method="post">
		<div class="form-group row">
			<div class="col-sm-12">
		    	<input type="text" name="firstname" id="firstname" class="form-control" placeholder="First Name" required value="<?php isset( $_POST["firstname"] ) ? esc_attr( $_POST["firstname"] ) : '' ; ?>">
		  	</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
		    	<input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last Name" required value="<?php isset( $_POST["lastname"] ) ? esc_attr( $_POST["lastname"] ) : '' ; ?>">
		  	</div>
		</div>
		<div class="form-group row">
		  	<div class="col-sm-12">
		    	<input type="email" name="address-email" id="address-email" class="form-control" placeholder="Email" required value="<?php isset( $_POST["address-email"] ) ? esc_attr( $_POST["address-email"] ) : '' ; ?>">
		  	</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
		    	<input type="tel" name="phone" id="phone" class="form-control" placeholder="Phone" required value="<?php isset( $_POST["phone"] ) ? esc_attr( $_POST["phone"] ) : '' ; ?>" >
		  	</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				<?php wp_nonce_field( 'check_the_user', 'fc_form_verifier_nonce' ); ?>
		      	<button type="submit" name="fc-contact-form-submit" class="btn btn-primary">SUBMIT</button>
		    </div>
		</div>
	</form>
	<?php
}

// Check if email already exist
function fc_check_email_exist($email_id) {

	$email_check_args = array(
	  'post_type' => 'fc_address',
	  'meta_query' => array(
	      array(
	          'key' => 'address_email',
	          'value' => $email_id
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
        $check_email_exist = fc_check_email_exist($email);

        if( $check_email_exist ) {
        	echo '<div class="response"><p class="error">Email already exist</p></div>';
        	return;
        }

        $address_fields = array(
    		'firstname' => $firstname,
    		'lastname' => $lastname,
    		'address_email' => $email,
    		'address_phone' => $phone
        );

        // Enrich Address

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