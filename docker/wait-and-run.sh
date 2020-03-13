#!/bin/sh


while ! nc -z demo_postgres 5432;
do
  echo "Waiting POSTGRES. Slepping";
  sleep 1;
done;
echo "Connected to POSTGRES!";

while ! nc -z demo_amqp 5672;
do
  echo "Waiting AMQP. Slepping";
  sleep 1;
done;
echo "Connected to AMQP!";

sh $1;
