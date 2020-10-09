#!/bin/bash

mysql -uroot -proot demo -e "create table key_value (id varchar(255) not null, value varchar(255) not null, constraint id_value_pk primary key (id));"