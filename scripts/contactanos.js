const datos = {
    nombre: '',
    correo:'',
    comic: '',
    editorial: '',
    año: 0
};

//Regex
const expresiones = {
    regex1: /^[a-zA-ZÀ-ÿ\s]{1,50}$/, //nombre y editorial
    regex2: /^[a-zA-Z0-9\s]{1,50}$/, //comic
    regex3: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/, //correo
    regex4: /^\d{4,5}$/ //año
};


//querySelector
const nombre = document.querySelector('#nombre');
const correo = document.querySelector('#correo');
const comic = document.querySelector('#comic');
const editorial = document.querySelector('#editorial');
const año = document.querySelector('#año');
const formulario = document.querySelector('.formulario');
const inputs = document.querySelectorAll('#formulario input');

//Eventos
nombre.addEventListener('input', obtenerId);
correo.addEventListener('input', obtenerId);
comic.addEventListener('input', obtenerId);
editorial.addEventListener('input', obtenerId);
año.addEventListener('input', obtenerId);


//Error en algun campo
const validarCampo = (evento) => {
    switch(evento.target.id){
        case "nombre":
            if(expresiones.regex1.test(datos.nombre)){
                document.querySelector('#nombre').classList.remove('alerta', 'error');//Clase CSS de error
                document.querySelector('#nombre').classList.add('alerta', 'exito');//Clase CSS de correcto
            }
            else{
                document.querySelector('#nombre').classList.add('alerta', 'error');//Clase CSS de error
                document.querySelector('#nombre').classList.remove('alerta', 'exito');//Clase CSS de correcto

                //Volver a las propiedades originales en 3 seg
                setTimeout(() =>{
                    document.querySelector('#nombre').classList.remove('alerta', 'exito');//Clase CSS de exito
                    document.querySelector('#nombre').classList.add('formulario__campo');//Clase CSS de correcto
                }, 3000)
            }
        break;
        case "correo":
            if(expresiones.regex3.test(datos.correo)){
                document.querySelector('#correo').classList.remove('alerta', 'error');//Clase CSS de error
                document.querySelector('#correo').classList.add('alerta', 'exito');//Clase CSS de correcto
            }
            else{
                document.querySelector('#correo').classList.add('alerta', 'error');//Clase CSS de error
                document.querySelector('#correo').classList.remove('alerta', 'exito');//Clase CSS de correcto

                //Volver a las propiedades originales en 3 seg
                setTimeout(() =>{
                    document.querySelector('#correo').classList.remove('alerta', 'exito');//Clase CSS de error
                    document.querySelector('#correo').classList.add('formulario__campo');//Clase CSS de correcto
                }, 3000)
            }
        break;
        case "comic":
            if(expresiones.regex2.test(datos.comic)){
                document.querySelector('#comic').classList.remove('alerta', 'error');//Clase CSS de error
                document.querySelector('#comic').classList.add('alerta', 'exito');//Clase CSS de correcto
            }
            else{
                document.querySelector('#comic').classList.add('alerta', 'error');//Clase CSS de error
                document.querySelector('#comic').classList.remove('alerta', 'exito');//Clase CSS de correcto

                //Volver a las propiedades originales en 3 seg
                setTimeout(() =>{
                    document.querySelector('#comic').classList.remove('alerta', 'exito');//Clase CSS de error
                    document.querySelector('#comic').classList.add('formulario__campo');//Clase CSS de correcto
                }, 3000)
            }
        break;
        case "editorial":
            if(expresiones.regex1.test(datos.editorial)){
                document.querySelector('#editorial').classList.remove('alerta', 'error');//Clase CSS de error
                document.querySelector('#editorial').classList.add('alerta', 'exito');//Clase CSS de correcto
            }
            else{
                document.querySelector('#editorial').classList.add('alerta', 'error');//Clase CSS de error
                document.querySelector('#editorial').classList.remove('alerta', 'exito');//Clase CSS de correcto

                //Volver a las propiedades originales en 3 seg
                setTimeout(() =>{
                    document.querySelector('#editorial').classList.remove('alerta', 'exito');//Clase CSS de error
                    document.querySelector('#editorial').classList.add('formulario__campo');//Clase CSS de correcto
                }, 3000)
            }
        break;
        case "año":
            if(expresiones.regex4.test(datos.año)){
                document.querySelector('#año').classList.remove('alerta', 'error');//Clase CSS de error
                document.querySelector('#año').classList.add('alerta', 'exito');//Clase CSS de correcto
            }
            else{
                document.querySelector('#año').classList.add('alerta', 'error');//Clase CSS de error
                document.querySelector('#año').classList.remove('alerta', 'exito');//Clase CSS de correcto

                //Volver a las propiedades originales en 3 seg
                setTimeout(() =>{
                    document.querySelector('#año').classList.remove('alerta', 'exito');//Clase CSS de error
                    document.querySelector('#año').classList.add('formulario__campo');//Clase CSS de correcto
                }, 3000)
            }
        break;
    }
};

//Submit (campos vacios)
formulario.addEventListener('submit', function(evento){
    evento.preventDefault();

    //Validacion de formulario
    const {nombre,correo,comic,editorial,año} = datos;
    
    //Campos vacios
    if(nombre === '' || correo === '' || comic === '' || editorial === '' || año === ''){
        mostrarAlerta('llena los campos', 'error');
        //return 
    }
    else{
        mostrarAlerta('campos listos');
    }
});

//Expresiones regulares
inputs.forEach((input) =>{
    input.addEventListener('keyup', validarCampo);
    input.addEventListener('blur', validarCampo);
});

//Funciones
function obtenerId(evento){
    datos[evento.target.id] = evento.target.value;
    //console.log(datos)
}

//Alerta de campos vacios
function mostrarAlerta(mensaje, tipo = null){
    const alerta = document.createElement('P');
    alerta.textContent = mensaje;

    //Clase CSS de la alerta
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
}

