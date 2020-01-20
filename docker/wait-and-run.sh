#!/bin/bash

while ! nc -z redis 6379;
do
  echo "Waiting REDIS. Slepping";
  sleep 1;
done;
echo "Connected to REDIS!";

while ! nc -z amqp 5672;
do
  echo "Waiting AMQP. Slepping";
  sleep 1;
done;
echo "Connected to AMQP!";

sh $1;