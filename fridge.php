
<?php

$csvFile = file('fridge.csv');
$data = [];
foreach ($csvFile as $line) {
    $data[] = str_getcsv($line);
}
#var_dump($data);


class Fridge {

  public $item;
  public $amount;
  public $unit;
  public $useby;

public function read_csv($data){

  $this->item = (string)$data[0];
  $this->amount = (int)$data[1];
  $this->unit = (string)$data[2];
  $this->useby = date_create_from_format('d/m/y',$data[3]);
}
}


$count = count($data);
$list = array();
for($c=0; $c < $count;$c++) {
  $fr = new Fridge();
  $fr -> read_csv($data[$c]);
  $list[] = $fr;
}

foreach ($list as $obj ) {
  #echo $obj->item."</br>";
  #echo $obj->amount."</br>";
}

$str = file_get_contents("/Applications/XAMPP/xamppfiles/htdocs/fridge/recipe.json");
$recipe = json_decode($str,TRUE);


for ($a=0; $a< count($recipe);$a++){
  $name = $recipe[$a]['name'];
  $ingredientsCount = count($recipe[$a]['ingredients']);
  $count_1 = 0;
  for ($b=0; $b< count($recipe[$a]['ingredients']);$b++){

    foreach($list as $obj){
      $ref = $recipe[$a]['ingredients'][$b];
    if ($ref['item'] == $obj->item and (int)$ref['amount'] <= $obj->amount and $ref['unit'] == $obj->unit and $obj->useby <= date('d/m/y')){
        $count_1 +=1;
        print $count_1;
    }
  }
  if ($count_1 == $ingredientsCount){
    echo $name."</br>";
  }
}

}

echo date('d/m/y');
#echo '<pre>' . print_r($recipe, true) . '</pre>';
#var_dump($recipe[1]['ingredients'][1]['amount']);
#var_dump($recipe[1]['name']);





// $instance1 <- new fridge.read_csv($data[0][0],$data[0][1],$data[0][2],$data[0][3]);



?>
