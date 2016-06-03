<?php
/*
Plugin Name: StylaMagazine
Plugin URI: http://www.styla.com
Description: The plugin to display the styla magazine. Add "styla_body()" within a php tag in the theme where the magazine should show up. In the Wordpress dashboard is a new Styla Magazine settings page to change the plugin settings.
Version: 1.0.8
Author: Sebastian Sachtleben
Author URI: http://www.styla.com
*/
if (!defined('WPINC')) {
    die;
}

require_once plugin_dir_path( __FILE__ ) . 'includes/styla-magazine-manager.php';

function run_styla_magazine_manager() {
    $smm = new Styla_Magazine_Manager();
    $smm->run();
}

function styla_body() {
    do_action( 'styla_body' );
}

add_action('init', 'run_styla_magazine_manager');
?>
