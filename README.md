# PHP-test-task-7
PHP test task for new job.

**Task**
- [Description of the technical task](https://docs.google.com/document/d/1YF_zwTGlFzDPAgizijSKXhulfY2O1D1QQ0SLe5TittQ/edit?usp=sharing)

**Clone repository to your local machine**
```bash
% git@github.com:moroztaras/php-test-task-7.git
```

**Create project config**
```bash
% cd php-test-task-7
% cp .env .env.local
```

**Quick start of the project**

Adjust .env.local line 28.

It's credentials to database.

**Run composer install in the directory**
```bash
% composer install
```
**Create database**
```bash
% php bin/console d:d:c
```

**Create tables in your schema**
```bash
% php bin/console d:m:m
```

**Load fixtures**
```bash
% php bin/console d:f:l
```
**OR**

**Load data into the database from the dump file.**
```bash
% php bin/console d:d:c && mysql -u root -p php-test-task-7 < DumpDB.sql --force
```