<!-- Createc based on https://www.youtube.com/watch?v=tJ5eUgOxITE&list=PLillGF-Rfqbap2IB6ZS4BBBcYPagAjpjn&index=15 -->
<?php

// Alerts vars
$alert = '';
// we need this class for bootstrap
$alertClass = '';

// check for submit
if(filter_has_var(INPUT_POST, 'submit')){
  // echo "Form submitted";
  // get form data
  $name = htmlspecialchars($_POST['name']);
  $email = htmlspecialchars($_POST['email']);
  $message = htmlspecialchars($_POST['message']);

  // check required fields
  if(!empty($name) && !empty($email) && !empty($message)){
    // Passed

    // check email
    if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
      // Failed
      $alert = 'Please use a valid email format';
      $alertClass = 'alert-danger';
    } else {
      // Passed
      // Recipient email
      $toEmail = 'katarzynasycz@gmail.com';
      $subject = 'Contact form'.$name;
      $body = '<h2>Contact form</h2>
                <h4>Name:</h4><p>'.$name.'</p>
                <h4>Email:</h4><p>'.$email.'</p>
                <h4>Message:</h4><p>'.$message.'</p>
    ';
      // Email headers
      $headers = "MIME-Version: 1.0"."\r\n";
      // append another .=
      $headers .= "Content-Type: text/html;charset=UTF-8"."\r\n";
      // Additional headers
      $headers .= "From: ".$name."<".$email.">"."\r\n";

      if(mail($toEmail, $subject, $body, $headers)) {
        // Email sent
        $alert = "Your email has been sent";
        $alertClass = "alert-success";
      } else {
        // Email note sent
        $alert = "Your email has not been sent";
        $alertClass = "alert-danger";
      }
    }
  } else {
    // Failed
    $alert = 'Please fill in all fields.';
    $alertClass = 'alert-danger';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Contact us</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">My Test Website</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </nav>

  <div class="container mt-5">
    <h2>Contact us</h2>
    <?php if($alert != '') : ?>
      <div class="alert <?php echo $alertClass; ?>"><?php echo $alert; ?></div>
    <?php endif; ?>
    <!-- using PHP_SELF to submit form to this site -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="form-group">
        <label for="name">Name</label>
        <!-- if name was submitted, display it -->
        <input class="form-control" type="text" name="name" value="<?php echo isset($_POST['name']) ? $name : ''; ?>">
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input class="form-control" type="text" name="email" value="<?php echo isset($_POST['email']) ? $email : ''; ?>">
      </div>
      <div class="form-group">
        <label for="message">Message</label>
        <textarea class="form-control" name="message"><?php echo isset($_POST['message']) ? $message : ''; ?> </textarea>
      </div>
      <input class="btn btn-primary" type="submit" name="submit" />
    </form>
  </div>
</body>
</html>