
<?php

$csvFile = file('fridge.csv');
$data = [];
foreach ($csvFile as $line) {
    $data[] = str_getcsv($line);
}
var_dump($data);


?>
