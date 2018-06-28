# Тестовое задание

## Установка

```
git clone https://github.com/YokiToki/robo-test-task.git
cd robo-test-task
composer install
```

Накатываем миграции
```
php artisan migrate
```

Заполняем таблицы данными
```
php artisan db:seed
```

## Запуск

```
php artisan serve
```
Приложение будет доступно по адресу [http://localhost:8000](http://localhost:8000)