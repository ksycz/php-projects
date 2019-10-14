<?php
include("../config.php");

if(isset($_POST["linkId"])) {
  $query = $connection->prepare("UPDATE websites SET clicks = clicks + 1 WHERE id=:id");
  $query->bindParam(":id", $_POST["linkId"]);
  $query->execute();
}
else {
  echo "No link passed";
}