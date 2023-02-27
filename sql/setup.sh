#!/bin/sh 
# Filename: setup.sh
# Description: 
#       A script that can automate the creation of a database schema 
#       with initialized default values on the localhost. 
#       This shall run the .sql script

# Credentials
host="us-cdbr-east-06.cleardb.net" 
user="bd22e71ea9fc1e"
password="34602037"
database="heroku_5388512170af7bf"

echo "Creating schema to the remote database!"
cat "create_tables.sql" | mysql -h "$host" -u "$user" "-p$password" "$database"
