# php-twitrim

DELETE old tweets.

## How to use

```
docker run -it --rm -v $(pwd):/app composer:1.6 install
vi config.json
docker run -it --rm -v $(pwd):/app php:7.2 php /app/twitrim.php
```
