#!/bin/sh 
# Filename: setup.sh
# Description: 
#       A script that can automate the creation of a database schema 
#       with initialized default values on the localhost. 
#       This shall run the .sql script

# Credentials
# App name: door2dorm-backend
host="us-cdbr-east-06.cleardb.net" 
user="b08c35ce866050"
password="d2655c71"
database="heroku_9ee0e413f16e154"

echo "Creating schema to the remote database!"
cat "schema.sql" | mysql -h "$host" -u "$user" "-p$password" "$database"
