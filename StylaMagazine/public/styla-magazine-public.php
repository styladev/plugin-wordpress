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
        $seo = Styla_Magazine_Helper::fetch_seo_content( get_option('styla_content_server', 'http://live.styla.com') );
        $cdn = Styla_Magazine_Helper::fetch_cdn_content( get_option('styla_version_server', 'http://live.styla.com/api/version/') );
        $this->head = $seo->head.$cdn;
        $this->body = $seo->body;
        $this->tags = $seo->tags;
    }

    /**
     * Replaces the magazine <title> tag
     */
    public function add_magazine_title( $title ) {
        if(Styla_Magazine_Helper::isMagazinePath()) {
            $this->fetch_magazine_content();

            if (isset($this->tags) && is_array($this->tags)) {
                foreach ($this->tags as &$tag) {
                    if(isset($tag->tag) && $tag->tag == "title"){
                        return isset($tag->content) ? $tag->content : "Magazine";
                    }
                }
            }

            return "Magazine";
        }

        return "Magazine";
    }

    /**
     * Renders the magazine head part into the Wordpress head.
     */
    public function add_magazine_head() {
        if(Styla_Magazine_Helper::isMagazinePath()){
            $this->fetch_magazine_content();
            if ($this->head !== null) {
                echo $this->head;
            }
        }
    }

    /**
     * Renders the magazine head part into the Wordpress body.
     */
    public function add_magazine_body() {
        if(Styla_Magazine_Helper::isMagazinePath()){
            $styla_username = get_option('styla_username');
            if (!$styla_username) {
                die('Please set the styla magazine username in the settings!');
            }
            if ($this->body !== null) {
                echo '<div id="stylaMagazine"></div>';
                echo $this->body;
            }
        }
    }

}
