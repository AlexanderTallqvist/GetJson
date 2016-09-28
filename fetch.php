<?php

$sport = $_POST['sport'];
$date  = $_POST['date'];
$output = "";
$results = 0;

$jsondata = file_get_contents("http://alexandertallqvist.net/sportdata.json");
$array = json_decode($jsondata, true);

foreach ($array as $index => $item) {
  if(isset($_POST['sport']) && $date != ""){
    if($item['sport'] == $sport && $item['date'] == $date){
      foreach($item as $key => $value) {
        $output.= $key . ": " . $value . "<br>";
      }
      $results ++;
      $output.= "<br><br>";
    }
  }elseif(isset($_POST['sport'])){
    if($item['sport'] == $sport){
      foreach($item as $key => $value) {
        $output.= $key . ": " . $value . "<br>";
      }
      $results ++;
      $output.= "<br><br>";
    }
  }
}

if($results == 0){
  echo "<h3>"  . $results . " results found" . "</h3>";
  echo "No data found with the selected values. Try changing some of the values and try again.";
}else{
  echo "<h3>"  . $results . " results found" . "</h3>";
  echo $output;
}

?>
