<?php 
function redirect($location)
{
 if(!$location) return;
  @header("location: {$location}");   
 exit(0);
}

?>