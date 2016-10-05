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

//Check if the desired value exists in the data
function check_values($item, $values) {
  global $fields;
  echo "<pre>";
  echo "Item from json file: <br>";
  print_r($item);
  echo "<br><br>";
  echo "Values from post array: <br>";
  print_r($values);
  echo "</pre>";
  foreach ($values as $key => $value) {
    echo "<pre>";
    echo "Key from post array: <br>";
    print_r($key);
    echo "<br><br>";
    echo "Value from post array: <br>";
    print_r($value);
    echo "</pre>";
    foreach ($fields[$key] as $field) {
      if($field == 'team1' || $field == 'team2'){
        if($item['team1'] == $value || $item['team2'] == $value){
          return true;
        }
      }
      echo "<pre>";
      echo "Key value from fields: <br>";
      print_r($field);
      echo "<br>";
      echo "</pre>";
      echo "<pre>";
      echo "Value from item array with field key: <br>";
      print_r($item[$field]);
      echo "<br><br>";
      echo "</pre>";
      if(!($item[$field] == $value)){
        echo "Item " . $value . " did not go through";
        return false;
      }
    }
  }return true;
}

//Return desired values from check_values
function filter_all($values, $data){
  $items = [];
  foreach ($data as $index => $item){
    if(check_values($item, $values)){
      array_push($items, $item);
    }
  }return $items;
}

//Array for checking values from the post
$check = array(
  'Team'   => 'Team',
  'Date'   => 'Date',
  'League' => 'League',
  'Sport'  => 'Sport',
);

//We filter out empty values from the $_POST array
foreach ($check as $key => $value) {
  if(($del = array_search($value, $_POST)) !== false) {
      unset($_POST[$del]);
  }
}

echo "<pre>";
print_r($_POST);
echo "</pre>";

$data = filter_all($_POST, $data);
//echo json_encode($data);
//$ajax = json_decode('{"sport":"Korgboll", "team":"Korgbollslag"}');
//$data = filter_all($ajax, $data);

if(empty($data)){
  echo "No values found";
}else{
  echo json_encode($data);
}

?>
