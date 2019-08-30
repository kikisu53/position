#!/bin/bash
# see https://github.com/104corp/104isgd-puppet/blob/master/data/nodes/mjb/lmjb.sys.104dc-dev.com.yaml

PHP_VER=7.0

add-apt-repository ppa:ondrej/php -y
apt-get update
DEBIAN_FRONTEND=noninteractive \
    apt-get install apache2 \
                    libapache2-mod-fcgid \
                    php${PHP_VER} \
                    php${PHP_VER}-cgi \
                    php${PHP_VER}-cli \
                    php${PHP_VER}-common \
                    php${PHP_VER}-mysql \
                    php${PHP_VER}-mcrypt \
                    php${PHP_VER}-gd \
                    php${PHP_VER}-json \
                    php${PHP_VER}-bcmath \
                    php${PHP_VER}-mbstring \
                    php${PHP_VER}-xml \
                    php${PHP_VER}-xmlrpc \
                    php${PHP_VER}-zip \
                    php${PHP_VER}-soap \
                    php${PHP_VER}-sqlite3 \
                    php${PHP_VER}-curl \
                    php${PHP_VER}-opcache \
                    php${PHP_VER}-readline \
                    php-mongodb \
                    php-memcached \
                    php-igbinary \
                    -y

a2dismod mpm_event
a2enmod fcgid mpm_worker actions rewrite

# mod_fcgid
tee /etc/apache2/mods-available/fcgid.conf <<EOF
<IfModule mod_fcgid.c>
  AddHandler fcgid-script .php
  FcgidConnectTimeout 20
  FcgidWrapper /usr/local/bin/php-wrapper .php
</IfModule>
EOF

tee /usr/local/bin/php-wrapper <<EOF
#!/bin/sh
# Set desired PHP_FCGI_* environment variables.
# Example:
# PHP FastCGI processes exit after 500 requests by default.
PHP_FCGI_MAX_REQUESTS=0
export PHP_FCGI_MAX_REQUESTS

# Replace with the path to your FastCGI-enabled PHP executable
exec /usr/bin/php-cgi
EOF
chmod 755 /usr/local/bin/php-wrapper

# Make htdocs folder
mkdir -p /var/www/htdocs

# php.ini
sed -i 's/;date.timezone =.*/date.timezone = Asia\/Taipei/g' /etc/php/${PHP_VER}/cgi/php.ini

# Use igbinary as session serializer
# see https://github.com/104corp/104isgd-puppet/blob/914976ce900f6ef4e408b08d6a5a2392a726866c/data/nodes/mjb/lmjb.sys.104dc-dev.com.yaml#L30
sed -i 's/;session.serialize_handler=igbinary/session.serialize_handler=igbinary/g' /etc/php/${PHP_VER}/cgi/conf.d/20-igbinary.ini

systemctl enable apache2
