<?php

// Start the session
session_start();

// Get data if not set
if(!isset($_SESSION['data'])){

  // Get Json data
  $scoreJson = file_get_contents("http://alexandertallqvist.net/sportdata.json");
  $data = json_decode($scoreJson, true);

  if(is_array($data)){
     $_SESSION['data'] = $data;
     $_SESSION['timeout'] = time();
  }
}

// Refresh data if over 60 seconds has passed
if($_SESSION['timeout'] + 1 * 60 < time()){

  // Get Json data
  $scoreJson = file_get_contents("http://alexandertallqvist.net/sportdata.json");
  $data = json_decode($scoreJson, true);

  $_SESSION['data'] = $data;
  $_SESSION['timeout'] = time();
}


// Fields to be checked by key
$fields = array(
  'team' 	=> array('team1', 'team2'),
  'date' 	=> array('date'),
  'league'=> array('league'),
  'sport' => array('sport'),
);

// Check if the desired value exists in the data
function check_values($item, $values) {
  global $fields;
  foreach ($values as $key => $value) {
    foreach ($fields[$key] as $field) {
      // Return true if either of the teams match. Checked last
      if($field == 'team1' || $field == 'team2'){
        if($item['team1'] == $value || $item['team2'] == $value){
          return true;
        }
      }
      if(!($item[$field] == $value)){
        return false;
      }
    }
  }return true;
}

// Return desired values from check_values
function filter_all($values, $data){
  $items = [];
  foreach ($data as $index => $item){
    if(check_values($item, $values)){
      array_push($items, $item);
    }
  }return $items;
}

// Function for sorting the dates
function sortFunction( $a, $b ) {
  return strtotime($a["date"]) > strtotime($b["date"]) ? -1 : 1;
}

// Array for checking values from the post
$check = array('Team', 'Date', 'League', 'Sport');

// We filter out empty values from the $_POST array
foreach ($check as $value) {
  if(($del = array_search($value, $_POST)) != false) {
    unset($_POST[$del]);
  }
}

// Call the filter function witht the Json data
$data = filter_all($_POST, $_SESSION['data']);

// Add error message if $data is empty.
// Arrange the data by the filter before returning it
// If data isn't empty
if(empty($data)){
  array_push($data, "No values found");
}else{
  /*foreach ($data as $key => $row) {
      $team[$key] = $row['team1'];
  }
  array_multisort($team, SORT_ASC, $data);*/
  usort($data, "sortFunction");
}

$data = array_splice($data, 0, 10);

// Return Json formatted data
echo json_encode($data);

?>
