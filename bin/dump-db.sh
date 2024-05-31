#!/bin/bash

source '.env'
source '.env.local'
DATABASE_URL_NO_PARAM=$(echo "$DATABASE_URL" | sed 's/\?.*//')
pg_dump "$DATABASE_URL_NO_PARAM" -F c -f var/dddb.dump
