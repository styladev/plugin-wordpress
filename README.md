## Wordpress Styla Magazine Plugin v.1.0.6
## Installation How-to
#### Author: Sebastian Sachtleben
#### Last updated: 14.07.2015
#### Compatibility: Wordpress 4.11 - 4.22

This Wordpress plugin provides the SEO and Routing functionality for a Styla magazine.

### Plugin Install

1. Copy everything except the README.md to the Wordpress folder

2. Activate the StylaMagazine plugin in Wordpress

3. Setup the username and the magazine path in the StylaMagazine settings of Wordpress

4. Add **<?PHP styla_body(); ?>** in the theme where the magazine should be placed

### Rewrite via .htaccess

To allow all magazine path its necessary to modify the .htaccess file. The apache needs the following modules enabled:

* mod_rewrite
* mod_proxy
* mod_proxy_http

This is the base Wordpress **.htaccess** file located in the Wordpress root folder:

    # BEGIN WordPress
    <IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteRule ^index\.php$ - [L]
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . /index.php [L]
    </IfModule>
    # END WordPress

Depending on where your magazine should run you need to change it as descripted below.

#### Running on root path

_NOTE:_ `%{REQUEST_SCHEME}` isn't supported by all Apache versions, so make sure either use `http` or `https` instead.

At this line right after **RewriteBase**:

    RewriteRule ^(user|tag|story|search)/(.*)$ %{REQUEST_SCHEME}://%{HTTP_HOST}/?origUrl=$0 [E=ORIG_URI:/$0,P,L,QSA]

it should look similar to this:

    # BEGIN WordPress
    <IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteRule ^(user|tag|story|search)/(.*)$ %{REQUEST_SCHEME}://%{HTTP_HOST}/?origUrl=$0 [E=ORIG_URI:/$0,P,L,QSA]
    RewriteRule ^index\.php$ - [L]
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . /index.php [L]
    </IfModule>
    # END WordPress

#### Running on a sub path

At this line right after **RewriteBase**:

    RewriteRule ^magazine/(user|tag|story|search)/(.*)$ %{REQUEST_SCHEME}://%{HTTP_HOST}/magazine/?origUrl=$0 [E=ORIG_URI:/$0,P,L,QSA]

it should look similar to this:

    # BEGIN WordPress
    <IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteRule ^magazine/(user|tag|story|search)/(.*)$ %{REQUEST_SCHEME}://%{HTTP_HOST}/magazine/?origUrl=$0 [E=ORIG_URI:/$0,P,L,QSA]
    RewriteRule ^index\.php$ - [L]
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . /index.php [L]
    </IfModule>
    # END WordPress

Change **magazine** to the magazine path.     

### Allow Magazine in sub path (pages)

Before its possible to add a magazine into a page it's necessary to install a plugin to allow php in pages like this: "https://wordpress.org/plugins/allow-php-in-posts-and-pages/". With this plugin its possible to use *[php] styla_body(); [/php]* in any page. The page path should match with the magazine path settings from the StylaMagazine plugin for proper seo content.

### Changes

* 1.0.6 - Removed magazine path for the seo fetch
* 1.0.5 - Only fetch content, set statuscode and output styla magazine if magazine path matches
* 1.0.4 - Fixed seo problems for story and account urls
* 1.0.3 - Replaced file_get_contents with curl (removed 'allow__url_fopen' dependency from php.ini)
* 1.0.2 - Remove addslashes inside get_web_page method
* 1.0.1 - Allow to run magazine on a sub path
* 1.0.0 - Initial release

### Known Issues

* The plugin uses the Wordpress cache which is not persist by default (see: https://codex.wordpress.org/Class_Reference/WP_Object_Cache#Persistent_Caching)
* In order to let the Styla Magazin Plugin to run under a sub path the .htacess needs to be modifed
