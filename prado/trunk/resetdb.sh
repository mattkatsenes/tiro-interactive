#!/bin/sh

# replace tiro.db with a clean copy.
echo "Resetting sqlite database ..."

rm protected/Data/tiro.db
sqlite3 protected/Data/tiro.db < protected/schema.sql
chmod 777 protected/Data/tiro.db

rm -R protected/users
mkdir protected/users
mkdir protected/users/matt
mkdir protected/users/matt/worker

echo '<xml version="1.0" />' > protected/users/matt/worker/text.xml

chmod -R 777 protected/users

# make user directories
# exec dir_setup.sh

exit 0