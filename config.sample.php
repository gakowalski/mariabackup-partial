<?php

// CHANGE THESE

$user = 'root';
$pass = '';
$host = 'localhost';
$dbs_raw = 'db1 db2 db3';
$dbs_separator = ' ';
$backup_dir = 'C:\\backup\\'; // with trailing slash
$mariabackup_cmd = 'mariadb-backup.exe';
$mysqldump_cmd = 'mysqldump.exe';

// DON'T CHANGE THESE
// THOSE WILL BE CALCULATED AUTOMATICALLY

$dbs = explode($dbs_separator, $dbs_raw);
$dbs_space_separated = strtr(implode(' ', $dbs), [ // to use in shell commands
    '-' => '@002d',
]);  
$dbs_sql_quoted = '"' . implode('", "', $dbs) . '"';    // to use in SQL queries