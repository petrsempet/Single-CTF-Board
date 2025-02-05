# Single CTF Board
![Screenshot](/docs/images/screen_en.png)
A platform for single CTF competitions (Capture The Flag) with sequential tasks (one after the other, in a chain)
## Installation and launch
### Local PHP server
```bash
composer install
cd public
php -S localhost:888
```
### Docker
```bash
docker compose up -d
```
## Task settings
Configuration file with task settings: [`/settings/config.json`](/settings/config.json)

### Config.json structure
|Key|Description|
|----|--------|
||**`info` – info about contest**|
|`name`|Contest name (shown in titles)|
|`hash`|Hash algorithm from `hash_algos()` for flags (if not used – `null`)|
||**`tasks` – tasks array**|
|`name`|Task name|
|`description`|Task description with Markdown|
|`connection`|Task connection parameters|
|`flag`|Flag or flag hash for task|
|`flag_format`|Flag format (CTF{...})|

### Config.json example
```json
{
    "info": {
        "name": "Single CTF Board",
        "hash": null
    },
    "tasks": [
        {
            "name": "First task",
            "description": "Multiline\n\nTask description with **Markdown**",
            "connection": "http://192.168.1.2\nnc 192.168.1.2 34\nssh user@192.168.1.2",
            "flag": "CTF{MY-FiR$t-t@SK}",
            "flag_format": "CTF{...}"
        }
    ]
}
```
## Progress reset
Using the PHP script
```bash
php reset_progress.php
```
or SQL query to [`/settings/answers.db`](/settings/answer.db)
```sql
DELETE FROM answers;
```
## Donates
If you're in Russia, you can support author on [CloudTips](https://pay.cloudtips.ru/p/30831d31)

Thank you!