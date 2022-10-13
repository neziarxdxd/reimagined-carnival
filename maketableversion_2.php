<?php
$listOfFiles = array (
    'benefits' => 
    array (
      'GTX-780ti' => 
      array (
        'name' => 'OP-HealthCare',
        'price' => 120.0,
        'date' => '2015-06-11',
      ),
      'XFX-280x' => 
      array (
      ),
      970 => 
      array (
        'additionalInfo' => 
        array (
          'name' => 'LifeInsurance',
          'price' => 50.00,
          'date' => '2015-04-23',
        ),
      ),
      'HD6870' => 
      array (
        'name' => 'LTD',
        'price' => '$60.00',
        'date' => 'May 5, 2015',
      ),
    ),
);



$benefits = $listOfFiles['benefits'];

$keys = array_keys($benefits);

$benefits_values = array_values($benefits);

$benefits_data = array();

foreach ($keys as $key => $value) {   
    $filtered_data= has_additionalInfo($benefits_values[$key]) + array('code' => $value);
    array_push($benefits_data, $filtered_data);
    
}

function is_empty($value) {
   is_null($value) || $value === '' || $value === false || $value === array() ?
    array("name" => "None", "price" => 00, "date" => "0000-00-00") : $value;
}

function has_additionalInfo($value){
    
    if (array_key_exists('additionalInfo', $value)) {       
        return extract_values($value['additionalInfo']);
    }
    // check if it is empty
    else if (empty($value)) {        
        return array("name" => "None", "price" => 0.0, "date" => "mm-dd-yyyy");
    }    
    else {
        
        return extract_values($value);
    }
}
// extract the values of the array
function extract_values($value){
    return array("name" => $value["name"], "price" => dollarToInteger($value["price"]), "date" => convert_date($value["date"]));
}

// convert date from 2015-01-01 to Jan 1, 2015
function convert_date($date){
    if($date != null){
        $date = date_create($date);
        // no leading zero
        $date = date_format($date, "M j, Y");
        return $date;
    }
    else{
        return "mm-dd-yyyy";
    }    
}

 // convert dollar amount to integer with leading zero
 function dollarToInteger($value){
    if($value != null){
        // remove dollar sign and convert to float
        $value = floatval(preg_replace('/[^\d.]/', '', $value));
        return $value;        
    }
    else{
        return 0.0;
    }
  }

function convertNumericToDollars($price){
    
    if($price != null && is_numeric($price) && $price > 0){
        return "$".number_format($price, 2);
    }    
    else{
        return "$00.00";
    }    
}


?>

<?php
echo "<table border='1'> ";
echo "<tr><td>Benefit Name</td><td>Cost</td><td>Benefit Date</td><td>Code</td></tr>";
for($i=0; $i < count($benefits_data); $i++){
  echo "<tr>";
 
    echo "<td>".$benefits_data[$i]['name']."</td>";
    echo "<td>".convertNumericToDollars($benefits_data[$i]['price'])."</td>";
    echo "<td>".$benefits_data[$i]['date']."</td>";
    echo "<td>".$benefits_data[$i]['code']."</td>";
    echo "</tr>";   
    echo "</td>";
}
echo "</table>";

?>