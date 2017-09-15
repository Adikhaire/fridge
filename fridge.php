
<html>
<head>
  <title> Finding Recipe from Fridge </title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<h1>
  Today's Recipe
</h1>
<?php
# Creating a Class Fridge for instances in of items
class Fridge {

  public $item;
  public $amount;
  public $unit;
  public $useby;

public function loadFridge($data){
  # converted string into the specific format.
  $this->item = (string)$data[0];
  $this->amount = (int)$data[1];
  $this->unit = (string)$data[2];

  $strdate = $data[3];
  # Converting the date string into a date format
  $datecomp = explode("/",$strdate);
  $dateStr = $datecomp[0]."-".$datecomp[1]."-".$datecomp[2];
  $this->useby = $dateStr;
  }

}
# Reading the fridge.csv file from the file "fridge.csv"
function read_csv(){
  $csvFile = file('fridge.csv');
  $data = [];
  foreach ($csvFile as $line) {
      $data[] = str_getcsv($line);
  }
  $count = count($data);
  $list = array();
  for($c=0; $c < $count;$c++) {
    $fr = new Fridge();
    $fr -> loadFridge($data[$c]);
    $list[] = $fr;
}
 return $list;
}

$list = read_csv();
findRecipe($list);
# function check the recipe items with the fridge items with checking all the constraints.
function findRecipe($array){
  $list = $array;
  # importing the recipe.json file.
  $str = file_get_contents("recipe.json");
  $recipe = json_decode($str,TRUE);
  $findMindate = array();
  for ($a=0; $a< count($recipe);$a++){
    $name = $recipe[$a]['name'];
    $ingredientsCount = count($recipe[$a]['ingredients']);
    $countingIngredients = 0;
    $dateArray = array();
    for ($b=0; $b< count($recipe[$a]['ingredients']);$b++){
      foreach($list as $obj){
        $ref = $recipe[$a]['ingredients'][$b];
        # Allowing only the recipes which have satisfied the criteria mentioned in the if clause.
        if ( $ref['item'] == str_replace(" ","",$obj->item) and (int)$ref['amount'] <= $obj->amount and $ref['unit'] == $obj->unit and strtotime($obj->useby) > time()){
          $countingIngredients +=1;
          $dateArray [] = strtotime($obj->useby);
        }
      }
      if ($countingIngredients == $ingredientsCount){
        $findMindate ["$name"] = $dateArray;
      }
    }
  }
  # Calculating the date which is closer to expire from choosen recipe.
  if ($findMindate){
  $recipeFound =  array_keys($findMindate, min($findMindate));
  $recipeFound = (string)$recipeFound[0];
  ?>
  <table>
  <tr>
      <th>Item</th>
      <th>Amount</th>
      <th>Unit</th>
  </tr>
  <h4>
    Items in the Fridge
  </h4>
  <?php foreach ($list as $obj): ?>
  <tr>
       <td><?php echo $obj->item ?></td>
       <td><?php echo $obj->amount ?></td>
       <td><?php echo $obj->unit ?></td>
  </tr>
  <?php endforeach; ?>
</table>
  <h2>
      Today we have to cook <?php echo $recipeFound ?>
  </h2>
  <?php }else {
    ?>
    <h2>
      Order Take Out
    </h2>
  <?php }
}
?>
</html>
