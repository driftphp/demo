#!/bin/sh


while ! nc -z demo_mysql 3306;
do
  echo "Waiting MYSQL. Slepping";
  sleep 1;
done;
echo "Connected to MYSQL!";

while ! nc -z demo_amqp 5672;
do
  echo "Waiting AMQP. Slepping";
  sleep 1;
done;
echo "Connected to AMQP!";

sh $1;
