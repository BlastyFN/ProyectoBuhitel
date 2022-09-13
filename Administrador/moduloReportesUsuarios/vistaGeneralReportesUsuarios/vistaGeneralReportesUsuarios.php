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
    <link rel="stylesheet" href="vistaGeneralReportesUsuarios.css">
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">
    <title>Lista de usuarios</title>
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

    <section class="search">
        <form action="GET">
            <input type="text" class="searchElement" placeholder="busca reportes, tipos de reportes..." id="">
            <button type="submit" class="searchButton">Buscar</button>
        </form>

    </section>

    <section class="contenedorTablaReportes">
        <table class="tablaReportes">

        </table>

    

    </section>
    
    <script src="vistaGeneralReportesUsuarios.js"></script>
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
</body>
</html>