#!/bin/bash

docker-compose -f docker-compose/docker-compose.yml pull
docker-compose -f docker-compose/docker-compose.yml up --build
