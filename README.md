# example-grab-wb

Чтобы запустить проект из корня нужно выполнить 

```bash
docker-compose up -d
```

зайти в контейнер 
```bash
docker exec -it grab-wb sh
```

и выполнить 
```bash
php public/index.php
```

после чего в консоль будет выведены результаты категории 