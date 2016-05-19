<?php
/**
* The Styla Magazine Admin defines all the functionality for the Wordpress dashboard of 
* the plugin. 
*
* @author     Sebastian Sachtleben
*/
class Styla_Magazine_Admin {
 
    /**
     * A reference to the version of the plugin that is passed to this class from the caller.
     *
     * @access private
     * @var    string    $version    The current version of the plugin.
     */
    private $version;
 
    /**
     * Initializes this class and stores the current version of this plugin.
     *
     * @param    string    $version    The current version of this plugin.
     */
    public function __construct( $version ) {
        $this->version = $version;
    }

    /**
     * Registers the options page to Wordpress dashboard to allow the admin to change 
     * the settings for the plugin.
     */
    public function add_options_page() {
        add_options_page(
            'Styla Magazine', 
            'Styla Magazine', 
            'manage_options', 
            'styla-magazine', 
            array ( 
                $this,
                'render_options_page'
            )
        );
    }
	
    /**
     * Requres the file that is used to display the admin interface for this plugin.
     */
    public function render_options_page() {
        require_once plugin_dir_path( __FILE__ ) . 'partials/styla-magazine-settings.php';
    }

}