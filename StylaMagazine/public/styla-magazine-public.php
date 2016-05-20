<?php
/**
* The Styla Magazine Public defines all the functionality for the public-facing
* sides of the plugin.
*
* @author     Sebastian Sachtleben
*/
class Styla_Magazine_Public {

    /**
     * A reference to the version of the plugin that is passed to this class from the caller.
     *
     * @access private
     * @var    string    $version    The current version of the plugin.
     */
    private $version;

    /**
     * Contains the head part of the magazine.
     *
     * @access private
     * @var    string    $head    The head part of the magazine.
     */
    private $head = null;

    /**
     * Contains the body part of the magazine.
     *
     * @access private
     * @var    string    $body    The body part of the magazine.
     */
    private $body = null;

    /**
     * Initializes this class and stores the current version of this plugin.
     *
     * @param    string    $version    The current version of this plugin.
     */
    public function __construct( $version ) {
        $this->version = $version;
    }

    /**
     * Fetches the magazine content from the content host and stores them
     * into the head and body variable.
     */
    public function fetch_magazine_content() {
        $seo = Styla_Magazine_Helper::fetch_content( get_option('styla_content_server', 'http://live.styla.com') );
        $this->head = $seo->head;
        $this->body = $seo->body;
    }

    /**
     * Renders the magazine head part into the Wordpress head.
     */
    public function add_magazine_head() {
        $this->fetch_magazine_content();
        if ($this->head !== null) {
            echo $this->head;
        }
    }

    /**
     * Renders the magazine head part into the Wordpress body.
     */
    public function add_magazine_body() {
        $styla_username = get_option('styla_username');
        if (!$styla_username) {
            die('Please set the styla magazine username in the settings!');
        }
        if ($this->body !== null) {
            echo '<script id="amazineEmbed" type="text/javascript" src="' . get_option('styla_content_server', 'http://live.styla.com') . '/scripts/preloader/' . $styla_username . '.js" async></script>';
            echo $this->body;
        }
    }

}
