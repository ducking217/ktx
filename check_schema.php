<?php
$dbSchema = json_decode(file_get_contents("db_schema_dump.json"), true);
$migrationFiles = glob("database/migrations/*.php");

$migrationSchema = [];
foreach ($migrationFiles as $file) {
    $content = file_get_contents($file);
    if (preg_match("/Schema::create\(\s*['\"]([^'\"]+)['\"]/", $content, $matches)) {
        $tableName = $matches[1];
        if (!isset($migrationSchema[$tableName])) {
            $migrationSchema[$tableName] = [];
        }
        
        preg_match_all("/\\$table->(?:string|integer|unsignedInteger|bigInteger|unsignedBigInteger|text|longText|boolean|date|dateTime|timestamp|decimal|float|double|enum|foreignId|foreignIdFor|uuid|json)[\(]?\s*['\"]([^'\"]+)['\"]/", $content, $colMatches);
        
        if (strpos($content, '$table->id()') !== false) {
            $migrationSchema[$tableName][] = "id";
        }
        if (strpos($content, '$table->timestamps()') !== false) {
            $migrationSchema[$tableName][] = "created_at";
            $migrationSchema[$tableName][] = "updated_at";
        }
        if (strpos($content, '$table->softDeletes()') !== false) {
            $migrationSchema[$tableName][] = "deleted_at";
        }
        if (strpos($content, '$table->rememberToken()') !== false) {
            $migrationSchema[$tableName][] = "remember_token";
        }
        
        foreach ($colMatches[1] as $col) {
            $migrationSchema[$tableName][] = $col;
        }
    }
}

$discrepancies = [];
foreach ($migrationSchema as $table => $mCols) {
    if (!isset($dbSchema[$table])) {
        $discrepancies[] = "Table '$table' exists in migrations but NOT in database.";
        continue;
    }
    
    $dbCols = $dbSchema[$table];
    
    $extraInDb = array_diff($dbCols, $mCols);
    $missingInDb = array_diff($mCols, $dbCols);
    
    if (!empty($extraInDb) || !empty($missingInDb)) {
        $discrepancies[] = "Table '$table' has schema drift:";
        if (!empty($missingInDb)) {
            $discrepancies[] = "  - In Migration but MISSING in DB: " . implode(", ", $missingInDb);
        }
        if (!empty($extraInDb)) {
            $discrepancies[] = "  - In DB but MISSING in Migration: " . implode(", ", $extraInDb);
        }
    }
}

if (empty($discrepancies)) {
    echo "No schema drift found.\n";
} else {
    file_put_contents("schema_audit.txt", implode("\n", $discrepancies));
    echo "Audit complete. Check schema_audit.txt\n";
}
