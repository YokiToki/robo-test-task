# Тестовое задание

## Установка

Требования к установке
```
PHP >= 7.1.3
OpenSSL PHP Extension
PDO PHP Extension
```

Начало установки
```
git clone https://github.com/YokiToki/robo-test-task.git
cd robo-test-task
composer install
cp .env.example .env
```
В файле `.env` нужно указать параметры соединения с пустой базой данных PostgreSQL

Накатываем миграции
```
php artisan migrate
```

Заполняем таблицы данными
```
php artisan db:seed
```

добавляем в Cron запись для вызова планировщика задач
```
* * * * * php /path-to/robo-test-task/artisan schedule:run >> /dev/null 2>&1
```

Команда для осуществления запланированных переводов (её вызывает планировщик)
```
php artisan transfer:complete
```

## Запуск

```
php artisan serve
```
Приложение будет доступно по адресу [http://localhost:8000](http://localhost:8000)

Создается 3 пользователя с параметрами логин:пароль
```
alice@example.com:alice
bob@example.com:bob
peter@example.com:peter
```