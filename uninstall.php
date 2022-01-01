<?php
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) { die(); };
		 global $wpdb;
		 $wp_track_table = $wpdb->prefix . 'paragraph_words_like_dislike_status';
		 $wpdb->query( "DROP TABLE IF EXISTS {$wp_track_table}" );
?>