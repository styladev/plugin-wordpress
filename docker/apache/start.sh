#!/usr/bin/env bash

# Sleep for 30 seconds to wait until mysql is up
sleep 30

# Install Wordpress
mkdir /var/www/wordpress
cd /var/www/wordpress
wp core download --allow-root --quiet
wp config create --dbhost=wordpress-mysql --dbname=app --dbuser=app --dbpass=app --allow-root --quiet
wp core install --url=localhost --title=Styla --admin_user=admin --admin_password=admin --admin_email=wecare@styla.com --skip-email --allow-root --quiet

# Starting apache
apache2-foreground
