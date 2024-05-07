sail := "./vendor/bin/sail"

#Initial Config
setup: up install migrate seed front-install

# Build containers
up:
	$(sail) up -d

# Composer install
install:
	$(sail) composer install

# run test
test:
	$(sail) artisan test

cache:
	$(sail) artisan cache:clear

# run filter test
test_filter:
	$(sail) artisan test --filter $(file)

# Stop containers
stop:
	$(sail) down

# Rund migrations
migrate:
	$(sail) artisan migrate

# Run migrations and seed
seed:
	$(sail) artisan db:seed

# Refresh database and migrations
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
