# Mariabackup Partial Backup & Restore helper scripts

## Limitations

* Does not support partitioned tables

## Step by step guide

Prerequisites:

* Make sure that on the destination DB `innodb_force_recovery` is undefined or set to 0 otherwise errors about "read only" tables will interrupt import process

Steps to make partial backup & restore:

1. Copy `config.sample.php` to `config.php` and edit with proper data;
1. On the SOURCE server make next steps:
2. Make partial backup using mariabackup, eg. `mariadb-backup.exe --backup --target-dir=c:\TEMP\mariadb\ --user=root --password=... --databases="... ..."`
3. Prepare data export, eg. `mariadb-backup.exe --prepare --export --target-dir=c:\TEMP\mariadb\`
4. Generate SQL for database and table recreating: `mysqldump.exe -u root -p --no-data --databases ... ... > c:\TEMP\mariadb\recreate_databases_and_tables.sql`
5. Generate SQL for tablespace discarding and tablespace importing: `php tablespace.php`
6. Now switch to DESTINATION server and make next steps
7. Run SQL for generating databases and tables and then SQL for tablespace discarding
8. Stop the DB service
9. Copy ONLY folders (DO NOT COPY loose files) from your backup/export dir to destination folder
10. Start the DB service
11. Run SQL for tablespace importing

## Known problems

Tablespace SQLs might throw errors. At this time you should execute them row by row and correct obvious problems.