const mysql = require("mysql");
const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database:'buhitel',

});

connection.connect(function(error){
    if (error) {
        throw error;
    }else{
        console.log("Conexion exitosa");
    }
});
//FUNCION QUE CONSULTA SI EL CODIGO EXISTE
function consultarCodigo(codigo){
    return new Promise((resolve, reject) => {
        const Var = connection.query("SELECT * FROM habitacionreservada WHERE HabReservada_CodigoWhatsapp = '"+codigo+"' AND BINARY HabReservada_NumWhatsapp = '0'", (err, result) => {
            if (err) {
              return reject(err)
            }
            return resolve(result)
          });
    });
}

//FUNCION QUE CONSULTA SI EL CODIGO EXISTE
function consultarNumero(numero){
    return new Promise((resolve, reject) => {
        const Var = connection.query("SELECT * FROM habitacionreservada WHERE BINARY HabReservada_NumWhatsapp = '"+numero+"'", (err, result) => {
            if (err) {
              return reject(err)
            }
            return resolve(result)
          });
    });
}


module.exports={
    consultarCodigo,
    consultarNumero,
}

// connection.end();