#!/usr/bin/env bash

# Sleep for 30 seconds to wait until mysql is up
sleep 30


# Install Wordpress
wp core download

# Starting apache
apache2-foreground
