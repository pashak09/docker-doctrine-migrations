# docker-doctrine-migrations
An easy way to run migrations from a container

Files for database connection and migrations configuration are located in /srv/doctrine folder


Launch example:
```
docker run -ti \
  -v $PWD/src/Migrations:/migrations \
  -e MIGRATIONS_PATH='/migrations' \
  -e DATABASE_URL='mysql://user:user_password@db/app' \
  -e MIGRATIONS_NAMESPACE='DoctrineMigrations' \
  --network=project \
  pashak09/docker-doctrine-migrations migrations:execute --up 'DoctrineMigrations\Version20210602174439'
```

Run build:
```
docker build -f Dockerfile -t docker-doctrine-migrations --target final .
```

Image size is 60.9MB
