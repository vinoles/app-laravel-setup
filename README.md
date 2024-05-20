# DOGME APP

## Requirements

-   docker
-   docker-compose

## How to run

```bash
# After cloning the project
cd ./dogme-app

# Add the project to hosts file
sudo sh -c "echo '127.0.0.1 dogme-app.local' >> /etc/hosts"

# Install sail
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs


# Setup envs
cp .env.example .env

#Build containers
make setup

# Start all containers
make up

# Stop all containers
# Se Eliminan
# make stop

# Run dev
make front-dev
```

## WEB

```bash

#WEB
http://dogme-app.local:8099

#Admin

http://dogme-app.local:8099/admin/login
```

## Command install o artisan command

```bash

#Example install package
make sail command="composer require bezhansalleh/filament-language-switch"

#Example command artisan
make sail command="artisan tinker"

#run scout jobs
make sail command="artisan queue:work redis --queue=scout"

#generate key
make sail command="artisan artisan key:generate"
```
