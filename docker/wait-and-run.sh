#!/bin/bash

while ! nc -z amqp 5672;
do
  echo sleeping;
  sleep 1;
done;
echo Connected!;

sh $1;