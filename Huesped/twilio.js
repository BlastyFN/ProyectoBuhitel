const accountSid = "AC479a3f0203ff0e309abb54e9dd4ebb8f";
const authToken = "03e2cdfc8a864ef829867cfc16523037";
const client = require('twilio')(accountSid, authToken);
const VoiceResponse = require('twilio').twiml.VoiceResponse;

function enviarMensaje(destinatario, mensaje) {
    return new Promise((resolve, reject) =>{
        client.messages
      .create({
         from: 'whatsapp:+14155238886',
         body: mensaje,
         to: 'whatsapp:+'+destinatario
       })
      .then((message) => resolve())
      .catch((err)=>reject(err));
    });
}


function mandarFlow(destinatario, flow) {
  return new Promise((resolve, reject) =>{
    client.studio.v2.flows(flow)
    .executions
    .create({to: 'whatsapp:+'+destinatario, from: 'whatsapp:+14155238886'})
    .then((message) => resolve())
    .catch((err)=>reject(err));
  });
}

function regresarFlow(destinatario, flow) {
  const response = new VoiceResponse();
  response.redirect('https://webhooks.twilio.com/v1/Accounts/'+accountSid+'/Flows/'+flow+'?FlowEvent=return&amp;foo=bar');
}

module.exports={
    enviarMensaje,
    mandarFlow,
    regresarFlow
}
