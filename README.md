# Symfony PJ

## About Project
News Parser. The application is developed using Symfony.
- To add a new resource, you need to use the NewsResource factory in the parser service
- In NewsFromUrl::getRBCNews(int $countNews) - you can set the number of news 


## Quick Start
```shell
$ cd symfony-pj
$ cp app/.env.example app/.env
$ docker-compose up --build
$ docker exec -it php74-container bash
$ composer install
$ sh makedb.sh
```
## Demo screen
https://github.com/vol-mir/symfony-pj/tree/master/app/public/demo