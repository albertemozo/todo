TODO
====

This is a playground app for testing stuff, using a simple "to-do list" as context.

Usage
-----

Run the application.

```shell
docker-compose up -d
```

See the todo list.

```shell
docker-compose exec php todo:list
```

Add a new item.

```shell
docker-compose exec php todo:add "Do something"
```
