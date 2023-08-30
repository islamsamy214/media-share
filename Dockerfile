FROM richarvey/nginx-php-fpm:latest
 
COPY . .
 
# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
 
# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
 
# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN chmod 777 -R ./storage/ ./bootstrap/ ./public/ ./deploy.sh
RUN chmod +x deploy.sh

# install curl then download nodejs for centos
RUN yum install -y curl
RUN curl -sL https://rpm.nodesource.com/setup_12.x | bash -
RUN yum install -y nodejs

CMD ["./deploy.sh"]