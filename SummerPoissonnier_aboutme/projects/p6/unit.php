<?php
function sanitizeString($str)
{
    $str = strip_tags($str);
    $str = htmlentities($str);
    $str = stripslashes($str);
    return $str;
}

function toKilometers($miles)
{
    return ($miles *1.609344); 
}

function toMiles($kilometers)
{
    return($kilometers*0.62137); 
}

if(isset($_POST['unit']))
{
    // sanitize unit
    $unit = sanitizeString($_POST['unit']);
    
    $output = "Error!";
    
    // business logic
    if(isset($_POST['conversion']) && $_POST['conversion'] === 'miles')
    {
        $output = $unit . " M == " . toKilometers($unit) . " KM";
    }
    else if(isset($_POST['conversion']) && $_POST['conversion'] === 'kilometers')
    {
        $output = $unit . " KM == " . toMiles($unit) . " M";       
    }
    
    // print unit
    echo $output;
}
?>   
    
