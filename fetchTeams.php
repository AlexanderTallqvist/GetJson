<?php

// Start the session
session_start();

$sport = $_POST['sport'];

$output = "";
$results = 0;
$returnArray = array();
$leaguesArray = array();
$teamArray = array();

// Get data if not set
if(!isset($_SESSION['data_teams'])){

  // Get Json data
  $jsonData = file_get_contents("http://alexandertallqvist.net/sportdata.json");
  $array = json_decode($jsonData, true);

  if(is_array($array)){
     $_SESSION['data_teams'] = $array;
     $_SESSION['timeout_teams'] = time();
  }
}

// Refresh data if over 60 seconds has passed
if($_SESSION['timeout_teams'] + 1 * 60 < time()){

  // Get Json data
  $jsonData = file_get_contents("sportdata.json");
  $array = json_decode($jsonData, true);

  $_SESSION['data_teams'] = $array;
  $_SESSION['timeout_teams'] = time();
}

foreach ($_SESSION['data_teams'] as $index => $item) {
  if($item['sport'] == $sport){

    $leaguesString = "<option value='" . $item['league'] . "'>" .  $item['league'] . "</option>";
    if(!in_array($leaguesString, $leaguesArray)){array_push($leaguesArray, $leaguesString);};

    $teamString1 = "<option value='" . $item['team1'] . "'>" .  $item['team1'] . "</option>";
    $teamString2 = "<option value='" . $item['team2'] . "'>" .  $item['team2'] . "</option>";

    if(!in_array($teamString1, $teamArray)){array_push($teamArray, $teamString1);};
    if(!in_array($teamString2, $teamArray)){array_push($teamArray, $teamString2);};

    $results ++;
  }
}

//Join the created league and team arrays together
$leaguesAll = join("", $leaguesArray);
$teamAll = join("", $teamArray);


if($results == 0){
  $error1 = "<h3>"  ."No teams found. Please try another sport" . "</h3><br>";
  $error2 = "<h3>"  ."No leagues found. Please try another sport" . "</h3><br>";

  array_push($returnArray, $error1, $error2);
  echo json_encode($returnArray);

}else{
  array_push($returnArray, $teamAll, $leaguesAll);
  echo json_encode($returnArray);
}

?>
