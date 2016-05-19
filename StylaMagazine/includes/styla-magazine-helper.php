<?php
/**
* This is the Styla Magazine helper class. It contains several method used by
* the Wordpress Plugin.
*
* @author     Sebastian Sachtleben
*/
class Styla_Magazine_Helper {

    /**
     * Fetch the magazine content for the styla plugin.
     */
    public static function fetch_content( $host ) {
        if (!self::isMagazinePath()) {
            return array();
        }

        // TODO: Fetch current script and style version from version endpoint
        parse_str($_SERVER['QUERY_STRING'], $queryParams);
        $currentPath = self::getRequestPath($queryParams);
        // $pathing = explode("/", $currentPath);
        $magazinePath = get_option('styla_magazine_path', '/');
        if ($magazinePath != '/') {
            $currentPath = str_replace('/'.$magazinePath, '', $currentPath);
        }

        /*
        $currentPath = (($pathing[1] == "" || $pathing[1] == "tag") ? "/user/" . get_option('styla_username') : "") . $currentPath;
        if ($currentPath === null || (
                strrpos($currentPath, '/user/') === 0 &&
                strrpos($currentPath, '/tag/') === 0 &&
                strrpos($currentPath, '/story/') === 0 &&
                strrpos($currentPath, '/search/') === 0)) {
            return array();
        }
        if ($queryParams['offset']) {
            $currentPath = $currentPath . "?offset=" . $queryParams['offset'];
        }
        */
        $cacheKey = self::getCacheName($currentPath);
        $seo = wp_cache_get($cacheKey, 'StylaMagazine');
        if (!$seo) {
            $seo = self::fetchAndRememberSEO($currentPath);
        }

        if(is_object( $seo )){
            $seo->head = isset($seo->html->head) ? $seo->html->head : "";
            $seo->body = isset($seo->html->body) ? $seo->html->body : "";

            return $seo;
    	}
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
        //die(get_option('styla_seo_server', 'http://seo.styla.com/clients/').get_option('styla_username', '').'?url='.$key);
        $data = @file_get_contents(get_option('styla_seo_server', 'http://seo.styla.com/clients/').get_option('styla_username', '').'?url='.$key);

        if($data != FALSE){
			// JSON decode
            $json = json_decode($data);

            // Check if json has status code
			if(!isset($json->status)){
	        	die('Styla Plugin: No status code in SEO response.');
            }

            // check if response code is 2XX
        	if(substr((string)$json->status, 0, 1) == '2'){
            	// if no expire is present, default to 60min
            	$expire = isset($json->expire) ? $json->expire / 60 : 60;

            	// TODO: Save JSON to Cache with $expire
				// ...

				// Return the JSON
				return $json;
			}
			else{
	            die('Styla Plugin: Status code is not 2XX: '.$json->status);
            }
        }
        else{
	        die('Styla Plugin: No data received from SEO API.');
        }
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
    private static function isMagazinePath() {
        $magazinePath = get_option('styla_magazine_path', '/');
        if (strlen($magazinePath) == 0 || $magazinePath[0] != '/') {
            $magazinePath = '/' . $magazinePath;
        }
        $currentPath = $_SERVER["REQUEST_URI"];
        if (strcasecmp(substr($currentPath, 0, strlen($magazinePath)), $magazinePath) !== 0) {
            return false;
        }
        return true;
    }

    /**
     * Generates a unique cache name from the url.
     */
    public static function getCacheName( $url ) {
        $cacheKey = preg_replace('/[^A-Za-z0-9]/', "", $url);
        if (!$cacheKey) {
            $cacheKey = 'root';
        }
        return $cacheKey;
    }

}
