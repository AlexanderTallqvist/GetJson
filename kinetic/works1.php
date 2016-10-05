<?php

//Works as long as contetntType Json isn't set.

//Prepare variables and arrays
$index_array  = [];
$list_array   = [];
$return_array = [];

//Get Json data
$jsonData = file_get_contents("sportdata.json");
$data = json_decode($jsonData, true);

//Filters array
$filters = [
  'sport' => 'sport_filter',
  'date'  => 'date_filter',
  'team'  => 'team_filter',
  'league'=> 'league_filter',
];

//Loop through the $_POST variable
foreach ($_POST as $key => $value) {
  if(array_key_exists($key, $filters)){
    array_push($index_array, call_user_func($filters[$key], $value, $data));
  }
}

//Team function
function team_filter($value, $data){
  $team_index = [];
  foreach ($data as $index => $item){
    if($item['team1'] == $value || $item['team2'] == $value){
      array_push($team_index, $index);
    }
  }if(!empty($team_index)){
    return $team_index;
  }
}

//Sport function
function sport_filter($value, $data){
  $sport_index = [];
  foreach ($data as $index => $item){
    if($item['sport'] == $value ){
      array_push($sport_index, $index);
    }
  }if(!empty($sport_index)){
    return $sport_index;
  }
}

//League function
function league_filter($value, $data){
  $league_index = [];
  foreach ($data as $index => $item){
    if($item['league'] == $value){
      array_push($league_index, $index);
    }
  }if(!empty($league_index)){
    return $league_index;
  }
}

//Date function
function date_filter($value, $data){
  $date_index = [];
  foreach ($data as $index => $item){
    if($item['date'] == $value){
      array_push($date_index, $index);
    }
  }if(!empty($date_index)){
    return $date_index;
  }
}

//Filter out empty values from $index_array. Push new values to $list[].
$filtered_array = array_filter($index_array);
foreach ($filtered_array as $item) {
  array_push($list_array, $item);
}

//Make sure that $list[] has more than one (1) value. Intersect all arrays from $list[].
//Push correct values from $data[] to $return_array[].
if(count($list_array) != 1){
  $intersect = call_user_func_array('array_intersect', $list_array);
  foreach ($intersect as $key => $value) {
    array_push($return_array, $data[$value]);
  }
}else{
  foreach ($list_array as $index => $item) {
    foreach ($item as $key => $value) {
      array_push($return_array, $data[$value]);
    }
  }
}

echo json_encode($return_array);


?>
