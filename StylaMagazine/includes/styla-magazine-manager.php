<?php
/**
* The Styla Magaziner Manager is the core class responsible for including and 
* instantiating all of the code that composes the plugin.
*
* It includes an instance to the Styla Magazine Loader which is reponsible for
* for coordinating the hooks that exist within the plugin.
*
* @author     Sebastian Sachtleben
*/
class Styla_Magazine_Manager {
 
    /**
     * A reference to the loader class that coordinates the hooks and callbacks 
     * throughout the plugin.
     *
     * @access protected
     * @var	Styla_Magazine_Loader	$loader		Manages hooks and callback functions.
     */
    protected $loader;
 
    /**
     * Represents the slug of the plugin that can be used through out the plugin 
     * for identification.
     *
     * @access protected
     * @var string	$plugin_slug	The single, hyphenated string used to identify the plugin.
     */
    protected $plugin_slug;
 
    /**
     * Maintains the current version of the plugin so that we can use it through
     * out the plugin.
     *
     * @access protected
     * @var string	$version	The current version of the plugin.
     */
    protected $version;
 
    /**
     * Instantiates the plugin by setting up core properties and loading all 
     * necessary dependencies and defining the hooks.
     * 
     * The constructor will befine both the plugin slug and the version 
     * attributes, but will also use internal functions to import all the 
     * plugin dependencies, and will everage the Styla_Magazine_Loader for 
     * registring the hooks and the callback functions used throughout the 
     * plugin.
     */
    public function __construct() {
        $this->plugin_slug = 'styla-magazine-slug';
        $this->version = '1.0.6';
 
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }
 
    /**
     * Imports the Styla Magazine Admin, Public, Helper and the Loader.
     * 
     * The Styla Magazine administration class defines all unique functionality for 
     * introducing custom functionality into the Wordpress dashboard.
     *
     * The Styla Magazine Loader is the class that will coordinate the hooks and 
     * callbacks fro Wordpress and the plugin. This function instantiates and sets 
     * the reference to the $loader class property.
     *
     * @access	private
     */
    private function load_dependencies() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/styla-magazine-admin.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/styla-magazine-public.php';
        require_once plugin_dir_path( __FILE__ ) . 'styla-magazine-helper.php';
        require_once plugin_dir_path( __FILE__ ) . 'styla-magazine-loader.php';
        $this->loader = new Styla_Magazine_Loader();
    }
 
    /**
     * Defines the hooks and callback functions that are used to change the settings for 
     * this plugin in the admin interface of Wordpress.
     *
     * This function relies on the Styla Magazine Admin class and the Styla Magazine 
     * Loader class property.
     * 
     * @access private
     */
    private function define_admin_hooks() {
        $admin = new Styla_Magazine_Admin( $this->get_version() );
        $this->loader->add_action( 'admin_menu', $admin, 'add_options_page' );
    }

    /**
     * Defines the hooks and callback functions that are used for rendering informations 
     * on the front end of the site.
     * 
     * This function relies on the Styla Magazine Public class and the Styla Magazine 
     * Loader class property.
     *
     * @access	private
     */
    private function define_public_hooks() {
        $public = new Styla_Magazine_Public( $this->get_version() );
        $this->loader->add_action( 'wp_head', $public, 'add_magazine_head' );
        $this->loader->add_action( 'styla_body', $public, 'add_magazine_body' );
    }
	
    /**
     * Sets this class into motion.
     *
     * Executes the plugin by calling the run method of the loader class which will 
     * register all of the hooks and callback functions used throughout the plugin 
     * with Wordpress.
     */
    public function run() {
        $this->loader->run();
    }
 
    /**
     * Retuns the current version of the plugin.
     *
     * @return	string	$this->version	The current version of the plugin.
     */
    public function get_version() {
        return $this->version;
    }
 
}