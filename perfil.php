<?php
  // Solo se permite el ingreso con el inicio de sesion.
  session_start();
  // Si el usuario no se ha logueado se le regresa al inicio.
  if (!isset($_SESSION['loggedin'])) {
  	header('Location: login.html');
  	exit;
  }
?>


<html>
  <head>
    <meta charset="utf-8">
    <title>Inicio</title>
    <link rel="stylesheet" href="css/estiloperfil.css">
  </head>
  <body>
    <table>
      <tr>
        <td>
          <h2> INGRESÓ A LA BASE DE DATOS DE MINIJUEGOS</h2>
        </td>
      </tr>
      <tr>
        <td>
          <p> Bienvenido <?=$_SESSION['correo']?>.</p>
        </td>
      </tr>
      <tr>
        <td id="salir">
          <a href='php/exit.php'>SALIR</a>
        </td>
      </tr>
    </table>
  </body>
</html>
