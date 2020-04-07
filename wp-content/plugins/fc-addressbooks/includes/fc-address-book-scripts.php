<?php
// Add plugin scripts and styles
function fc_address_book_scripts() {
	// Styles
	wp_enqueue_style( 'fc-datatable-css', 'https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css' );

	// Scripts
	wp_enqueue_script( 'fc-datatable-js', 'https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js', array('jquery'), '', false );
	wp_enqueue_script('fc-parsley-js',plugins_url().'/fc-addressbooks/js/parsley.min.js', array('jquery'));
}

add_action('wp_enqueue_scripts','fc_address_book_scripts');