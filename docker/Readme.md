#!/bin/bash

docker network connect pirogue_app-network pirogue-database
#!/bin/bash

docker system prune -fa 
docker-compose build
#!/bin/bash

docker-compose down 
docker system prune -fa
#!/bin/bash

docker-compose up --scale php=5 -d
