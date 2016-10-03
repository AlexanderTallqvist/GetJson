<?php
$sport  = "Sport";
$date   = "Date";
$league = "League";
$team   = "Team";

if(isset($_POST['sport']) && $_POST['sport']  !== $sport)  {$sport   = $_POST['sport'];}
if(isset($_POST['date'])  && $_POST['date']   !== $date)   {$date    = $_POST['date'];}
if(isset($_POST['league'])&& $_POST['league'] !== $league) {$league  = $_POST['league'];}
if(isset($_POST['team'])  && $_POST['team']   !== $team)   {$team    = $_POST['team'];}


$output = "";
$results = 0;
$returnArray = array();

//$jsondata = file_get_contents("http://alexandertallqvist.net/sportdata.json");
$jsondata = file_get_contents("sportdata.json");
$array = json_decode($jsondata, true);

foreach ($array as $index => $item) {

  //Sport Date Team League
  if($sport != "Sport" && $date != "Date" && $league != "League" && $team != "Team"){
    if($item['sport'] == $sport && $item['date'] == $date && $item['league'] == $league && ($item['team1'] == $team || $item['team2'] == $team)){
      foreach($item as $key => $value) {
        $output.= $key . ": " . $value . "<br>";
      }
      $results ++;
      $output.= "<br><br>";
    }
  }

  //Sport Date Team
  elseif($sport != "Sport" && $date != "Date" && $team != "Team"){
    if($item['sport'] == $sport && $item['date'] == $date && ($item['team1'] == $team || $item['team2'] == $team)){
      foreach($item as $key => $value) {
        $output.= $key . ": " . $value . "<br>";
      }
      $results ++;
      $output.= "<br><br>";
    }
  }

  //Sport Team League
  elseif($sport != "Sport" && $league != "League" && $team != "Team"){
    if($item['sport'] == $sport && $item['league'] == $league &&  ($item['team1'] == $team || $item['team2'] == $team)){
      foreach($item as $key => $value) {
        $output.= $key . ": " . $value . "<br>";
      }
      $results ++;
      $output.= "<br><br>";
    }
  }

  //Sport League Date
  elseif($sport != "Sport" && $date != "Date" && $league != "League"){
    if($item['sport'] == $sport && $item['date'] == $date && $item['league'] == $league){
      foreach($item as $key => $value) {
        $output.= $key . ": " . $value . "<br>";
      }
      $results ++;
      $output.= "<br><br>";
    }
  }

  //Sport Date
  elseif($sport != "Sport" && $date != "Date"){
    if($item['sport'] == $sport && $item['date'] == $date){
      foreach($item as $key => $value) {
        $output.= $key . ": " . $value . "<br>";
      }
      $results ++;
      $output.= "<br><br>";
    }
  }

  //Sport Team
  elseif($sport != "Sport" && $team != "Team"){
    if($item['sport'] == $sport && ($item['team1'] == $team || $item['team2'] == $team)){
      foreach($item as $key => $value) {
        $output.= $key . ": " . $value . "<br>";
      }
      $results ++;
      $output.= "<br><br>";
    }
  }

  //Sport League
  elseif($sport != "Sport" && $league != "League"){
    if($item['sport'] == $sport && $item['league'] == $league){
      foreach($item as $key => $value) {
        $output.= $key . ": " . $value . "<br>";
      }
      $results ++;
      $output.= "<br><br>";
    }
  }

  //Sport
  else{
    if($item['sport'] == $sport){
      foreach($item as $key => $value) {
        $output.= $key . ": " . $value . "<br>";
      }
      $results ++;
      $output.= "<br><br>";
    }
  }

} //Close foreach

if($results == 0){
  $error1 = "<h3>"  . $results . " results found" . "</h3><br>";
  $error2 = "No data found with the selected values. Try changing some of the values and try again.";

  array_push($returnArray, $error1, $error2);
  echo json_encode($returnArray);

}else{
  $results  = "<h3>" . $results . " results found</h3>";

  array_push($returnArray, $results, $output);
  echo json_encode($returnArray);
}

?>
