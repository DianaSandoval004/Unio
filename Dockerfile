FROM dunglas/frankenphp:php8.4.19-bookworm

RUN docker-php-ext-install pdo_mysql

WORKDIR /app
COPY . .

EXPOSE 8080
CMD ["frankenphp", "run", "--bind=0.0.0.0:${PORT:-8080}"]