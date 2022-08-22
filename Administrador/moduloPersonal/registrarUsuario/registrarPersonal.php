<?php 
session_start();
//if ($_SESSION['sesionPersonal']['Tipo']!='Administrador') {
 //           header("Location: /index.php", TRUE, 301);
//}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../recursos/estilos-menu.css">
    <link rel="stylesheet" href="registrarPersonal.css">
    <title>Registro de nuevo usuario</title>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-firestore.js"></script>
    <script>
       
       const firebaseConfig = {
            apiKey: "AIzaSyBrHawuSKbh1cqGl5rAAldb6JBhnClp6z0",
            authDomain: "chatbuhitel.firebaseapp.com",
            projectId: "chatbuhitel",
            storageBucket: "chatbuhitel.appspot.com",
            messagingSenderId: "483326716419",
            appId: "1:483326716419:web:05f9f5595cc415e3567c36"
        };
        firebase.initializeApp(firebaseConfig);
    </script>
</head>
<body>
    <section id="header-menu" class="header-menu">

    </section>

    <h1>
        Ingrese la información del nuevo usuario
    </h1>
    <section class="contFormulario">
        <form class="formNuevoUsuario" action="" method="post">
            <input type="text" class="formText" id="nombreUsr" placeholder="Nombres">
            <div class="apellidos">
                <input type="text" class="formText" id="apellidoP" placeholder="Apellido paterno">
                <input type="text" class="formText" id="apellidoM" placeholder="Apellido materno">
            </div>
            
            <select name="tipoPersonal" id="tipoPersonal" class="formText">
                <option selected="true" disabled>Tipo de personal</option>
                <option value="Recepcion">Recepcionista</option>
                <option value="Limpieza">Personal de limpieza</option>
                <option value="Valet">Valet parking</option>
                <option value="Servicio">Personal de servicio</option>
                
            </select>

            <input type="text" class="formText" id="correoUsr" placeholder="Correo">
            <input type="text" class="formText" id="password" placeholder="Contraseña">
            <input type="text" class="formText" id="seguroSocial" placeholder="Número de seguridad social">
            <br>
            
    
            <button type="submit" class="enviarInfo">Aceptar</button>
  
        </form>
        
    </section>
    <script src="registrarPersonal.js"></script>
    <script src="../../../recursos/clase-menu.js"></script>
    <script src="../../../recursos/menuTransition.js"></script>
    
</body>
</html>