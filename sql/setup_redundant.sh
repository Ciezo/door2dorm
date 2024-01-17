#!/bin/sh 
# Filename: setup.sh
# Description: 
#       A script that can automate the creation of a database schema 
#       with initialized default values on the localhost. 
#       This shall run the .sql script

# Credentials
# App name: door2dorm-backend
host="us-cluster-east-01.k8s.cleardb.net" 
user="b6242f07ae4393"
password="c5ba3043"
database="heroku_f47e36bc84bb2cb"

echo "Creating backup schema to the remote database!"
cat "schema_redundant.sql" | mysql -h "$host" -u "$user" "-p$password" "$database"
