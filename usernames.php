<?php
$usernames = array("kenny","admin");
if  (in_array($_POST['username'], $usernames)) {
  echo "Unavailable";
} else {
  echo "Available";
}
?>
