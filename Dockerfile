FROM dunglas/frankenphp:php8.4.19-bookworm

RUN docker-php-ext-install pdo_mysql

WORKDIR /app
COPY . .
COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8080
CMD ["/start.sh"]