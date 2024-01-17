#!/bin/sh 
# Filename: register_admin.sh
# Description: 
#       Hardcode the admin credentials into Admin table

host="us-cluster-east-01.k8s.cleardb.net" 
user="b6242f07ae4393"
password="c5ba3043"
database="heroku_f47e36bc84bb2cb"

cat "admin_credentials.sql" | mysql -h "$host" -u "$user" "-p$password" "$database"