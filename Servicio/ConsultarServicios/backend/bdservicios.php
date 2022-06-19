<?php 
    class database{
        private $con;
        function __construct(){
            $this->con = new PDO ('mysql:host = localhost;dbname=corpo206_buhitel','corpo206_gestorbuhi','ProyectoBuhitel2022');
        }
        //funciones
        

        public function consultarServicios($Hotel, $Hoy){
            $sql = $this->con->prepare("SELECT Servicio_ID, habitacion.Habitacion_Nombre, Servicio_Fecha, estatusservicio.EstatusServicio_Nombre FROM servicio
            INNER JOIN estatusservicio ON estatusservicio.EstatusServicio_ID = Servicio_Estatus
            INNER JOIN habitacion ON habitacion.Habitacion_ID = Servicio_Habitacion
            INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = habitacion.Habitacion_Tipo
            WHERE BINARY tipohabitacion.TipoHab_Hotel = '".$Hotel."'
            AND BINARY Servicio_Fecha > '".$Hoy."'
            AND BINARY Servicio_Estatus != '4'
            AND BINARY Servicio_Estatus != '3';");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function actualizarEstatus($Servicio, $Estatus){
            $sql = $this->con->prepare("UPDATE servicio SET Servicio_Estatus ='".$Estatus."' WHERE Servicio_ID = '".$Servicio."' ");
            $sql->execute();

            return "Actualizado";
        }

        public function cancelarServicio($Hotel, $Servicio){
            $sql = $this->con->prepare("DELETE FROM carritoproductos WHERE CarroProd_NumServicio = '".$Servicio."'");
            $sql->execute();
            $sql = $this->con->prepare("DELETE FROM servicio WHERE Servicio_ID = '".$Servicio."'");
            $sql->execute();
            
            return "Cancelado";
        }
        public function consultarCarritos($Hotel, $Servicio){
            $sql = $this->con->prepare("SELECT CarroProd_Producto, CarroProd_NumProductos, categoriaproductos.CatProd_ID, categoriaproductos.CatProd_Categoria, producto.Producto_Nombre, producto.Producto_Precio FROM carritoproductos
            INNER JOIN producto ON producto.Producto_ID = CarroProd_Producto
            INNER JOIN categoriaproductos ON categoriaproductos.CatProd_ID = producto.Producto_Categoria
            WHERE BINARY categoriaproductos.CatProd_Hotel = '".$Hotel."'
            AND BINARY carritoproductos.CarroProd_NumServicio = '".$Servicio."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarCategorias($Hotel){
            $sql = $this->con->prepare("SELECT CatProd_ID, CatProd_Categoria FROM categoriaproductos
            WHERE BINARY CatProd_Hotel = '".$Hotel."' ");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarProductos($Categoria){
            $sql = $this->con->prepare("SELECT Producto_ID, Producto_Nombre, Producto_Existencia FROM producto 
            WHERE BINARY Producto_Categoria ='".$Categoria."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function cambiarExistencia ($Producto, $Existencia){
            $sql = $this->con->prepare("UPDATE producto SET Producto_Existencia= '".$Existencia."' WHERE BINARY Producto_ID = '".$Producto."'");
            $sql->execute();
            return 1;
        }

        public function obtenerNumero($Servicio, $Hoy){
            $sql = $this->con->prepare("SELECT habitacionreservada.HabReservada_NumWhatsapp FROM servicio 
            INNER JOIN habitacion ON habitacion.Habitacion_ID = Servicio_Habitacion
            INNER JOIN habitacionreservada ON habitacionreservada.HabReservada_Habitacion = habitacion.Habitacion_ID
            INNER JOIN reservacion ON reservacion.Reservacion_ID = habitacionreservada.HabReservada_Reservacion
            WHERE BINARY Servicio_ID = '".$Servicio."'
            AND BINARY '".$Hoy."' BETWEEN reservacion.Reservacion_CheckIn AND reservacion.Reservacion_CheckOut");
            $sql->execute();
            $res = $sql->fetchall();
            $num;
            if ($res[0]['HabReservada_NumWhatsapp'] != '0') {
                $num = $res[0]['HabReservada_NumWhatsapp'];
            }
            else{
                $num = false;
            }
            return $num;
        }

        public function obtenerStatus($Estatus){
            $sql = $this->con->prepare("SELECT EstatusServicio_Nombre FROM estatusservicio WHERE EstatusServicio_ID = '".$Estatus."'");
            $sql->execute();
            $res = $sql->fetchall();
            $Nombre = $res[0]['EstatusServicio_Nombre'];
            return $Nombre;
        }

    }

?>