
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

  $strdate = $data[3];
  $datecomp = explode("/",$strdate);
  $dateStr = $datecomp[0]."-".$datecomp[1]."-".$datecomp[2];
  $this->useby = $dateStr;
}
}

$count = count($data);
$list = array();
for($c=0; $c < $count;$c++) {
  $fr = new Fridge();
  $fr -> read_csv($data[$c]);
  $list[] = $fr;
}

#foreach ($list as $obj ) {
#  echo $obj->useby."</br>";
  #echo $obj->amount."</br>";
#}

$str = file_get_contents("/Applications/XAMPP/xamppfiles/htdocs/fridge/recipe.json");
$recipe = json_decode($str,TRUE);
for ($a=0; $a< count($recipe);$a++){
  $name = $recipe[$a]['name'];
  $ingredientsCount = count($recipe[$a]['ingredients']);
  $countingIngredients = 0;
  for ($b=0; $b< count($recipe[$a]['ingredients']);$b++){
    foreach($list as $obj){
      $ref = $recipe[$a]['ingredients'][$b];
      #if (strpos($ref['item'],str_replace(" ","",$obj->item))!==false){
      #  print $ref['item'];
      #}
    if ( (strpos($ref['item'],str_replace(" ","",$obj->item))!==false) and (int)$ref['amount'] <= $obj->amount and $ref['unit'] == $obj->unit and strtotime($obj->useby) > time()){
        $countingIngredients +=1;
        print $countingIngredients."</br>";
    }
  }
  if ($countingIngredients == $ingredientsCount){
    echo $name."</br>";
  }
}

}

// $today = time();
// print $today."</br>";
// foreach ($list as $obj){
//   $usebyDate = $obj->useby;
//   print strtotime($usebyDate)."</br>";
// if (strtotime($usebyDate) > $today ){
//     echo $obj->useby."</br>";
//     print $obj->item."</br>";
//     print("not expired")."</br>";
// } else{
//     print("expired")."</br>";
//     echo $obj->useby."</br>";
//     print $obj->item."</br>";
// }
// }
// foreach($list as $obj){
//   if ($obj->useby.format('j/M/Y') < date('j/M/Y')){
//     print "yes";
//   }
// }
// print date('d/m/y');
#and $obj->useby <= date('d/m/y')
#echo date('d/m/y');
#echo '<pre>' . print_r($recipe, true) . '</pre>';
#var_dump($recipe[1]['ingredients'][1]['amount']);
#var_dump($recipe[1]['name']);





// $instance1 <- new fridge.read_csv($data[0][0],$data[0][1],$data[0][2],$data[0][3]);



?>
