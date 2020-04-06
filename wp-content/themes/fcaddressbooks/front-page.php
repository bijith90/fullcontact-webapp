<?php
get_header();
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<div class="page-intro-block">
		<div class="site-container">
			<div class="intro-blocks">
				<div class="left-block">
					<div class="intro-content">
						<h1>Address Book</h1>
						<p>A great tool to keep and enrich your addresses</p>
					</div>
				</div>
				<div class="right-block">
					<div class="intro-form">
						
						<div class="form-head text-left">
							<h4>Add Contact</h4>
							<p>Add your contact details</p>
						</div>

						<?php /* ?><form>
							<div class="form-group row">
								<div class="col-sm-12">
							    	<input type="text" id="firstname" class="form-control" placeholder="First Name">
							  	</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-12">
							    	<input type="text" id="lastname" class="form-control" placeholder="Last Name">
							  	</div>
							</div>
							<div class="form-group row">
							  	<div class="col-sm-12">
							    	<input type="email" id="email" class="form-control" placeholder="Email">
							  	</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-12">
							    	<input type="text" id="phone" class="form-control" placeholder="Phone">
							  	</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-12">
							      	<button type="submit" class="btn btn-primary">SUBMIT</button>
							    </div>
							</div>
						</form><?php */ ?>
						<?php echo do_shortcode('[fc_address_form]'); ?>

					</div>
				</div>
			</div>
		</div>
	</div>

<?php endwhile; endif; wp_reset_postdata(); ?>

<?php
get_footer();