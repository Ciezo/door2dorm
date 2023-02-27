#!/bin/sh 
# Filename: register_admin.sh
# Description: 
#       Hardcode the admin credentials into Admin table

host="us-cdbr-east-06.cleardb.net" 
user="b08c35ce866050"
password="d2655c71"
database="heroku_9ee0e413f16e154"

cat "admin_credentials.sql" | mysql -h "$host" -u "$user" "-p$password" "$database"