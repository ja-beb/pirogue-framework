# Connect Database Container to Public Network
```bash
$ docker network connect pirogue_app-network pirogue-database
```

# Rebuild Containers
```bash
$ docker system prune -fa 
$ docker-compose build
```

# Start Containers with PHP Container at Scale
```bash
docker-compose up --scale php=5 -d
```
