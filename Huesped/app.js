//DECLARACIONES
const express = require('express');
const app = express();
const twilio = require("./twilio");
app.use(express.json());
app.use(express.urlencoded({extended: true}));
const bd = require("./bdhuesped");
//VARIABLES GLOBALES
const flowPrueba = "FW1879f59eb494bf65aa90bfebd5ba8b36";
//FIN VARIABLES

app.post('/codigo', function (req, res) {
  console.log("Codigo");
  console.log("req ->", req);
  console.log("FIN");
  res.status(200).json({ok:true, msg:"Mensaje enviado correctamente"});
  twilio.regresarFlow(req.body.WaId, flowPrueba);
});

// app.post('/webhook', function (req, res) {
//   console.log("req ->", req.body);
//   bd.consultarNumero(req.body.WaId).then((res)=>{
//     let HOlaqase = JSON.stringify(res);
//     let infoJSON = JSON.parse(HOlaqase);
    
//     console.log("cantidad: "+infoJSON.length);
//     if (infoJSON.length>0) {
//       //NUMERO ESTÁ REGISTRADO ; DESPLEGAR MENU
//       // twilio.enviarMensaje(req.body.WaId, req.body.ProfileName + " Has mandado " +req.body.Body);
//       twilio.enviarMensaje(req.body.WaId, "Hola de nuevo "+ req.body.ProfileName +"! ");
//     }
//     else{
//       twilio.mandarFlow(req.body.WaId, flowPedirCodigo);
      
//     }
//   });
  
//   console.log("Mensaje enviado"+res);
//   console.log("FIN");
//   res.status(200).json({ok:true, msg:"Mensaje enviado correctamente"});
// });





app.listen(3000, ()=>{
  console.log("Servidor montado en el puerto 3000");
});