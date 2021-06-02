FROM alpine:3.13 as base

RUN set -xe \
    && apk add --no-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/community \
    php \
    ca-certificates \
    php7-simplexml \
    php7-bcmath \
    php7-ctype \
    php7-dom \
    php7-curl \
    php7-iconv \
    php7-intl \
    php7-json \
    php7-mbstring \
    php7-mysqlnd \
    php7-mysqli \
    php7-pcntl \
    php7-tokenizer \
    php7-pgsql \
    php7-pdo_mysql \
    php7-pdo_pgsql \
    php7-pdo_sqlite \
    php7-phar \
    php7-xml \
    php7-xmlreader \
    php7-xmlwriter \
    php7-zip \
    php7-zlib \
    && rm -rf /var/cache/apk/*

FROM base as build

ARG MIGRATIONS_VERSION="3.1.2"

RUN apk --virtual .doctrine-build --update add bash git wget curl && \
    cd /opt/ && \
    curl -sS -0L https://getcomposer.org/composer-stable.phar -o /opt/composer.phar && \
    mv /opt/composer.phar /usr/bin/composer && \
    chmod +x /usr/bin/composer && \
    git clone https://github.com/doctrine/migrations.git migrations && \
    cd migrations && \
    git checkout tags/$MIGRATIONS_VERSION && \
    cp ./box.json.dist ./box.json && \
    sh ./build-phar.sh && \
    mv ./build/doctrine-migrations.phar /usr/bin/doctrine-migrations

FROM base as final

WORKDIR /srv/doctrine

COPY config/* /srv/doctrine/

COPY --from=build usr/bin/doctrine-migrations /usr/bin/doctrine-migrations

ENTRYPOINT ["doctrine-migrations"]
