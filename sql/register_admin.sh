#!/bin/sh 
# Filename: register_admin.sh
# Description: 
#       Hardcode the admin credentials into Admin table

host="localhost" 
user="root"
password="cloyd27feb2002"
database="door2dorm"

cat "admin_credentials.sql" | mysql -h "$host" -u "$user" "-p$password" "$database"