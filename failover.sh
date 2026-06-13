#!/bin/bash

PROXYSQL_HOST="127.0.0.1"
PROXYSQL_PORT="6032"
PROXYSQL_USER="admin"
PROXYSQL_PASS="admin_pass"
REPLICA_HOST="mysql-replica"
REPLICA_PORT="3306"
REPLICA_USER="root"
REPLICA_PASS="root_pass"
PRIMARY_HOST="mysql-primary"

# Verifica si el primary está ONLINE en hostgroup 10
PRIMARY_ONLINE=$(mysql -h$PROXYSQL_HOST -P$PROXYSQL_PORT -u$PROXYSQL_USER -p$PROXYSQL_PASS -NB -e \
  "SELECT COUNT(*) FROM runtime_mysql_servers WHERE hostgroup_id=10 AND hostname='mysql-primary' AND status='ONLINE';" 2>/dev/null)

if [ "$PRIMARY_ONLINE" -eq "1" ]; then
  # Primary está vivo — asegura que la réplica tenga read_only=ON
  mysql -h$REPLICA_HOST -P$REPLICA_PORT -u$REPLICA_USER -p$REPLICA_PASS -e \
    "SET GLOBAL read_only=ON;" 2>/dev/null
else
  # Primary caído — verifica si hostgroup 10 quedó vacío
  WRITER_COUNT=$(mysql -h$PROXYSQL_HOST -P$PROXYSQL_PORT -u$PROXYSQL_USER -p$PROXYSQL_PASS -NB -e \
    "SELECT COUNT(*) FROM runtime_mysql_servers WHERE hostgroup_id=10 AND status='ONLINE';" 2>/dev/null)

  if [ "$WRITER_COUNT" -eq "0" ]; then
    # Promueve la réplica a escritura
    mysql -h$REPLICA_HOST -P$REPLICA_PORT -u$REPLICA_USER -p$REPLICA_PASS -e \
      "SET GLOBAL read_only=OFF;" 2>/dev/null
  fi
fi
