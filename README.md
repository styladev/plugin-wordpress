## Wordpress Styla Magazine Plugin v1.2.5
## Installation How-to
#### Author: Sebastian Sachtleben, Christian Korndörfer
#### Compatibility: Wordpress 4.2.2 - 4.9.X

This Wordpress plugin provides the SEO and Routing functionality for a Styla magazine. The first diagram on [this page](https://styladocs.atlassian.net/wiki/spaces/CO/pages/9961481/Technical+Integration) should provide you an overview of what the plugin does and how it exchanges data with Styla.

### Installation

1. Install and activate the following plugin to allow php in pages: https://wordpress.org/plugins/allow-php-in-posts-and-pages/

2. Copy the entire StylaMagazine folder into your wp-content/plugins folder

3. Activate the StylaMagazine plugin in Wordpress

4. Go to **Settings -> StylaMagazine** and configure the plugin (see [Configuration](#configuration)). Click "Save Changes" when ready.

5. Add `[php] styla_body(); [/php]` on the page the magazine should be placed

6. Go to **Settings -> Permalinks** and hit the "Save Changes" button (you don't need to change anything on this site) - this will refresh internal redirects for all magazine urls (e.g. <magazine path>/story/asdf-1234)

### Configuration

* **Domain** - Domain name of the magazine to embed and provided by Styla. If unclear please contact support@styla.com
* **Magazine Root Path** - Page slug to your magazine. Example: The slug for mydomain.com/magazine would be "magazine" and can be found on the top of the page edit. Leave empty if your magazine is supposed to be displayed on your front page (e.g. mydomain.com/)

![Page slug in "Quick Edit" form](http://i.imgur.com/vAdGxqk.png)

* **SEO Server** - Server used to fetch SEO information for the magazine and it's content. _Should not be changed without double-checking with Styla._
* **Content Server** - Server providing Styles and Javascript for the magazine and it's content. _Should not be changed without double-checking with Styla._
* **Version Server** - Server providing the current Version for the magazines Styles and Scripts. _Should not be changed without double-checking with Styla._

### SEO Content from Styla's SEO API

The plugin uses data from Styla's SEO API to:
* generate tags like: meta tags including `<title>`, canonical link, og:tags, static content inserted into <body>, `robots` instructions
* insert these tags accordingly into HTML of the template the page with Styla content uses

This is done to provide search engine bots with data to crawl and index all Styal URLs, which are in fact a Single-Page-Application.

Once you install and configure the module, please open source of the page on which your Styla content is embedded and check if none of the tags mentioned below are duplicated. In case `robots`or `link rel="canonical"` or any other are in the HTML twice, make sure to remove the original ones coming from your default template. Otherwise search engine bots might not be able to crawl all the Styla content or crawl it incorrectly.

You can finde more information on the SEO API on [this page](https://styladocs.atlassian.net/wiki/spaces/CO/pages/9961486/SEO+API+and+Sitemaps+Integration)

### Using Styla with WPML Plugin

If you use the [WordPress Multilingual Plugin](https://wpml.org/) and want separate magazines for each language please use your main language Styla domain name within the StylaMagazine plugin settings.

After changing the settings navigate to **WPML -> String Translations** and the StylaMagazine **styla_username** can be translated for each language.

### Changes

#### 1.2.5
* fixed support for magazine on frontpage
* support for wpml with separate magazines per language
* remove YOAST plugin meta tags
* replace properly title tag with YOAST plugin

---

#### 1.2.4
* added pages to rewrites
* support 404 errors with magazine on startpage

---

#### 1.2.3
* added categories path to rewrites

---

#### 1.2.2
* using client-scripts.styla.com instead of cdn.styla.com

---

#### 1.2.1
* now using cURL instead of `file_get_contents()`

---

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
