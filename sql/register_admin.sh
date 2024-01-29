#!/bin/sh 
# Filename: register_admin.sh
# Description: 
#       Hardcode the admin credentials into Admin table

host="us-cluster-east-01.k8s.cleardb.net" 
user="bd606795766db9"
password="3b1ba14e"
database="heroku_098a2fcd8fadcea"

cat "admin_credentials.sql" | mysql -h "$host" -u "$user" "-p$password" "$database"