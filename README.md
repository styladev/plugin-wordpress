## Wordpress Styla Magazine Plugin v1.2.0
## Installation How-to
#### Author: Sebastian Sachtleben, Christian Korndörfer
#### Last updated: 24.10.2016
#### Compatibility: Wordpress 4.2.2 - 4.5.X

This Wordpress plugin provides the SEO and Routing functionality for a Styla magazine.

### Installation

1. Install and activate the following plugin to allow php in pages: https://wordpress.org/plugins/allow-php-in-posts-and-pages/

2. Copy the entire StylaMagazine folder into your wp-content/plugins folder

3. Activate the StylaMagazine plugin in Wordpress

4. Go to **Settings -> StylaMagazine** and configure the plugin (see [Configuration](#configuration)). Click "Save Changes" when ready.

5. Add `[php] styla_body(); [/php]` on the page the magazine should be placed

6. Go to **Settings -> Permalinks** and hit the "Save Changes" button (you don't need to change anything on this site) - this will refresh internal redirects for all magazine urls (e.g. <magazine path>/story/asdf-1234)

### Configuration

* **Domain** - Domain name of the magazine to embed and provided by Styla. If unclear please contact support@styla.com
* **Magazine Root Path** - URL path to your magazine. Example: The rooth path for mydomain.com/magazine would be "magazine". Leave empty if your magazine is supposed to be displayed on your front page (e.g. mydomain.com/)
* **Magazine Page Slug** - Slug of the (front-)page with the `[php] styla_body(); [/php]` snippet on it. Only required when the Magazine Root Path is empty. The page slug can be found in the "Quick Edit" form of the page, see this example:

![Page slug in "Quick Edit" form](http://i.imgur.com/vAdGxqk.png)

* **SEO Server** - Server used to fetch SEO information for the magazine and it's content. _Should not be changed without double-checking with Styla._
* **Content Server** - Server providing Styles and Javascript for the magazine and it's content. _Should not be changed without double-checking with Styla._
* **Version Server** - Server providing the current Version for the magazines Styles and Scripts. _Should not be changed without double-checking with Styla._

### Changes

#### 1.2.0
* Accepts pagination offset parameter
* 404 status header and page on non existent offsets/pages

---

#### 1.1.2
* replace magazine title only on magazine pages

---

#### 1.1.1
* updated the plugin to work with WPML Multilingual CMS

---

#### 1.1.0
* using wordpress redirects instead of .htaccess redirects
* removed duplicates SEO attributes in <head>

---

* 1.0.8 - now using CDN integration
* 1.0.7 - integrated SEO API
* 1.0.6 - Removed magazine path for the seo fetch
* 1.0.5 - Only fetch content, set statuscode and output styla magazine if magazine path matches
* 1.0.4 - Fixed seo problems for story and account urls
* 1.0.3 - Replaced file_get_contents with curl (removed 'allow__url_fopen' dependency from php.ini)
* 1.0.2 - Remove addslashes inside get_web_page method
* 1.0.1 - Allow to run magazine on a sub path
* 1.0.0 - Initial release

### Known Issues

* The plugin uses the Wordpress cache which is not persist by default (see: https://codex.wordpress.org/Class_Reference/WP_Object_Cache#Persistent_Caching)
