<?php 
session_start();
//if ($_SESSION['sesionPersonal']['Tipo']!='Administrador') {
//            header("Location: /index.php", TRUE, 301);
//}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="VistaGeneralReportes.css">
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">

    <title>Buhitel: Administrador</title>
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

    <section id="header-menu" class="header-menu" >

    </section>

    <section class="main">
        <section class="containCards">


        </section>
    </section>

    
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
    <script src="VistaGeneralReportes.js"></script>
    <? include('../../../Recursos/includeScripts.php') ?>
    
</body>
</html>