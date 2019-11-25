<?php
// TODO: get it from db

$people[] = "Anne";
$people[] = "Bernard";
$people[] = "Chris";
$people[] = "Donna";
$people[] = "Elis";
$people[] = "Frank";
$people[] = "Gerard";
$people[] = "Henry";
$people[] = "Irene";
$people[] = "Jane";
$people[] = "Kate";
$people[] = "Louise";
$people[] = "Monica";
$people[] = "Natalie";
$people[] = "Otto";
$people[] = "Peter";
$people[] = "Richard";
$people[] = "Steve";
$people[] = "Tucker";
$people[] = "Ula";
$people[] = "Victor";
$people[] = "Winston";
$people[] = "Xavier";
$people[] = "Zoya";

// Get query string
$q = $_REQUEST['q'];
echo $q;

$suggestion = '';

// Get suggestions
if($q !== ''){
  $q = strtolower($q);
  $len = strlen($q);
  foreach($people as $person){
    // find first occurence of q in person
    if(stristr($q, substr($person, 0, $len))){
      if($suggestion === ""){
        $suggestion = $person;
      } else {
        // append another person that matches
        $suggestion .= ", $person";
      }
    }
  }
}

echo $suggestion === "" ? "No suggestions" : $suggestion;
