<div align="center" style="margin-top: 50px; margin-bottom: 50px">
<span style="border-top-left-radius: 5px; border-bottom-left-radius: 5px; background-color: #ba363f; font-size: 40px; width: 100px; padding-left: 10px; padding-right: 10px; color: white">
SPF
</span>
<span style="border-top-right-radius: 5px; border-bottom-right-radius: 5px; background-color: white; font-size: 40px; width: 100px; padding-left: 10px; padding-right: 10px; color: black">
Simple PHP framework
</span>
</div>

За основу фреймворку візьмемо шаблон проектування Front Controller (фронт-контролер, єдина точка входу). Шаблон є спеціалізованою варіацією шаблону проєктування Посередник. Задачею фронт-контролера є надання єдиної точки входу для обробки усіх запитів та виклик відповідної поведінки в залежності від запиту.

## <h2 style="color:#ba363f">Installation</h2>
``` 
    composer install
```

## <h2 style="color:#ba363f">About framework</h2>

### Debugging
Для налагодження використовується `symfony/var-dumper` компонент. Він забезпечує кращу функцію dump() або dd(), яку можна використовувати замість var_dump().

### Request
У PHP запит представлено деякими глобальними змінними ($_GET, $_POST, $_FILES, $_COOKIE, $_SESSION, ...), а відповідь генерується деякими функціями (echo, header(), setcookie(), ...).
<br> Для оброки запиту клієнта напишемо свій власний клас Request - аналог `symfony/http-foundation`

### Router
В якості роутера використовується пакет `nikic/fast-route`

### Dependency Injection Container
Для контейнера використали пакет `league/container`, який імплементує `psr/container` (PSR-11).

### Dotenv Component
Використали пакет `symfony/dotenv`, який дає з

### Twig
В якості шаблонізатора обрано `twig/twig`. Twig зручний для розробників, дотримується принципів PHP і надає функції, корисні для середовищ шаблонів.

## Doctrine DBAL
В якості ORM обрано `doctrine/dbal`. Doctrine DBAL (Шар абстракції бази даних) - це шар абстракції, який працює над PDO і пропонує інтуїтивно зрозумілий та гнучкий API для комунікації з найбільш популярними реляційними базами даних.
