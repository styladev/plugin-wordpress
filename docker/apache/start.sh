#!/usr/bin/env bash

# Sleep for 30 seconds to wait until mysql is up
sleep 30

# Install Wordpress
mkdir /var/www/wordpress
cd /var/www/wordpress
wp core download --allow-root --quiet
wp config create --dbhost=wordpress-mysql --dbname=app --dbuser=app --dbpass=app --allow-root --quiet
wp core install --url=localhost --title=Styla --admin_user=admin --admin_password=admin --admin_email=wecare@styla.com --skip-email --allow-root --quiet

# Install plugins
wp plugin install allow-php-in-posts-and-pages --activate --allow-root --quiet
cp -R /home/root/StylaMagazine /var/www/wordpress/wp-content/plugins/StylaMagazine
wp plugin activate StylaMagazine --allow-root --quiet

# Starting apache
apache2-foreground
