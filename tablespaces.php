<?php 

require 'connect.php';

// retrieve full table names from
// SELECT CONCAT(table_schema, '.', TABLE_NAME) FROM information_schema.tables WHERE table_schema IN (...)

$dbs_sql_quoted = '"' . implode('", "', $dbs) . '"';    // to use in SQL queries

$query = "SELECT CONCAT('`', table_schema, '`.`', TABLE_NAME, '`') FROM information_schema.tables WHERE table_schema IN ($dbs_sql_quoted) and engine = 'InnoDB'";
$result = $mysqli->query($query);
if (!$result) {
    die("Query failed: (" . $mysqli->errno . ") " . $mysqli->error);
}

$tables = [];
while ($row = $result->fetch_row()) {
    $tables[] = $row[0];
}

$result->free();

$sql_discard_tablespaces = '';
$sql_import_tablespaces = '';

// disable foregin key checks for discarding tablespaces
$sql_discard_tablespaces .= "SET SESSION FOREIGN_KEY_CHECKS = 0;" . PHP_EOL;

// generate SQL for tablespace discarding and tablespace importing
foreach ($tables as $table) {
    $sql_discard_tablespaces .= "ALTER TABLE $table DISCARD TABLESPACE;" . PHP_EOL;
    $sql_import_tablespaces .= "ALTER TABLE $table IMPORT TABLESPACE;" . PHP_EOL;
}

// save SQL for tablespace discarding and tablespace importing to files
file_put_contents($backup_dir . 'discard_tablespaces.sql', $sql_discard_tablespaces);
echo "Saved SQL for tablespace discarding to 2_{$backup_dir}discard_tablespaces.sql" . PHP_EOL;

file_put_contents($backup_dir . 'import_tablespaces.sql', $sql_import_tablespaces);
echo "Saved SQL for tablespace importing to 3_{$backup_dir}import_tablespaces.sql" . PHP_EOL;

require 'disconnect.php';