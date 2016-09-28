<?php

$sport = $_POST['sport'];
$date  = $_POST['date'];

$output = "";
$results = 0;

$leaguesStart = "<h3>Leagues</h4><select><option value='leagues'>Choose a league</option>";
$leaguesArray = array();

$teamStart = "<h3>Teams</h4><select><option value='teams'>Choose a team</option>";
$teamArray = array();


//$jsondata = file_get_contents("http://alexandertallqvist.net/sportdata.json");
$jsondata = file_get_contents("sportdata.json");
$array = json_decode($jsondata, true);

foreach ($array as $index => $item) {
  if(isset($_POST['sport']) && $date != ""){
    if($item['sport'] == $sport && $item['date'] == $date){
      foreach($item as $key => $value) {
        $output.= $key . ": " . $value . "<br>";
      }

      $leaguesString = "<option value='" . $item['league'] . "'>" .  $item['league'] . "</option>";
      if(!in_array($leagueString, $leaguesArray)){array_push($leaguesArray, $leaguesString);};

      $teamString1 = "<option value='" . $item['team1'] . "'>" .  $item['team1'] . "</option>";
      $teamString2 = "<option value='" . $item['team2'] . "'>" .  $item['team2'] . "</option>";

      if(!in_array($teamString1, $teamArray)){array_push($teamArray, $teamString1);};
      if(!in_array($teamString2, $teamArray)){array_push($teamArray, $teamString2);};

      $results ++;
      $output.= "<br><br>";
    }
  }elseif(isset($_POST['sport'])){
    if($item['sport'] == $sport){
      foreach($item as $key => $value) {
        $output.= $key . ": " . $value . "<br>";
      }

      $leaguesString = "<option value='" . $item['league'] . "'>" .  $item['league'] . "</option>";
      if(!in_array($leaguesString, $leaguesArray)){array_push($leaguesArray, $leaguesString);};

      $teamString1 = "<option value='" . $item['team1'] . "'>" .  $item['team1'] . "</option>";
      $teamString2 = "<option value='" . $item['team2'] . "'>" .  $item['team2'] . "</option>";

      if(!in_array($teamString1, $teamArray)){array_push($teamArray, $teamString1);};
      if(!in_array($teamString2, $teamArray)){array_push($teamArray, $teamString2);};

      $results ++;
      $output.= "<br><br>";
    }
  }
}

$leaguesMiddle = join("", $leaguesArray);
$leaguesEnd = "</select>";
$leaguesOutput = $leaguesStart . $leaguesMiddle . $leaguesEnd;

$teamMiddle = join("", $teamArray);
$teamEnd = "</select>";
$teamOutput = $teamStart . $teamMiddle . $teamEnd;

if($results == 0){
  echo "<h3>"  . $results . " results found" . "</h3>";
  echo "No data found with the selected values. Try changing some of the values and try again.";
}else{
  echo $teamOutput . "<br>";
  echo $leaguesOutput . "<br>";
  echo "<h3>"  . $results . " results found" . "</h3>";
  echo $output;
}

?>
