#!/bin/bash
# Database credentials
 user=root
 password=password
 host=127.0.0.1
 db_name=symfony
# Other options
 backup_path="/home/chathushka/projects/"
 date=$(date +"%d-%b-%Y")
# Set default file permissions
 umask 177
# Dump database into SQL file
 mysqldump --user=$user --password=$password --host=$host $db_name > $backup_path/$db_name-$date.sql