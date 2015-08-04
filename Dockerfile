FROM phundament/php:5.6-cli-4.0.0-rc3-dev

# Clean eventually orphaned files and remove installation source
RUN rm -rf /app/src /app/web /app-src

# Prepare container
# /!\ Note: Please add your own API token to config.json
# Phundament comes with a public token for your convenince which may hit the GitHub rate limit
ADD ./build/container-files/ /

# Install application packages, if there are changes the composer files
ADD ./composer.lock ./composer.json /app/
RUN /usr/local/bin/composer global require "fxp/composer-asset-plugin:dev-master"

# RUN composer self-update
# RUN composer global update
RUN /usr/local/bin/composer install --prefer-dist --optimize-autoloader

# Add application code
ADD version /app/version
ADD .env-dist /app/.env
ADD yii Dockerfile docker-compose.yml /app/
ADD web /app/web
ADD src /app/src

# Create folder writable by the application (non-persistent data)
RUN mkdir /app/web/assets /app/runtime && \
    chmod 777 /app/web/assets /app/runtime
