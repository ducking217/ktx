<?php
$models = glob("app/Models/*.php");
foreach($models as $m) {
    $content = file_get_contents($m);
    if (preg_match_all("/'([^']+)'\s*=>\s*([a-zA-Z0-9_\\\\]+)::class/", $content, $matches)) {
        for($i=0; $i<count($matches[1]); $i++) {
            echo basename($m) . ": " . $matches[1][$i] . " -> " . $matches[2][$i] . "\n";
        }
    }
}
