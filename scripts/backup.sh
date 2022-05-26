#!/bin/bash
set -e

source .env

docker exec mysql mysqldump -u${MYSQL_ROOT_USER} -p${MYSQL_ROOT_PASSWORD} ${MYSQL_DATABASE} > backups/mysql/backup_`date +%d-%m-%Y"_"%H_%M_%S`.sql
