<?php
  session_start();
  require_once("conectar.php");

  //VERIFICACION DE ESCRITURA DE DATOS EN EL FORM
	if ( !isset($_POST['correo'], $_POST['password'])){
	   exit('Completa los campos por favor');
	}

  //  SI SE CONECTO Y SI SE ENVIARON AMBOS DATOS SE PROCEDE CON LA CONSULTA DE EXISTENCIA DEL USUARIO EVITANDO INYECCIONES SQL
  if ($stmt = $conn->prepare('SELECT correo, clave FROM usuarios WHERE correo = ?')){
  	$stmt->bind_param('s', $_POST['correo']);
  	$stmt->execute();
  	$stmt->store_result();

   // SI EL USUARIO EXISTE EN LA TABLA SE EXTRAE Y SE APUNTA SU CORREO Y SU CLAVE
   if ($stmt->num_rows > 0){
      $stmt->bind_result($correo, $clave);
      $stmt->fetch();

      // AHORA VERIFICA SI LA CLAVE QUE SE EXTRAJO DE LA TABLA ES IGUAL A LA QUE SE ENVIA DESDE EL FORMULARIO
      if(password_verify( $_POST['password'],$clave)){
        // SI COINICIDEN AMBAS CONTRASEÑAS SE INICIA LA SESION Y SE LE DA LA BIENCENIDA AL USUARIO CON ECHO
        session_regenerate_id();
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['correo'] = $_POST['correo'];
        header('Location: ../perfil.php');
      }

      // SI EL USUARIO EXISTE PERO EL PASSWORD NO COINCIDE IMPRIMIR EN PANTALLA PASSWORD INCORRECTO
      else {
        echo "
              <div style='background-color: #34C8DB; padding: 20px; width: 400px; margin: 0 auto; text-align: center;'>
                <h2 style='color: red'>¡CONTRASEÑA INCORRECTA!</h2>
                <a href='exit.php' style='text-decoration: none; color: white;'>SALIR</a>
              </div>
            ";
      }
    }

    // SI EL USUARIO NO EXISTE MOSTRAR CORREO INCORRECTO
		else {
      echo "
            <div style='background-color: #34C8DB; padding: 20px; width: 400px; margin: 0 auto; text-align: center;'>
              <h2 style='color: red'>¡CORREO INCORRECTO!</h2>
              <a href='exit.php' style='text-decoration: none; color: white;'>SALIR</a>
            </div>
          ";
    }
  	$stmt->close();
  }
?>
