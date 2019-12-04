<!-- The view is responsible for formatting the data received from the model in a form accessible to the user. The view layer can use a template system to render the html pages. -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All users</title>
  </head>
  <body>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>City</th>
          <th>Country</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($users as $key => $user)
        {
        echo '<tr>
          <td>
            <a href="index.php?user='.$user->name.'">'.$user->name.'</a>
          </td>
          <td>'.$user->city.'</td>
          <td>'.$user->country.'</td>
          </tr>';
        }
      ?>
    </tbody>
  </table>
  </body>
</html>