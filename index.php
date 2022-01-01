<?php 
/*
Plugin Name: Word Like Dislike
Description: This plugin provides the ability to add todo list to posts
Author: Muhammad Bilal
Version: 1.0.0
*/
add_shortcode('plugin_content', 'plugin_content');
function plugin_content($atts) {
	$Content = "";
	$current_user = wp_get_current_user();

	if ( is_user_logged_in() && (! user_can( $current_user, "subscriber") ) ) {
		$Content .= file_get_contents (plugin_dir_path( __FILE__ ) . "content.txt");
	} else {
		$Content = '<p>Please contact system administrator for access</p>';
	} 
    return $Content;
}




// Including Bootstrap 4
add_action('wp_enqueue_scripts', 'wp_enqueue_bootstrap4');
function wp_enqueue_bootstrap4() {
    wp_enqueue_style( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' );
    wp_enqueue_script( 'boot3','//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', array( 'jquery' ),'',true );
	
	wp_enqueue_style('main-styles', plugins_url( 'css/style.css' , __FILE__ ), array(), rand(), false);
    wp_enqueue_style('todostyler');
    wp_register_style('fontawesome', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css", array(), '5.13.0', 'all');
    wp_enqueue_style('fontawesome');
    wp_enqueue_script( 'frontend-ajax', plugins_url( 'js/demo.js?x=' . rand(), __FILE__ ), array('jquery'), null, true );
    wp_localize_script( 'frontend-ajax', 'frontend_ajax_object',
        array( 'ajaxurl' => admin_url( 'admin-ajax.php' ))
    	);
}


//Like Handler
add_action( 'wp_ajax_like_handler', 'like_handler' );
function like_handler() {
    global $wpdb;
	$table = $wpdb->prefix . "paragraph_words_like_dislike_status";

	$userID = get_current_user_id();
    $word = $_POST['word'];

	
	
	$wpdb->replace($table, array(
		"user_id" => $userID,
		"para_word" => $word,
		"like_status" => 'true',
		"dislike_status" => 'false'
	));

	echo "Like Status Added Successfully";
	die();
}


//Get Like Dislike Status
add_action( 'wp_ajax_data_getter_word_status', 'data_getter_word_status' );
function data_getter_word_status(){
    global $wpdb;
	$userID = get_current_user_id() ;
    $table = $wpdb->prefix . "paragraph_words_like_dislike_status";
	
	
	
	$query = 'SELECT * FROM '.$table.' WHERE user_id='.$userID;
	$rows = $wpdb->get_results($query);
	if($rows) {
		foreach($rows as $row) {		
// 			print_r($row);
				if($row->like_status == "true") {
					echo "<script>
 							jQuery('#textarea3').val('".$row->para_word."');
 						  </script>";
				}
				else {
					echo "<script>
 							document.getElementById('textarea4').val('".$row->para_word."');
 						  </script>";
				}

		}
	}
	die();
}



//Dislike Handler
add_action( 'wp_ajax_dislike_handler', 'dislike_handler' );
function dislike_handler() {
    global $wpdb;
	$table = $wpdb->prefix . "paragraph_words_like_dislike_status";

	$userID = get_current_user_id();
    $word = $_POST['word'];

	
	
	$wpdb->replace($table, array(
		"user_id" => $userID,
		"para_word" => $word,
		"like_status" => 'false',
		"dislike_status" => 'true'
	));

	echo "Like Status Added Successfully";
	die();
}




// Check initial table 
function Paragraph_Words_Like_Dislike_Status_Check(){
    global $wpdb;
    
    $my_products_db_version = '1.0.0';
    $charset_collate = $wpdb->get_charset_collate();

    $table_name = $wpdb->prefix . "paragraph_words_like_dislike_status";
    if ( $wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name ) {
        $sql = "CREATE TABLE  $table_name ( 
            `id`  int NOT NULL AUTO_INCREMENT,
            `user_id`  varchar(256)   NOT NULL,
            `para_word`  varchar(256)   NOT NULL,
            `like_status`  varchar(256)   NOT NULL,
			`dislike_status`  varchar(256)   NOT NULL,
            PRIMARY KEY  (id)
            ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        add_option('my_db_version', $my_products_db_version);
    }
}

register_activation_hook( __FILE__, 'Paragraph_Words_Like_Dislike_Status_Check' );

?>