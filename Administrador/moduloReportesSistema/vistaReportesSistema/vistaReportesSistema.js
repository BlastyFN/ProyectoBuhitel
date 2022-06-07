const grafica = document.getElementById('grafica');
var chart = new Chart(grafica,{
    type:"line",
    data:{
        labels: ["Mazapanes","hamburguesa","Pizza","Agua","coca","sprite","pepsi"],
        datasets:[
            {
                label:"Semanal",
                backgroundColor:"#59114D",
                borderRadius:"20px",
                data:[4,5,6,7,8,9,100]
            }
        ]
      
    }
})

// const config = {
//     type: 'line',
//     data: data,
//     options: {
//       scales: {
//         y: {
//           beginAtZero: true
//         }
//       }
//     },
//   };

  window.addEventListener('load', () =>{
    fetch('../backendReportesSistema/obtenerIngresosGeneralesServicio.php' , {
        method:'POST'
    }).then(function(response){
        if(response.ok){
         return response.json();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(info){
        console.log(info);

        
        
    })
})