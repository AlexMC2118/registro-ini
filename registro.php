<html>
  <head>
    <meta charset="utf-8">
    <title>Registro</title>
    <link rel="stylesheet" href="css/estiloregistro.css">
  </head>
  <body>
    <h1>REGISTRO DE USUARIOS</h1>
    <table>
      <tbody>
        <tr>
          <td>
            <form method="post">
              <div>
                <label>CORREO:</label>
                <input name="correo" type="text" value="" placeholder="Correo" required />
              </div>
              <div>
                <label>CONTRASEÑA:</label>
                <input maxlength="8" name="password" type="password" value="" placeholder="Contraseña" required />
              </div>
              <div>
                <label>PREFERENCIAS:</label>
                <div id="preferencias">
                  <?php
                    require_once("php/conectar.php");
                    if ($stmt = $conn->prepare("SELECT * FROM minijuegos")){
                      $stmt->execute();
                      $stmt->store_result();
                      $stmt->bind_result($id, $nombre, $url);
                      while($stmt->fetch()){
                        echo '<input type="checkbox" id="'.$id.'" name="minijuego'.$id.'" value="'.$id.'">
                              <label for="'.$id.'">'.$nombre.'</label><br>
                            ';
                      }
                    }
                  ?>
				        </div>
              </div>
              <div>
                <input name="submit" type="submit" value="REGISTRAR" name="registrar" />
              </div>
            </form>
          </td>
        </tr>
        <tr id="salir">
          <td><a href="php/exit.php">SALIR</a></td>
        </tr>
      </tbody>
    </table>
  </body>
</html>

<?php
  error_reporting(0);

  if(!strpos($_POST['correo'], "fundacionloyola") ) {
    echo "
          <div style='background-color: #34C8DB; padding: 10px; width: 380px; margin: 0 auto; text-align: center;'>
            <h4>TU CORREO NO PERTENECE A LA FUNDACION</h4>
          </div>
        ";
  }
  else{
    if ($stmt = $conn->prepare("INSERT INTO usuarios (correo, clave) VALUES (?, ?)")){
        $correo = $_POST['correo'];
  	    $password = $_POST['password'];
  	    $options = array("cost"=>4);
  	    $hashPassword = password_hash($password,PASSWORD_BCRYPT,$options);

        $stmt->bind_param("ss", $correo, $hashPassword);
  	    $stmt->execute();

        if (!$stmt->error){
          if ($stmt1 = $conn->prepare("SELECT idusuario FROM usuarios WHERE correo = ?")){
            $stmt1->bind_param('s', $_POST['correo']);
            $stmt1->execute();
            $stmt1->store_result();
            $stmt1->bind_result($iduser);
            $stmt1->fetch();
            if ($stmt2 = $conn->prepare("INSERT INTO preferencias (idminijuego, idusuario, preferencia) VALUES (?, ?, ?)")){
              if ($stmt3 = $conn->prepare("SELECT * FROM minijuegos")){
                $stmt3->execute();
                $stmt3->store_result();
                $stmt3->bind_result($idmini, $nombre, $url);
                $preferencias = array();
                while($stmt3->fetch()){
                  if(!empty($_POST['minijuego'.$idmini])){
                    $preferencias[] = $_POST['minijuego'.$idmini];
                  }
                }
              }
              $i=0;
              while($i<count($preferencias)){
                $valor = intval($preferencias[$i]);
                $afirmo = 1;
                $stmt2->bind_param('iii', $valor, $iduser, $afirmo);
                $stmt2->execute();
                $i++;
              }
            }
          }
          echo "
                <div style='background-color: #34C8DB; padding: 10px; width: 380px; margin: 0 auto; text-align: center;'>
                  <h4>USUARIO REGISTRADO CON EXITO</h4>
                </div>
              ";
        }
    }
  }
?>
