<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>View user</title>
</head>
<body>
  <?php
    echo '<b>Name: </b>' . $user->name . '<br/>';
    echo '<b>City: </b>' . $user->city . '<br/>';
    echo '<b>Country: </b>' . $user->country . '<br/>';
  ?>
</body>
</html>