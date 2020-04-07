<?php
get_header();
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<div class="page-intro-block">
		<div class="site-container">
			<div class="intro-blocks">
				<div class="left-block">
					<div class="intro-content">
						<div class="logo-wrapper">AB</div>
						<h1><?php echo __('Address Book', 'fcaddressbooks');?></h1>
						<p><?php echo __('A great tool to keep and enrich your addresses', 'fcaddressbooks');?></p>
					</div>
				</div>
				<div class="right-block">
					<div class="intro-form">
						
						<div class="form-head text-left">
							<h4>Add Contact</h4>
							<p>Add your address here and enrich with our API</p>
						</div>
						
						<?php echo do_shortcode('[fc_address_form]'); ?>

					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="address-list-block">
		<div class="site-container">
			<div class="address-list-head text-center">
				<h2><?php echo __('Address List', 'fcaddressbooks'); ?></h2>
			</div>
			<div class="address-list-wrap text-center">
				<?php echo do_shortcode('[fc_address_list]'); ?>
			</div>
		</div>
	</div>

<?php endwhile; endif; wp_reset_postdata(); ?>

<?php
get_footer();