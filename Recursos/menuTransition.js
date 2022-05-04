const btnToggle = document.querySelector('.toggle-btn');
var estadoMenu = false;


btnToggle.addEventListener('click', (e) => {
    document.getElementById('sidebar').classList.toggle('active');
    

    if(estadoMenu == false){
        document.body.style.backgroundColor = '#427aa140';
        estadoMenu =true;
    }
    else{
        document.body.style.backgroundColor = '#ECE5F0';
        estadoMenu = false;
    }
});
