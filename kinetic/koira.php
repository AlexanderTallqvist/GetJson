<?php

$hau = file_get_contents("http://alexandertallqvist.net/sportdata.json");

// Date filter
function date_filter($value, $data) {
  // oh doge
  $array = array();
  // Tarttee castaa $value jotenki dateks että voi ees vertailla
  $filter_date = new DateTime($value);
  foreach($data as $entry) {
    // Jompikumpi iffi
    $entry_date = new DateTime($entry.date);
    if($entry_date == $filter_date)
    // tai jos toimii
    // if ($value == $entry.date)
      array_push($array, $entry);
  }
  return $array;
}

// Team filter
function team_filter1($value, $data) {
  // oh doge
  $array = array();
  foreach($data as $entry) {
    if($entry.team == $value)
      array_push($array, $entry);
  }
  return $array;
}


$data = json_decode($hau);

echo "<pre>";
//print_r($data);
echo "</pre>";


$filters = array('date' => 'date_filter', 'team1' => 'team_filter1');
$ajax_request = '{"filters": {"date": "15.10.2015", "team1": "Houston Astros"}}';
$client_json = json_decode($ajax_request);
$return = [];


echo "<pre>";
//print_r($client_json);
echo "</pre>";

// Oletettavasti jos filttereillä on vaa yks value
foreach($client_json->filters as $filter_name=>$value) {
  if(in_array($filter_name, $filters)){
    echo "inside";
		$return[] = call_user_func($filters[$filter_name], $value, $data);
  }
}

echo json_encode($return);


?>
