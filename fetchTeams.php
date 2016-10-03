<?php

$sport = $_POST['sport'];

$output = "";
$results = 0;
$returnArray = array();

$leaguesStart = "<h3>Leagues</h4><select class='league-dropdown'><option value='League'>Choose a league</option>";
$leaguesArray = array();

$teamStart = "<h3>Teams</h4><select class='team-dropdown'><option value='Team'>Choose a team</option>";
$teamArray = array();


//$jsondata = file_get_contents("http://alexandertallqvist.net/sportdata.json");
$jsondata = file_get_contents("sportdata.json");
$array = json_decode($jsondata, true);

foreach ($array as $index => $item) {
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

//Join the created league arrays together
$leaguesMiddle = join("", $leaguesArray);
$leaguesEnd = "</select>";
$leaguesOutput = $leaguesStart . $leaguesMiddle . $leaguesEnd;

//Join the created team arrays together
$teamMiddle = join("", $teamArray);
$teamEnd = "</select>";
$teamOutput = $teamStart . $teamMiddle . $teamEnd;


if($results == 0){
  $error1 = "<h3>"  ."No teams found. Please try another sport" . "</h3><br>";
  $error2 = "<h3>"  ."No leagues found. Please try another sport" . "</h3><br>";

  array_push($returnArray, $error1, $error2);
  echo json_encode($returnArray);

}else{
  array_push($returnArray, $teamOutput, $leaguesOutput);
  echo json_encode($returnArray);
}

?>
