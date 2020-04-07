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
	            		
	            		<div class="modal fade bd-example-modal-lg address-modal" id="address_modal_<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	            		  <div class="modal-dialog modal-lg" role="document">
	            		    <div class="modal-content">
	            		      <div class="modal-header text-center">
	            		      	<h5>Enriched Address Details</h5>
	            		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            		          <span aria-hidden="true">&times;</span>
	            		        </button>
	            		      </div>
	            		      <div class="modal-body">
	            		      	<h6>Basic Details</h6>
	            		      	<br/>
	            		      	<div class="details">
	            		      		<p><strong>First Name:</strong> <?php echo $addresses[$i]['firstname']; ?></p>
	            		      		<p><strong>Last Name:</strong> <?php echo $addresses[$i]['lastname']; ?></p>
	            		      		<p><strong>Email:</strong> <?php echo $addresses[$i]['address_email']; ?></p>
	            		      		<p><strong>Phone:</strong> <?php echo $addresses[$i]['address_phone']; ?></p>
	            		      	</div>
								<hr>
	            		        <h6>More Details</h6>
	            		        <br/>
	            		        <div class="details">
		            		        <p><strong>Full Name:</strong> <?php echo $addresses[$i]['full_name']; ?></p>
		            		        <p><strong>Age Range:</strong> <?php echo $addresses[$i]['age_range']; ?></p>
		            		        <p><strong>Gender:</strong> <?php echo $addresses[$i]['gender']; ?></p>
		            		        <p><strong>Location:</strong> <?php echo $addresses[$i]['location']; ?></p>
		            		        <p><strong>Organization:</strong> <?php echo $addresses[$i]['organization']; ?></p>
		            		        <p><strong>Twitter:</strong> <?php echo $addresses[$i]['twitter']; ?></p>
		            		        <p><strong>Linkedin:</strong> <?php echo $addresses[$i]['linkedin']; ?></p>
		            		        <p><strong>Facebook:</strong> <?php echo $addresses[$i]['facebook']; ?></p>
		            		        <p><strong>Bio:</strong> <?php echo $addresses[$i]['bio']; ?></p>
		            		        <p><strong>Avatar:</strong> 
		            		        	<?php if( $addresses[$i]['avatar'] ) { ?>
											<img src="<?php echo $addresses[$i]['avatar']; ?>" alt="Avatar" width="100" height="100">
		            		        	<?php } ?> 
		            		        </p>
		            		        <p><strong>Website:</strong> <?php echo $addresses[$i]['website']; ?></p>
		            		    </div>
		            		    <?php if( $addresses[$i]['details'] ) { ?>
	            		        <hr>
	            		        <h6>Extra Details</h6>
								<br/>
	            		        <?php 
	            		        $extra_details = json_decode($addresses[$i]['details']);
	            		        // var_dump($extra_details);
	            		        ?>
	            		        <div class="details">
	            		        	<ul>
	            		        		<li><p><strong>Name:</strong></p>
											<ul>
												<li><p><strong>Given:</strong> <?php echo $extra_details->name->given; ?></p></li>
												<li><p><strong>Family:</strong> <?php echo $extra_details->name->family; ?></p></li>
												<li><p><strong>Full:</strong> <?php echo $extra_details->name->full; ?></p></li>
											</ul>
	            		        		</li>
	            		        		<li><p><strong>Age:</strong><?php echo $extra_details->age; ?></p> </li>
	            		        		<li><p><strong>Gender:</strong><?php echo $extra_details->gender; ?></p> </li>
	            		        		<li><p><strong>Demographics:</strong></p> 
											<ul>
												<li><p><strong>Gender:</strong><?php echo $extra_details->demographics->gender; ?></p> </li>
											</ul>
	            		        		</li>
	            		        		<li><p><strong>Emails:</strong><?php echo json_encode($extra_details->emails); ?></p> </li>
	            		        		<li><p><strong>Phones:</strong><?php echo json_encode($extra_details->phones); ?></p> </li>
	            		        		<li><p><strong>Profiles:</strong><?php echo json_encode($extra_details->profiles); ?></p> </li>
	            		        		<li><p><strong>Locations:</strong><?php echo json_encode($extra_details->locations); ?></p> </li>
	            		        		<li><p><strong>Locations:</strong><?php echo json_encode($extra_details->locations); ?></p> </li>
	            		        		<li><p><strong>Emploment:</strong><?php echo json_encode($extra_details->employment); ?></p> </li>
	            		        		<li><p><strong>Emploment:</strong><?php echo json_encode($extra_details->employment); ?></p> </li>
	            		        		<li><p><strong>Photos:</strong><?php echo json_encode($extra_details->photos); ?></p> </li>
	            		        		<li><p><strong>Education:</strong><?php echo json_encode($extra_details->education); ?></p> </li>
	            		        		<li><p><strong>Updated:</strong><?php echo json_encode($extra_details->updated); ?></p> </li>

	            		        	</ul>
	            		        	
	            		        </div>

		            		    <?php } ?>
	            		        
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
				'address_phone' => get_post_meta(get_the_ID(), 'address_phone')[0],
				'full_name' => get_post_meta(get_the_ID(), 'full_name')[0],
				'age_range' => get_post_meta(get_the_ID(), 'age_range')[0],
				'gender' => get_post_meta(get_the_ID(), 'gender')[0],
				'location' => get_post_meta(get_the_ID(), 'location')[0],
				'organization' => get_post_meta(get_the_ID(), 'organization')[0],
				'twitter' => get_post_meta(get_the_ID(), 'twitter')[0],
				'linkedin' => get_post_meta(get_the_ID(), 'linkedin')[0],
				'facebook' => get_post_meta(get_the_ID(), 'facebook')[0],
				'bio' => get_post_meta(get_the_ID(), 'bio')[0],
				'avatar' => get_post_meta(get_the_ID(), 'avatar')[0],
				'website' => get_post_meta(get_the_ID(), 'website')[0],
				'details' => get_post_meta(get_the_ID(), 'details')[0]
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