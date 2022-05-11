<?php 
    class database{
        private $con;
        function __construct(){
            $this->con = new PDO ('mysql:host = localhost;dbname=buhitel','root','');
        }
        //funciones
        

        public function consultarServicios($Hotel, $Hoy){
            $sql = $this->con->prepare("SELECT Servicio_ID, habitacion.Habitacion_Nombre, Servicio_Fecha, estatusservicio.EstatusServicio_Nombre FROM servicio
            INNER JOIN estatusservicio ON estatusservicio.EstatusServicio_ID = Servicio_Estatus
            INNER JOIN habitacion ON habitacion.Habitacion_ID = Servicio_Habitacion
            INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = habitacion.Habitacion_Tipo
            WHERE BINARY tipohabitacion.TipoHab_Hotel = '".$Hotel."'
            AND BINARY Servicio_Fecha > '".$Hoy."'
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

    }

?>