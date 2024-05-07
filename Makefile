sail := "./vendor/bin/sail"

# Configuración inicial y preparación para las pruebas
setup: up install migrate seed front-install

# Construir y levantar contenedores Docker
up:
	$(sail) up -d

# Instalar dependencias de Composer
install:
	$(sail) composer install

# Ejecutar las pruebas en el contenedor
test:
	$(sail) artisan test

cache:
	$(sail) artisan cache:clear

# Ejecutar las pruebas en el contenedor con filtro
test_filter:
	$(sail) artisan test --filter $(file)

# Detener y eliminar contenedores Docker
stop:
	$(sail) down

# Migraciones
migrate:
	$(sail) artisan migrate

# Migraciones y seed
seed:
	$(sail) artisan db:seed

# Restaurar db
db_fresh:
	$(sail) artisan migrate:fresh --seed --force

rollback:
	$(sail) artisan migrate:rollback

tinker:
	$(sail) artisan tinker

key:
	$(sail) artisan key:generate

lang:
	$(sail) artisan lang:publish

front-install:
	$(sail) bun install
	$(sail) bun run build

front-dev:
	$(sail) bun run dev

shell:
	$(sail) sail shell
