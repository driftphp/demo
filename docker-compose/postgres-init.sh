#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username "root" --dbname "demo" <<-EOSQL
  CREATE TABLE IF NOT EXISTS key_value (key varchar(255) PRIMARY KEY, value varchar(255) NOT NULL);
EOSQL