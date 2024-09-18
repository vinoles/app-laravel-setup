# APP LARAVEL SETUP

## Requirements

-   docker
-   docker-compose

## How to run

```bash
# After cloning the project
cd ./app-laravel-setup

# Add the project to hosts file
sudo sh -c "echo '127.0.0.1 app-laravel-setup.local' >> /etc/hosts"

# Install sail
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs

# Setup envs
cp .env.example .env
cp .env.example .env.testing
cp .env.example .env.dusk.local
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
http://app-laravel-setup.local:8099

#Admin
http://app-laravel-setup.local:8099/admin/login

#Api
http://app-laravel-setup.local:8099/api/v1/documentation
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

#generate api doc
make api-doc
```

## Create sail alias

```bash
#create alias
alias sail="./vendor/bin/sail"
```

## Execute command example

```bash
# run command
sail artisan l5-swagger:generate

#install package
sail composer require bezhansalleh/filament-language-switch

#generate token
sail artisan app:generate-token-user admin@app.com password
```
# Read the make file for more commands
