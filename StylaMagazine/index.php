<?php
/*
Plugin Name: StylaMagazine
Plugin URI: http://www.styla.com
Description: The plugin to display the styla magazine. Add "styla_body()" within a php tag in the theme where the magazine should show up. In the Wordpress dashboard is a new Styla Magazine settings page to change the plugin settings.
Version: 1.2.7
Author: Sebastian Sachtleben, Christian Korndörfer
Author URI: http://www.styla.com
*/
if (!defined('WPINC')) {
    die;
}

require_once plugin_dir_path( __FILE__ ) . 'includes/styla-magazine-manager.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/styla-magazine-helper.php';
include_once(ABSPATH.'wp-admin/includes/plugin.php');

// If rootPath of the magazine is "/" the canonical redirect for the frontpage needs to be disabled
function disable_canonical_redirect_for_front_page( $redirect ) {
    if ( is_page() && $front_page = get_option( 'page_on_front' ) ) {
        if ( is_page( $front_page ) )
            $redirect = false;
    }

    return $redirect;
}

function run_styla_magazine_manager() {
    $smh = new Styla_Magazine_Helper();

    $routes = join('|', $smh->getMagazineRoutes());
    $path = $smh->getTranslatedOption('styla_magazine_path', '');

    // Rewriterules for magazine URLs
    if(get_option('styla_magazine_path') != "") {
        add_rewrite_rule($path.'(\/)('.$routes.')\/(.*)','index.php?pagename='.$path,'top');
    }
    else{
        $frontPageId = get_option( 'page_on_front' );
        add_rewrite_rule('^('.$routes.')\/(.*)','index.php?page_id='.$frontPageId,'top');
        add_filter( 'redirect_canonical', 'disable_canonical_redirect_for_front_page' );
    }

    // fetch seo content early to determine whether or not to show 404
    $smh->fetch_seo_content();

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
