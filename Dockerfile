FROM node:20-alpine AS frontend
WORKDIR /app
COPY . .
RUN npm install
RUN npm run build

FROM serversideup/php:8.4-fpm-nginx

COPY --chown=www-data:www-data . /var/www/html

COPY --from=frontend --chown=www-data:www-data /app/public/build /var/www/html/public/build

RUN composer install --no-interaction --optimize-autoloader --no-dev