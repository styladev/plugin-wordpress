<?php
/*
Plugin Name: StylaMagazine
Plugin URI: http://www.styla.com
Description: The plugin to display the styla magazine. Add "styla_body()" within a php tag in the theme where the magazine should show up. In the Wordpress dashboard is a new Styla Magazine settings page to change the plugin settings.
Version: 1.1.0
Author: Sebastian Sachtleben, Christian Korndörfer
Author URI: http://www.styla.com
*/
if (!defined('WPINC')) {
    die;
}

require_once plugin_dir_path( __FILE__ ) . 'includes/styla-magazine-manager.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/styla-magazine-helper.php';

// If rootPath of the magazine is "/" the canonical redirect for the frontpage needs to be disabled
function disable_canonical_redirect_for_front_page( $redirect ) {
    if ( is_page() && $front_page = get_option( 'page_on_front' ) ) {
        if ( is_page( $front_page ) )
            $redirect = false;
    }

    return $redirect;
}

function run_styla_magazine_manager() {
    // Rewriterules for magazine URLs
    if(get_option('styla_magazine_path') != "") {
        add_rewrite_rule(get_option('styla_magazine_path').'\/(user|tag|story|search)\/(.*)','index.php?pagename='.get_option('styla_magazine_path'),'top');
    }
    else{
        add_rewrite_rule('^(user|tag|story|search)\/(.*)','index.php?pagename='.get_option('styla_magazine_page_slug'),'top');
        add_filter( 'redirect_canonical', 'disable_canonical_redirect_for_front_page' );
    }

    // Remove canonical when current URL is a magazine URLs
    $smh = new Styla_Magazine_Helper();
    if($smh->isMagazinePath()) {
        remove_action( 'wp_head', 'rel_canonical' );
    }

    // Load magazine, fetch SEO infos, etc.
    $smm = new Styla_Magazine_Manager();
    $smm->run();
}

function styla_body() {
    do_action( 'styla_body' );
}

add_action('init', 'run_styla_magazine_manager');
?>
