#!/bin/sh 
# Filename: setup.sh
# Description: 
#       A script that can automate the creation of a database schema 
#       with initialized default values on the localhost. 
#       This shall run the .sql script

# Credentials
# App name: door2dorm-backend
host="us-cluster-east-01.k8s.cleardb.net" 
user="bd606795766db9"
password="3b1ba14e"
database="heroku_098a2fcd8fadcea"

echo "Creating schema to the remote database!"
cat "schema.sql" | mysql -h "$host" -u "$user" "-p$password" "$database"