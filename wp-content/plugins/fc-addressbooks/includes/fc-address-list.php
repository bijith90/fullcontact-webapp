<?php
// Address Listing Table
function fc_display_address_list($addresses) {
	if( $addresses ) {
	?>
	<table id="address_list" class="display">
	    <thead>
	        <tr>
	            <th><?php echo __('Sl.No', 'fcaddressbooks'); ?></th>
	            <th><?php echo __('First Name', 'fcaddressbooks'); ?></th>
	            <th><?php echo __('Last Name', 'fcaddressbooks'); ?></th>
	            <th><?php echo __('Email', 'fcaddressbooks'); ?></th>
	            <th><?php echo __('Phone', 'fcaddressbooks'); ?></th>
	            <th><?php echo __('Actions', 'fcaddressbooks'); ?></th>
	        </tr>
	    </thead>
	    <tbody>
	    	<?php for ($i=0, $j=1; $i < count( $addresses ); $i++, $j++) { ?>
	        <tr>
	            <td><?php echo $j; ?></td>
	            <td><?php echo $addresses[$i]['firstname']; ?></td>
	            <td><?php echo $addresses[$i]['lastname']; ?></td>
	            <td><?php echo $addresses[$i]['address_email']; ?></td>
	            <td><?php echo $addresses[$i]['address_phone']; ?></td>
	            <td>
	            	<div class="delete-address">
	            		<form name="delete_address_form_<?php echo $i; ?>" id="delete_address_form_<?php echo $i; ?>" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" method="post" onsubmit="return confirm('Are you sure ?');">
							<input type="hidden" name="post_id" value="<?php echo $addresses[$i]['post_id']; ?>">
							<?php wp_nonce_field( 'delete_the_address', 'fc_form_deletion_nonce' ); ?>
	            			<button type="submit" name="delete-address" class="btn btn-danger" >Delete</button>
	            			
	            		</form>
	            	</div>
	            	<div class="view-address">

	            		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#address_modal_<?php echo $i; ?>">
	            		  View
	            		</button>
	            		
	            		<div class="modal fade" id="address_modal_<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	            		  <div class="modal-dialog" role="document">
	            		    <div class="modal-content">
	            		      <div class="modal-header text-center">
	            		      	<h5>Address Details</h5>
	            		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            		          <span aria-hidden="true">&times;</span>
	            		        </button>
	            		      </div>
	            		      <div class="modal-body">
	            		        <p><strong>First Name:</strong> <?php echo $addresses[$i]['firstname']; ?></p>
	            		        <p><strong>Last Name:</strong> <?php echo $addresses[$i]['lastname']; ?></p>
	            		        <p><strong>Email:</strong> <?php echo $addresses[$i]['address_email']; ?></p>
	            		        <p><strong>Phone:</strong> <?php echo $addresses[$i]['address_phone']; ?></p>
	            		      </div>
	            		      <div class="modal-footer">
	            		        
	            		      </div>
	            		    </div>
	            		  </div>
	            		</div>
	            	</div>
	        	</td>
	        </tr>
		    <?php } ?>
	    </tbody>
	</table>

	<script>
		jQuery(function($){
			$(document).ready( function () {
			    $('#address_list').DataTable();
			});
		});
	</script>

<?php
	} else {
		echo '<p class="no-result">'.__('No addresses found', 'fcaddressbooks').'</p>';
	}
}

// Get Addresses
function fc_get_adrresses() {

	$address_fields = array();

	$address_arg = array(
	  'post_type'         => 'fc_address',
	  'post_status' => 'publish',
	  'posts_per_page'    => -1,
	  'orderby' => 'date',
	  'order' => 'DESC'
	);

	// Get addresses
	$addresses = new WP_Query( $address_arg );

	if( $addresses->post_count > 0 ) {

		// Get address post meta data and store in array
		while ( $addresses->have_posts() ) : $addresses->the_post();

			$address_field = array(
				'post_id' => get_the_ID(),
				'firstname' => get_post_meta(get_the_ID(), 'firstname')[0],
				'lastname' => get_post_meta(get_the_ID(), 'lastname')[0],
				'address_email' => get_post_meta(get_the_ID(), 'address_email')[0],
				'address_phone' => get_post_meta(get_the_ID(), 'address_phone')[0]
			);

			// Push address field to address_fields array
			array_push($address_fields, $address_field);

		endwhile; wp_reset_postdata();

		return $address_fields;

	} else {

		return false;

	}
}

// Delete address
function fc_delete_address() {

	if( isset( $_POST['delete-address'] ) && wp_verify_nonce( $_POST['fc_form_deletion_nonce'], 'delete_the_address' ) ) {

		$post_id = sanitize_text_field( $_POST["post_id"] );

		$delete_post = wp_delete_post( $post_id );

		if( $delete_post ) {
			// echo '<div class="response"><p class="success">Address Deleted</p></div>';
			echo "<script type='text/javascript'>
			        window.location=document.location.href;
			        </script>";
		} else {
			echo '<div class="response"><p class="success">Error! Please try again</p></div>';
		}
	}
}

// Address list shortcode
function fc_address_list_shortcode() {

	ob_start();
	$addresses = fc_get_adrresses();
    fc_display_address_list($addresses);
    fc_delete_address();
    return ob_get_clean();

}

add_shortcode( 'fc_address_list', 'fc_address_list_shortcode' ); // Use shortcode [fc_address_list]