#!/bin/sh


# install extensions
chmod uga+x /usr/local/bin/install-php-extensions && sync && install-php-extensions \
    opcache \
    xdebug \
    mysqli \
    curl \
    zip \
    bcmath \
    intl \
;

