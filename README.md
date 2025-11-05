Sensio Event
============

## Install

```console
$ git clone https://github.com/adrienroches-sensio/sf7pack-2025.11.03.git
$ cd ./sf7pack-2025.11.03
$ symfony composer install
$ symfony console doctrine:database:create
$ symfony console doctrine:migration:migrate -n
$ symfony console doctrine:fixtures:load -n
$ symfony serve
```

## Log in

| username | password | roles      |
|----------|----------|------------|
| admin    | admin    | ROLE_ADMIN |
