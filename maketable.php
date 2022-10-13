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
    array("name" => "None", "price" => "00", "date" => "0000-00-00") : $value;
}

function has_additionalInfo($value){
    
    if (array_key_exists('additionalInfo', $value)) {       
        return extract_values($value['additionalInfo']);
    }
    // check if it is empty
    else if (empty($value)) {        
        return array("name" => "None", "price" => "$00.00", "date" => "mm-dd-yyyy");
    }    
    else {
        
        return extract_values($value);
    }
}
// extract the values of the array
function extract_values($value){
    return array("name" => $value["name"], "price" => convertNumericToDollars($value["price"]), "date" => convert_date($value["date"]));
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

function convertNumericToDollars($price){
    if($price != null && is_numeric($price)){
        return "$".number_format($price, 2);
    }    
    else{
        return $price;
    }    
}


?>

<?php if (count($benefits_data) > 0): ?>
<table border=1>
  <thead>
    <tr>
      <td>Benefit Name</td>
      <td>Cost</td>
      <td>Benefit Date</td>
      <td>Code</td>
    </tr>
  </thead>
  <tbody>
<?php foreach ($benefits_data as $row): array_map('htmlentities', $row); ?>
    <tr>
      <td><?php echo implode('</td><td>', $row); ?></td>
    </tr>
<?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>