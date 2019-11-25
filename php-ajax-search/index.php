<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact us</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script>
      function showSuggestion(str) {
        if(str.length == 0) {
          document.getElementById('output').innerHtml == '';
        } else {
          // Ajax request
          // setting it to the new object
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
            // 4 - ajax ready state, says that we already got the response
            if(this.readyState == 4 && this.status == 200) {
              // put response into output
              document.getElementById('output').innerHtml = this.responseText;
            }
          }
          xmlhttp.open("GET", "suggest.php?q="+str, true)
          xmlhttp.send();
        }
      }
    </script>
  </head>
  <body>
    <div class="container">
      <h1>Search users</h1>
      <form>
        <label>Search user:</label>
        <input type="text" class="form-control" onkeyup="showSuggestion(this.value)">
        <p>Suggestion: <span id="output" style="font-weight: bold"></span></p>
      </form>
    </div>
  <body>
</html>