ARG APACHE_VERSION=""
FROM httpd:${APACHE_VERSION:+${APACHE_VERSION}-}alpine

RUN apk update; \
    apk upgrade;

# Copy apache vhost file to proxy php requests to php-fpm container
COPY common.apache.conf /usr/local/apache2/conf/common.apache.conf
COPY php1.apache.conf /usr/local/apache2/conf/php1.apache.conf
COPY php2.apache.conf /usr/local/apache2/conf/php2.apache.conf
RUN printf "\nInclude /usr/local/apache2/conf/common.apache.conf" >> /usr/local/apache2/conf/httpd.conf
RUN printf "\nInclude /usr/local/apache2/conf/php1.apache.conf" >> /usr/local/apache2/conf/httpd.conf
RUN printf "\nInclude /usr/local/apache2/conf/php2.apache.conf" >> /usr/local/apache2/conf/httpd.conf
