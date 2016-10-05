<?php

// Get Json data
$jsonData = file_get_contents("sportdata.json");
$data = json_decode($jsonData, true);

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

// Array for checking values from the post
$check = array('Team', 'Date', 'League', 'Sport');

// We filter out empty values from the $_POST array
foreach ($check as $value) {
  if(($del = array_search($value, $_POST)) != false) {
    unset($_POST[$del]);
  }
}

// Call the filter function witht the Json data
$data = filter_all($_POST, $data);

//Add error message if $data is empty.
if(empty($data)){
  array_push($data, "No values found");
}

// Return Json formatted data
echo json_encode($data);

?>
