<?php
require __DIR__."/vendor/autoload.php";
$app = require_once __DIR__."/bootstrap/app.php";
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$tables = DB::select("SHOW TABLES");
$dbName = DB::connection()->getDatabaseName();
$colKey = "Tables_in_" . $dbName;
$schema = [];
foreach ($tables as $t) {
    $tableName = $t->$colKey;
    $cols = Schema::getColumnListing($tableName);
    $schema[$tableName] = $cols;
}
file_put_contents("db_schema_dump.json", json_encode($schema, JSON_PRETTY_PRINT));
echo "Dumped to db_schema_dump.json\n";

