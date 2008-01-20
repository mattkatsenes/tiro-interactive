#!/bin/sh

# replace tiro.db with a clean copy.
rm protected/Data/tiro.db
sqlite3 protected/Data/tiro.db < protected/schema.sql
chmod 777 protected/Data/tiro.db

# make user directories
# exec dir_setup.sh

exit 0