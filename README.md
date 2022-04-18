# slim-rr

## Docker Compose
```shell
docker compose up --build

curl localhost:8080/users 
```

## Local
```shell
composer install
./vendor/bin/rr get-binary
./rr serve -c local.rr.yaml
```