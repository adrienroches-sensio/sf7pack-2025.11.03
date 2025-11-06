Sensio Event
============

## Requirements

Get an API Key at https://www.devevents-api.fr/register.
Then create a `.env.local` file with the following content:

```dotenv
# This is a sample key : ACa5S0GxWFi8UTwYH8CE6OkHc06P0BlnGknQwP+wanVR4RU6JtkYuMQO
DEVEVENTS_API_KEY=<YOUR_API_KEY>
```

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
