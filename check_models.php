<?php
$models = glob("app/Models/*.php");
foreach($models as $m) {
    $content = file_get_contents($m);
    if(preg_match("/protected \\\$fillable = \[([^\]]+)\];/", $content, $matches)) {
        echo basename($m) . ": " . trim(preg_replace("/\s+/", " ", $matches[1])) . "\n";
    }
}
