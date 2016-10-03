<?php

$sport = $_POST['sport'];
$date  = $_POST['date'];

$output = "";
$results = 0;

//$jsondata = file_get_contents("http://alexandertallqvist.net/sportdata.json");
$jsondata = file_get_contents("sportdata.json");
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
  $error1 = "<h3>"  . $results . " results found" . "</h3><br>";
  $error2 = "No data found with the selected values. Try changing some of the values and try again.";
  $returnArray = array();
  array_push($returnArray, $error1, $error2);
  echo json_encode($returnArray);

}else{
  $results  = "<h3>" . $results . " results found</h3>";
  $returnArray = array();
  array_push($returnArray, $results, $output);
  echo json_encode($returnArray);
}

?>
