FROM dunglas/frankenphp:php8.4.19-bookworm

RUN docker-php-ext-install pdo_mysql

WORKDIR /app
COPY . .

CMD sh -c 'frankenphp php-server --root /app --port $PORT'