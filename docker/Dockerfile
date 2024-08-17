FROM bagusp/php8.2:latest

# Install nodejs
# RUN apt-get install -y ca-certificates gnupg
# RUN mkdir -p /etc/apt/keyrings
# RUN curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg
# ENV NODE_MAJOR 20
# RUN echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_MAJOR.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list
# RUN apt-get update
# RUN apt-get install -y nodejs

COPY ./docker/config/default.conf /etc/nginx/conf.d/default.conf

COPY . /var/www/html
WORKDIR /var/www/html

RUN rm -rf docker

RUN chown -R www-data:www-data /var/www/html

RUN composer install
RUN php artisan storage:link

# RUN npm install
# RUN npm run build
