<?php

/*
Plugin Name: Word DB Replacer
Plugin URI: http://wordpress.org/plugins/words/
Description: This plugin replaces some words with other words using access to DataBase.
Author: JayBGB
Version: 3.3
Author URI: https://ma.tt/
*/

//Create a 5 word length array of technology companies

$companies = array(
    'Apple',
    'Microsoft',
    'Google',
    'Facebook',
    'Twitter');

//Create another 5 word length array of foods
$foods = array(
    'Pizza',
    'Pasta',
    'Burger',
    'Sandwich',
    'Hot Dog');

function renym_wordpress_typo_fix($text){

    $words = selectData();
    foreach ($words as $result){
        $cars[] = $result->cars;
        $places[] = $result->places;
    }
    return str_replace($cars, $places, $text);
}


add_filter('the_content', 'renym_wordpress_typo_fix');

function createTable(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'damJay';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        cars varchar(255) NOT NULL,
        places varchar(255) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

add_action( 'plugins_loaded', 'createTable' );


function insertData(){
    global $wpdb, $foods, $companies;
    $table_name = $wpdb->prefix . 'damJay';
    $hasSomething = $wpdb->get_results( "SELECT * FROM $table_name" );
    if ( count($hasSomething) == 0 ) {
        for ($i = 0; $i < count($foods); $i++) {
            $wpdb->insert(
                $table_name,
                array(
                    'foods' => $foods[$i],
                    'companies' => $companies[$i]
                )
            );
        }
    }
}

add_action( 'plugins_loaded', 'insertData' );

function selectData(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'damJay';
    $results = $wpdb->get_results( "SELECT * FROM $table_name" );
    return $results;
}
