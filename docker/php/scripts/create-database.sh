#!/usr/bin/env ash

# Create the database directory structure
mkdir -p data/database && chmod a+rw data data/database

# Create the SQLite database
sqlite3 -batch "$PWD/data/database/db.sqlite3" <"$PWD/docker/php/scripts/initdb.sql"

# Set the appropriate permissions on the database file
chmod a+rw data/database/db.sqlite3