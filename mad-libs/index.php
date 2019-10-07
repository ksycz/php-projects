<?php
//   Mad Libs word game (replacing words in the story) from the Codecademy PHP course
function generateStory($singular_noun, $verb, $color, $distance_unit) {
   $new_texts = array($singular_noun, $verb, $color, $distance_unit);
  $replace  = array("lake", "dance", "blue", "kilometers");
  $subject = "The ${singular_noun}s are lovely, ${color}, and deep. \nBut I have promises to keep, \nAnd ${distance_unit} to go before I ${verb}, \nAnd ${distance_unit} to go before I ${verb}.";
  
  return str_replace($new_texts, $replace, $subject);
};

echo generateStory("lake", "dance", "blue", "kilometers");