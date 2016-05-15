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

- Postgres is recommended

Notes
-----

- Obviously the database size will increase if you store large files
- Run the command `VACUUM` to free up disk space used by removed files
- With Mysql, you may need to change the value of `max_allowed_packet`, the default is 1MB
