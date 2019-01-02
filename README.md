# php-twitrim

Script to delete old tweets.

## How to use

[Create new app](https://apps.twitter.com/). Then,

```
$ docker run -it --rm -v $(pwd):/app composer:1.6 install
$ vi config.json
$ docker run -it --rm -v $(pwd):/app php:7.2 php /app/twitrim.php
```

If you want to check what will be deleted, you can use `n` arg to do a dry run.

```
$ docker run -it --rm -v $(pwd):/app php:7.2 php /app/twitrim.php n
```
