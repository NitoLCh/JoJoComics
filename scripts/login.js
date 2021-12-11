const datos = {
    email: '',
    contraseña: ''
};

//Expresiones regulares
const expresiones = {
    correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
    contraseña: /^.{4,12}$/
};

//querySelector
const correo = document.querySelector('#email');
const contraseña = document.querySelector('#contraseña');
const formulario = document.querySelector('#login');
const inputs = document.querySelectorAll('#login input');


//Eventos
correo.addEventListener('input', obtenerId);
contraseña.addEventListener('input', obtenerId);

//Submit
/*formulario.addEventListener('submit', function(evento){
    evento.preventDefault();

    //Validacion de formulario
    const {email,contraseña} = datos;
    
    //Campos vacios
    if(email === '' || contraseña === ''){
        mostrarAlerta('llena los campos', 'error');
    }
    else{
        mostrarAlerta('campos llenos');
    }
});*/

//Validacion de campos
const validarCampo = (evento) => {
    switch(evento.target.id){
        case "email":
            if(expresiones.correo.test(datos.email)){
                document.querySelector('#email').classList.remove('alerta', 'error');//Clase CSS de error
                document.querySelector('#email').classList.add('alerta', 'exito');//Clase CSS de correcto
            }
            else{
                document.querySelector('#email').classList.add('alerta', 'error');//Clase CSS de error
                document.querySelector('#email').classList.remove('alerta', 'exito');//Clase CSS de correcto

                //Volver a las propiedades originales en 3 seg
                setTimeout(() =>{
                    document.querySelector('#email').classList.remove('alerta', 'exito');//Clase CSS de error
                    document.querySelector('#email').classList.add('formulario__campo');//Clase CSS de correcto
                }, 3000)
            } 
        break;
        case "contraseña":
            if(expresiones.contraseña.test(datos.contraseña)){
                document.querySelector('#contraseña').classList.remove('alerta', 'error');//Clase CSS de error
                document.querySelector('#contraseña').classList.add('alerta', 'exito');//Clase CSS de correcto
            }
            else{
                document.querySelector('#contraseña').classList.add('alerta', 'error');//Clase CSS de error
                document.querySelector('#contraseña').classList.remove('alerta', 'exito');//Clase CSS de correcto

                //Volver a las propiedades originales en 3 seg
                setTimeout(() =>{
                    document.querySelector('#contraseña').classList.remove('alerta', 'exito');//Clase CSS de error
                    document.querySelector('#contraseña').classList.add('formulario__campo');//Clase CSS de correcto
                }, 3000)
            } 
        break;
    }
};

inputs.forEach((input) =>{
    input.addEventListener('keyup', validarCampo);
    input.addEventListener('blur', validarCampo);
});

//Funciones
function obtenerId(evento){
    datos[evento.target.id] = evento.target.value;
}

//Campos vacios
/*function mostrarAlerta(mensaje, tipo = null){
    const alerta = document.createElement('P');
    alerta.textContent = mensaje;

    //Clase CSS
    if(tipo){
        alerta.classList.add('error');
    }
    else{
        alerta.classList.add('exito');
    }

    formulario.appendChild(alerta);

    //Desaparecer despues de 3 seg
    setTimeout(() =>{
        alerta.remove();
    }, 3000)
}*/