#!/bin/sh 
# Filename: setup.sh
# Description: 
#       A script that can automate the creation of a database schema 
#       with initialized default values on the localhost. 
#       This shall run the .sql script

# Credentials
# App name: door2dorm-backend
host="us-cdbr-east-06.cleardb.net" 
user="b9a3b4c95968d1"
password="521b7aa0"
database="heroku_253ee0abcc115bc"

echo "Creating backup schema to the remote database!"
cat "schema_redundant.sql" | mysql -h "$host" -u "$user" "-p$password" "$database"
