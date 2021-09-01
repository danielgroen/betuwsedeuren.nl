FROM php:7.4-fpm-alpine
ENV force_color_prompt yes

RUN apk update \
  && apk upgrade \
  && apk add --no-cache $PHPIZE_DEPS \
  && apk add --no-cache nano

# install the PHP extensions we need (https://make.wordpress.org/hosting/handbook/handbook/server-environment/#php-extensions)
RUN set -ex; \
  \
  apk add --no-cache --virtual .build-deps \
  $PHPIZE_DEPS \
  freetype-dev \
  imagemagick-dev \
  libjpeg-turbo-dev \
  libpng-dev \
  libwebp-dev \
  libzip-dev \
  ; \
  \
  docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp; \
  docker-php-ext-install -j "$(nproc)" \
  bcmath \
  exif \
  gd \
  mysqli \
  zip \
  ; \
  pecl install imagick-3.4.4; \
  docker-php-ext-enable imagick; \
  \
  runDeps="$( \
  scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
  | tr ',' '\n' \
  | sort -u \
  | awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
  )"; \
  apk add --virtual .wordpress-phpexts-rundeps $runDeps; \
  apk del .build-deps


ARG ENVIRONMENT='production'
RUN if test "$ENVIRONMENT" != 'development'; then \
  mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"; \
  pecl install redis; \
  docker-php-ext-enable redis; \
  else \
  mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"; \
  pecl install xdebug-3.0.3; \
  docker-php-ext-enable xdebug; \
  { \
  echo 'zend_extension=xdebug.so'; \
  echo 'xdebug.idekey="PHPSTORM"'; \
  echo 'xdebug.client_host=host.docker.internal'; \
  echo 'xdebug.discover_client_host=0'; \
  echo 'xdebug.client_port=9000'; \
  echo 'xdebug.scream=0'; \
  echo 'xdebug.show_local_vars=1'; \
  echo 'xdebug.max_nesting_level=256'; \
  echo 'xdebug.mode=debug'; \
  echo 'xdebug.log="/tmp/xdebug.log"'; \
  echo 'xdebug.start_with_request=yes'; \
  echo 'xdebug.profiler_output_dir="/tmp/xdebug-profile"'; \
  } > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
  fi; \
  sed -i "s/upload_max_filesize = 2M/upload_max_filesize = 8M/g" /usr/local/etc/php/php.ini;

# opcache
RUN set -eux; \
  docker-php-ext-enable opcache; \
  { \
  echo 'opcache.memory_consumption=192'; \
  echo 'opcache.interned_strings_buffer=8'; \
  echo 'opcache.max_accelerated_files=4000'; \
  echo 'opcache.revalidate_freq=2'; \
  echo 'opcache.fast_shutdown=1'; \
  } > /usr/local/etc/php/conf.d/opcache-recommended.ini
