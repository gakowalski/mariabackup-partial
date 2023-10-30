<?php 

require_once 'config.php';

/*

1. On the SOURCE server make next steps
2. Make partial backup using mariabackup, eg. `mariadb-backup.exe --backup --target-dir=c:\TEMP\mariadb\ --user=root --password=... --databases="... ..."`
3. Prepare data export, eg. `mariadb-backup.exe --prepare --export --target-dir=c:\TEMP\mariadb\`
4. Generate SQL for database and table recreating: `mysqldump.exe -u root -p --no-data --databases ... ... > c:\TEMP\mariadb\recreate_databases_and_tables.sql`
5. Generate SQL for tablespace discarding and tablespace importing
6. Now switch to DESTINATION server and make next steps
7. Run SQL for generating databases and tables and then SQL for tablespace discarding
8. Stop the DB service
9. Copy ONLY folders (DO NOT COPY loose files) from your backup/export dir to destination folder
10. Start the DB service
11. Run SQL for tablespace importing

*/

$dbs_space_separated = strtr(implode(' ', $dbs), [ // to use in shell commands
    '-' => '@002d',
]);  
echo "$mariabackup_cmd --backup --target-dir=$backup_dir --user=$user --password=$pass --databases=\"$dbs_space_separated\"" . PHP_EOL;
echo "$mariabackup_cmd --prepare --export --target-dir=$backup_dir" . PHP_EOL;

$dbs_space_separated = implode(' ', $dbs); 
echo "$mysqldump_cmd -u $user -p --no-data --databases $dbs_space_separated > {$backup_dir}1_recreate_databases_and_tables.sql" . PHP_EOL;

echo "php tablespaces.php" . PHP_EOL;
