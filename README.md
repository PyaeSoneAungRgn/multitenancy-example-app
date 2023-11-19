## multitenancy-example-app

### Setup

```env
DB_CONNECTION=tenant
DB_HOST=127.0.0.1
DB_PORT=3306
DB_USERNAME=root
DB_PASSWORD=

SHARED_DB_CONNECTION=shared
SHARED_DB_HOST=127.0.0.1
SHARED_DB_PORT=3306
SHARED_DB_DATABASE=shared
SHARED_DB_USERNAME=root
SHARED_DB_PASSWORD=
```

Create 3 databases.

- shared
- tenant1
- tenant2

```bash
herd link multitenancy
php artisan migrate --database=shared --path=database/migrations/shared --seed
php artisan tenants:migrate --seed
```

### Testing

```bash
php artisan test
```
