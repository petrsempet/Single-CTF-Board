# Single CTF Board
![Скриншот](/docs/images/screen_ru.png)
[README on English](README_en.md)

Платформа для проведения одиночных CTF-соревнований (Capture The Flag) с последовательным выполнением заданий (друг за другом, по цепочке)
## Установка и запуск
### Локальный сервер PHP
```bash
composer install
cd public
php -S localhost:888
```
### Docker
```bash
docker compose up -d
```
## Настройка заданий
Конфигурационный файл с заданиями: [`/settings/config.json`](/settings/config.json)

### Структура конфига
|Ключ|Описание|
|----|--------|
||**`info` – информация о соревновании**|
|`name`|Название соревнования (отображается в заголовках)|
|`hash`|Алгоритм хеширования флагов в соответствии с `hash_algos()` (если не применяется – `null`)|
||**`tasks` – массив заданий**|
|`name`|Название задания|
|`description`|Описание задания с поддержкой Markdown|
|`connection`|Параметры подключения к заданию|
|`flag`|Флаг или хеш флага задания|
|`flag_format`|Формат флага (CTF{...})|

### Пример конфига
```json
{
    "info": {
        "name": "Single CTF Board",
        "hash": null
    },
    "tasks": [
        {
            "name": "Первое задание",
            "description": "Многострочное\n\nОписание задания с поддержкой **Markdown**",
            "connection": "http://192.168.1.2\nnc 192.168.1.2 34\nssh user@192.168.1.2",
            "flag": "CTF{MY-FiR$t-t@SK}",
            "flag_format": "CTF{...}"
        }
    ]
}
```
## Сброс прогресса
С помощью PHP-скрипта
```bash
php reset_progress.php
```
или с помощью SQL-запроса к [`/settings/answers.db`](/settings/answers.db)
```sql
DELETE FROM answers;
```
## Поддержать автора
Если вы в России, автора проекта можно поддержать через [CloudTips](https://pay.cloudtips.ru/p/30831d31)

Спасибо, что помогаете развивать проект!