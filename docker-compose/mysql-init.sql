CREATE DATABASE IF NOT EXISTS demo;
CREATE TABLE IF NOT EXISTS demo.key_value (id varchar(255) not null, value varchar(255) not null, constraint id_value_pk primary key (id));