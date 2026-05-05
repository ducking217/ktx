<?php
require __DIR__."/vendor/autoload.php";
$app = require_once __DIR__."/bootstrap/app.php";
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;

$tables = ['cauhinh', 'toa_nha', 'phong', 'chi_so_dien_nuoc', 'danhgia', 'thongbao_user', 'nhat_ky', 'hopdong'];
foreach($tables as $t) {
    echo "Table: $t\n";
    $cols = Schema::getColumns($t);
    foreach($cols as $c) {
        echo $c['name'] . ' -> ' . $c['type_name'] . ($c['nullable'] ? ' (null)' : '') . "\n";
    }
}
