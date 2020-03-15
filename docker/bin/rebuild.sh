#!/bin/bash

docker-compose down && docker system prune -fa && docker-compose build
