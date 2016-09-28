<?php

$jsondata = file_get_contents("teams.json");
$array = json_decode($jsondata, true);
$output = "";

$output = "<select><option value='team'>Choose a team</option>";

foreach ($array as $index => $item) {
  $output .= "<option value='" . $item['sport'] . "'>" .  $item['team'] . "</option>";
}

$output .= "</select>";
echo $output;

?>
