<?php
// router divides URL retrieved by request and divides it into parts
class Router
{
  static public function parse($url, $request)
  {
    $url = trim($url);
    if ($url == "/php-projects/mvc-for-todo-app/")
    {
      $request->controller = "tasks";
      $request->action = "index";
      $request->params = [];
    }
    else
    {
      $explode_url = explode('/', $url);
      $explode_url = array_slice($explode_url, 2);
      $request->controller = $explode_url[1];
      $request->action = $explode_url[2];
      $request->params = array_slice($explode_url, 3);
    }
  }
}
?>
