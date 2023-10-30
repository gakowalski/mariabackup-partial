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
$dbs_space_separated = implode(' ', $dbs);
$dbs_sql_quoted = '"' . implode('", "', $dbs) . '"';