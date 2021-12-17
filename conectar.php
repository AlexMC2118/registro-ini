<?php
  $conn = mysqli_connect("localhost","root","","minijuegos-sesion");

  if(!$conn){
  	die("Connection error: " . mysqli_connect_error());
  }
?>
