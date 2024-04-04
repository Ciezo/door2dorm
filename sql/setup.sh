#!/bin/sh 
# Filename: setup.sh
# Description: 
#       A script that can automate the creation of a PRIMARY DATABASE schema 
#       with initialized default values on the localhost. 
#       This shall run the .sql script

# Credentials
host="localhost" 
user="root"
password="cloyd27feb2002"
database="door2dorm"

echo "Creating schema to the localhost database!"
cat "schema.sql" | mysql -h "$host" -u "$user" "-p$password" "$database"