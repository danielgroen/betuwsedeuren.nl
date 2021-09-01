FROM nginx:alpine
ENV force_color_prompt yes

RUN set -x ; \
    addgroup -g 82 -S www-data ; \
    adduser -u 82 -D -S -G www-data www-data && exit 0 ; exit 1

RUN apk update \
    && apk upgrade \
    && apk add --no-cache openssl \
    && apk add --no-cache nano

# Reload nginx: /usr/sbin/nginx -s reload