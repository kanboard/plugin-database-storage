Database Object Storage
=======================

[![Build Status](https://travis-ci.org/kanboard/plugin-database-storage.svg?branch=master)](https://travis-ci.org/kanboard/plugin-database-storage)

This plugin stores uploaded files into the database instead of using the local filesystem.

Author
------

- Frederic Guillot
- License MIT

Requirements
------------

- Kanboard >= 1.0.29
- Postgres is recommended
- Mysql or Sqlite

Why I should store files in the database?
-----------------------------------------

Storing files in the database doesn't fit all usages.
Obviously, the database size will increase over the time if you store large files.

The main benefit of doing this is to simplify backups.
Everything is in a central location and nothing is stored on the frontend servers.
PostgreSQL is preferred because streaming files is supported.

Migrating old files to the database
-----------------------------------

```bash
./cli db-storage:migrate
```

Notes
-----

- Run the command `VACUUM` to free up disk space used by removed files
- With Mysql, you may need to change the value of `max_allowed_packet`, the default is 1MB
