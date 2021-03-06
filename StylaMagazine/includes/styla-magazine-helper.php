<?php
/**
* This is the Styla Magazine helper class. It contains several method used by
* the Wordpress Plugin.
*
* @author     Sebastian Sachtleben
*/
class Styla_Magazine_Helper {

    /*
     * Helper function to replace file_get_contents()
     */
    public static function get_content($URL){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $URL);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * Fetch the magazine content for the styla plugin.
     */
    public static function fetch_seo_content() {
        if (!self::isMagazinePath()) {
            return array();
        }

        $arr = parse_url($_SERVER['REQUEST_URI']);
        $path = $arr['path'];

        $seo = wp_cache_get($path, 'StylaMagazine');
        if (!$seo) {
            $seo = self::fetchAndRememberSEO($path);
        }

        if(is_object( $seo )){
            // Remove <title> from $seo->html->head because it's already set by add_magazine_title()
            if(isset($seo->html->head)) {
                $seo->html->head = preg_replace("/<title>.*<\/title>/", "", $seo->html->head);
                $seo->head = $seo->html->head;
            }

            $seo->body = isset($seo->html->body) ? $seo->html->body : "";
            $seo->tags = isset($seo->tags) ? $seo->tags : [];
            return $seo;
    	}
    }

    /**
     * Fetch the magazine content for the styla plugin.
     */
    public static function fetch_cdn_content() {
        $version = self::fetchAndRememberCdnVersion();
        $serverDomain = get_option('styla_content_server', '//client-scripts.styla.com/');
        $stylaUsername = @self::getTranslatedOption('styla_username');
        $cdn = '<script async type="text/javascript" src="' . $serverDomain . 'scripts/clients/' . $stylaUsername . '.js?v=' . $version . '"></script>' .
               '<link rel="stylesheet" type="text/css" href="' . $serverDomain . 'styles/clients/' . $stylaUsername . '.css?v=' . $version . '">';
        return $cdn;
    }

    /**
     * Get a web file (HTML, XHTML, XML, image, etc.) from a URL.  Return an
     * array containing the header fields and content.
     */
    private static function get_web_page( $url ) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $result  = array();
        $result['content']  = curl_exec($ch);
        $result['http_code'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        return $result;
    }

    /**
     * Fetch SEO information for the requested key
     */
    private static function fetchAndRememberSEO( $key ) {
        $url = get_option('styla_seo_server', 'http://seo.styla.com/clients/') . @self::getTranslatedOption('styla_username', '') . '?url='.$key;
        $data = @self::get_content($url);
        if($data != FALSE){
            // JSON decode
            $json = json_decode($data);
            // check if response code is 2XX
            if(substr((string)$json->status, 0, 1) == '2'){
                // if no expire is present, default to 60min
                $expire = isset($json->expire) ? $json->expire / 60 : 60;
                // Save JSON to Cache with $expire
                wp_cache_set($key, $json, 'StylaMagazine', $expire);
                // Return the JSON
                return $json;
            }
            else {
                // return Status code 404
                status_header(404);
                nocache_headers();
                if ( '' != get_query_template( '404' ) ) {
                    include( get_query_template( '404' ) );
                }
                exit();
            }
        }
    }

    /**
     * Fetch SEO information for the requested key
     */
    private static function fetchAndRememberCdnVersion() {
        $version = @self::get_content(get_option('styla_version_server', 'http://live.styla.com/api/version/').get_option('styla_username', ''));
        if($version != FALSE){
            return $version;
        }
        return "";
    }

    /**
     * Get requested url from query param 'origUrl' (added from the apache rewrite rule).
     */
    private static function getRequestPath($queryParams) {
        if ($queryParams == null) {
            parse_str($_SERVER['QUERY_STRING'], $queryParams);
        }
        return '/' . $queryParams['origUrl'];
    }

    /**
     * Checks if the current path is the magazin path.
     */
    public static function isMagazinePath() {
        $currentPath = ltrim($_SERVER["REQUEST_URI"], '/');
        $magazinePath = @self::getMagazinePath();

        $routes = join('|', @self::getMagazineRoutes());
        $rootRegex = '^' . @self::buildRegexForMagazinePath($magazinePath) . '(\/)?$';
        $routesRegex = '^' . @self::buildRegexForMagazinePath($magazinePath) . '(\/)?(' . $routes . ')\/(.*)';

        $isMatchingRoot = @self::isMatching($rootRegex, $currentPath);
        $isMatchingRoutes = @self::isMatching($routesRegex, $currentPath);

        return $isMatchingRoot || $isMatchingRoutes;
    }

    public static function getMagazinePath() {
        $homeUrl = '';

        if (@self::isMultilingual()) {
            $homeUrl = parse_url(apply_filters('wpml_home_url', get_option('home')), PHP_URL_PATH);
        }

        return trim($homeUrl . get_option('styla_magazine_path', '/'), '/');
    }

    public static function buildRegexForMagazinePath($magazinePath) {
        return strlen($magazinePath) === 0 ? preg_quote($magazinePath) : ('(' . str_replace('/', '\/', preg_quote($magazinePath)) . ')');
    }

    public static function isMatching($regex, $string) {
        preg_match("/" . $regex . "/", $string, $matches);
        return !empty($matches);
    }

    public static function getMagazineRoutes() {
        return [ 'user', 'tag', 'tags', 'story', 'search', 'category', 'pages' ];
    }

    public static function getTranslatedOption($key, $defaultValue = '') {
        $optionValue = get_option($key, $defaultValue);
        return @self::isMultilingual() ? icl_t('StylaMagazine', $key, $optionValue) : $optionValue;
    }

    public static function isMultilingual() {
        return is_plugin_active( 'wpml-multilingual-cms/sitepress.php' ) || is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' );
    }

}
