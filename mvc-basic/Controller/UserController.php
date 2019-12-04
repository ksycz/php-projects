<?php

//
  include_once("Model/User.php");

  // constructor instantiate a model, calls the modal class to get data, then passes data from model to view
  class UserController {
    public $model;
    public function __construct() {
    $this->model = new User();
  }

  public function invoke() {
    if(!isset($_GET['user'])) {
      $users = $this->model->getAllUser ();
      include 'View/usersList.php';
    }
    else{
      $user = $this->model->getUser($_GET['user']);
      include 'View/viewUser.php';
    }
  }
}
?>