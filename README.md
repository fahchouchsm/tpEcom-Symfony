# Fahchouch Store 🚀

Clean Symfony 7 project with **Doctrine ORM**, **Twig**, and **Docker** — ready to use.

## Stack
- PHP 8.3 (FPM)
- Nginx
- MySQL 8.0
- Symfony 7.1
- Doctrine ORM + Migrations
- Twig templating
- Maker Bundle (for `make:entity`, `make:controller`, etc.)

---

## 🏁 First-Time Setup

### 1. Install dependencies
```bash
docker-compose run --rm php composer install
```

### 2. Start containers
```bash
docker-compose up -d
```

### 3. Run migrations
```bash
docker-compose exec php bin/console doctrine:migrations:migrate --no-interaction
```

### 4. Open in browser
```
http://localhost:8080/products
```

Click **"Seed Sample Data"** to populate with example products.

---

## ⚡ Daily Commands

```bash
# Start
docker-compose up -d

# Stop
docker-compose down

# Run a console command
docker-compose exec php bin/console <command>

# Generate a new entity
docker-compose exec php bin/console make:entity

# Generate a new controller
docker-compose exec php bin/console make:controller

# Create a migration after changing entities
docker-compose exec php bin/console doctrine:migrations:diff

# Run migrations
docker-compose exec php bin/console doctrine:migrations:migrate

# Clear cache
docker-compose exec php bin/console cache:clear
```

---

## 🗄️ Database

| Setting  | Value        |
|----------|-------------|
| Host     | `db` (inside Docker) / `localhost:3306` (outside) |
| Database | `symfony_db` |
| User     | `symfony`    |
| Password | `symfony`    |
| Root pw  | `root`       |

---

## 📁 Structure

```
├── docker/
│   ├── nginx/default.conf   # Nginx config
│   └── php/Dockerfile       # PHP-FPM image
├── src/
│   ├── Controller/          # Controllers
│   ├── Entity/              # Doctrine entities
│   └── Repository/          # Repositories
├── templates/               # Twig templates
├── migrations/              # Database migrations
├── config/                  # Symfony config
├── public/index.php         # Front controller
├── .env                     # Environment variables
└── docker-compose.yml
```

---

## 🔧 Reset Everything

```bash
docker-compose down -v          # Destroys DB volume too
docker-compose up -d
docker-compose exec php bin/console doctrine:migrations:migrate --no-interaction
```
