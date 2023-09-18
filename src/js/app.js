let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;


const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
})


function iniciarApp(){
    mostrarSeccion(); // Muestra y oculta las secciones.
    tabs(); // Cambia la seccion cuando se presionen los tabs.
    botonesPaginador(); // Agrega o elimina los botones del paginador.
    paginaAnterior(); // Ir a la seccion previa con los botones del paginador.
    paginaSiguiente(); // Ir a la seccion siguiente con los botones del paginador.
    consultarAPI(); // Consultar API en el Backend.
    idCliente(); // Añade el ID del cliente al objeto de cita.
    nombreCliente();  // Añade el nombre del cliente al objeto de cita.
    fechaCliente(); // Añade la fecha de la cita al objeto de cita.
    horaCliente(); // Añade la hora de la cita al objeto de cita.
    mostrarResumen(); // Mostrar el resumen de la cita.
}


function tabs(){
    // Agrega y cambia la variable de "paso" segun el tab seleccionado.
    const botones = document.querySelectorAll('.tabs button')

    botones.forEach(boton => {
        boton.addEventListener('click', function(e){
            e.preventDefault();

            paso = parseInt(e.target.dataset.paso);

            mostrarSeccion();
            botonesPaginador();
        }) 
    })
}


function mostrarSeccion(){
    // Ocultar la seccion que tenga la clase de "mostrar".
    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior){
        seccionAnterior.classList.remove('mostrar');
    }

    // Seleccionar la seccion de "paso".
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    // Remover la clase de "actual" una vez ha cambiado a otro tab.
    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }

    // Resaltar el tab actual.
    const tab = document.querySelector(`[data-paso="${paso}"]`); // NG - 1.
    tab.classList.add('actual');
}


function botonesPaginador(){
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if(paso === 1){
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    } else if(paso === 2){
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    } else if(paso === 3){
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();
    }

    mostrarSeccion();
}


function paginaAnterior(){
    const anterior = document.querySelector('#anterior');
    anterior.addEventListener('click', function(){
        if(paso <= pasoInicial) return;
        paso--;
        botonesPaginador();
    })
}


function paginaSiguiente(){
    const siguiente = document.querySelector('#siguiente');
    siguiente.addEventListener('click', function(){
        if(paso >= pasoFinal) return;
        paso++;
        botonesPaginador();
    })
}


async function consultarAPI(){
    try {
        const url = '/api/servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();

        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }
}


function mostrarServicios(servicios){
    servicios.forEach(servicioDB => {
        const {id, servicio, precio} = servicioDB; // Objeto con todos los datos del servicio.

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = servicio; // Nombre del servicio.

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`; // Precio del servicio.

        const divServicio = document.createElement('DIV');
        divServicio.classList.add('div-servicio');
        divServicio.dataset.idServicio = id;
        divServicio.onclick = function() {
            seleccionarServicio(servicioDB);
        };

        divServicio.appendChild(nombreServicio);
        divServicio.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(divServicio);
    });
}


function seleccionarServicio(servicio){ // NG - 5.
    const {id} = servicio;
    const {servicios} = cita;

    // Identificar el elemento que recibira el click.
    const servicioSeleccionado = document.querySelector(`[data-id-servicio="${id}"]`);

    // Comprobar si un servicio ya ha sido agregado.
    if(servicios.some(agregado => agregado.id === id)){ // NG - 2. ---> El 2do id pertenece al id del serivicio que recibe la funcion.
        // Eliminarlo.
        cita.servicios = servicios.filter(agregado => agregado.id != id); // NG - 3.
        servicioSeleccionado.classList.remove('seleccionado');
    } else{
        // Agregarlo.
        cita.servicios = [...servicios, servicio]; // NG - 4.
        servicioSeleccionado.classList.add('seleccionado');
    }

    // console.log(cita);
}


function idCliente(){
    cita.id = document.querySelector('#id').value;
}


function nombreCliente(){
    cita.nombre = document.querySelector('#nombre').value; // NG - 6 y 7.

}


function fechaCliente(){
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function(e){

        const dia = new Date(e.target.value).getUTCDay(); // NG - 8.
        
        if([6, 0].includes(dia)){ // NG - 9 y 10.
            e.target.value = '';
            mostrarAlerta('Sabados y Domingos no trabajamos', 'error', '.formulario');
        } else{
            cita.fecha = e.target.value;
        }
    });
}


function horaCliente(){
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function(e){
        
        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0];

        if(hora <= 8 || hora > 18){
            e.target.value = '';
            mostrarAlerta('Trabajamos de 8am hasta las 7pm', 'error', '.formulario');
        } else{
            cita.hora = e.target.value;
            // console.log(cita);
        }
    })
}


function mostrarAlerta(mensaje, tipo, elemento, desaparece = true){
    // Prevenir que se generen mas de una alerta.
    const alertaPrevia = document.querySelector('.alertas');
    if(alertaPrevia){
        alertaPrevia.remove();
    }

    // scripting para crear la alerta.
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alertas');
    alerta.classList.add(tipo);

    // inyectar la alerta en el formulario.
    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if(desaparece){
        // Eliminar la alerta.
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }

}


function mostrarResumen(){
    const resumen = document.querySelector('.contenido-resumen');

    // Limpiar el contenido del resumen.
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }

    if(Object.values(cita).includes('') || cita.servicios.length === 0){ // NG - 11.
        mostrarAlerta('Falta seleccionar un servicio o establecer la fecha y hora de la cita', 'error', '.contenido-resumen', false);
        
        return // Si todo esta bien, el return detiene la ejecucion del codigo.
    }

    // Formatear el DIV de resumen.
    const {nombre, fecha, hora, servicios} = cita;

    // Heading para los servicios en el Resumen.
    const headingServicios = document.createElement('H3');
    headingServicios.classList.add('heading-resumen');
    headingServicios.textContent = 'Tus servicios seleccionados';
    resumen.appendChild(headingServicios);

    // Iterando y mostrando los servicios.
    servicios.forEach(servicioDB =>{
        const {id, precio, servicio} = servicioDB;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = servicio;

        const precioResumen = document.createElement('P');
        precioResumen.innerHTML = `<span>Precio:</span> $${precio}`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioResumen);

        resumen.appendChild(contenedorServicio);
    })

    // Heading para los datos del usuario en el Resumen.
    const headingcita = document.createElement('H3');
    headingcita.classList.add('heading-resumen');
    headingcita.textContent = 'Información de la cita';
    resumen.appendChild(headingcita);

    // Formatear la fecha a español.
    fechaObj = new Date(fecha);
    const day = fechaObj.getDate() + 2; // NG - 12 y 13.
    const month = fechaObj.getMonth(); 
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year, month, day));

    const fechaOpciones = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'} // NG - 15.
    const fechaFormateada = fechaUTC.toLocaleDateString('es-VE', fechaOpciones); // NG - 14.

    const nombreCita = document.createElement('P');
    nombreCita.innerHTML = `<span>Nombre:</span> ${nombre}`;

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora} Horas`;

    // Boton para crear una cita.
    botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita;

    resumen.appendChild(nombreCita);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);
    resumen.appendChild(botonReservar);
}


async function reservarCita(){
    const {id, fecha, hora, servicios} = cita;

    const idServicios = servicios.map(servicio => servicio.id)
    // console.log(idServicios);

    const datos = new FormData(); // NG - 16.
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuariosID', id);
    datos.append('servicios', idServicios);

    // console.log([...datos]);

    try {
        // Peticion hacia la API.
        const url = '/api/citas';

        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();

        console.log(resultado.resultado);

        if(resultado.resultado){
            Swal.fire({
                icon: 'success',
                title: 'Excelente',
                text: 'Cita agendada correctamente',
            }).then(() => {
                setTimeout(() => {
                    window.location.reload();    
                }, 1000);
            })
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Ah ocurrido un error inesperado y tu cita no pudo ser agendada',
          }).then(() => {
            setTimeout(() => {
                window.location.reload();    
            }, 1000);
        })
    }

    
    
    // console.log([...datos]); // NG - 17.
}


/** NOTAS GENERALES
 * 
 * 1.- [] los corchetes se emplean para llamar a selectores de atributo como el que creamos en el archivo de citas/index.php mas concretamente el data-paso="".
 * 
 * 2.- El método some() comprueba si al menos un elemento del array cumple con la condición implementada por la función proporcionada.
 * 
 * 3.- El método filter() crea un nuevo array con todos los elementos que cumplan la condición implementada por la función dada.
 * 
 * 4.- Un spread Operator u Operador de Propagacion (...) permite expandir un objeto iterable en una serie de objetos individuales. Para fines de la funcion,
 * se extrae el array de servicios y con el spread operator se crea una copia en memoria del mismo mientras se le añade el nuevo servicio
 * (cita.servicios = [...servicios, servicio]).
 * 
 * 5.- Si resulta confuso entender el funcionamiento de la funcion seleccionarServicio(), ver el video 504 del curso Desarrollo Web Completo en Udemy.
 * 
 * 6.- .value es la forma de llamar al value del HTML. Es decir, llama a ese atributo y mientras para HTML es un atributo, pars JS funciona como objeto. En otras
 * palabras, el .value en el querySelector actua como un metodo que referencia es atributo de HTML.
 * 
 * 7.- No estoy definiendo una nueva variable o constante. Por el contrario, estoy asignando un valor al objeto de cita definido globalmente en la parte superior.
 * 
 * 8.- El método getUTCDay() del objeto de Date, retorna el día de la semana para dicha fecha según la hora universal, donde 0 representa el domingo y 6 el sabado.
 * 
 * 9.- El método includes() determina si una matriz incluye un determinado elemento, devolviendo true o false según corresponda.
 * 
 * 10.- Otra forma de hacer la validacion es:
 *     if(dia === 0 || dia === 6){
        console.log('No se agendan citas estos dias')
    } else{
        console.log('Agendado');
    }
 * 
 * 11.- if(Object.values(cita).includes('') || cita.servicios.length === 0) va a comprobar que haya parametros dentro del objeto de cita, o que la extension del
 * arreglo de citas no este vacio. Si esta vacio, quiere decir que el usuario no ha seleccionado ningun servicio.
 * 
 * 12.- Al emplear la clase de Date, se presentan algunas consideraciones en su implementacion. Una de estas que al llamar al metodo getDate() para obtener la fecha
 * deseada, esta siempre la devolvera con un dia de retraso y por cada vez que sea llamada, se adicionara un dia de retraso al resultado. Es por ello que hay un +2
 * luego de llamar al metodo. Como ha sido llamada dos veces, el +2 emparejara el resultado con el que deberia corresponder.
 * 
 * 13.- getDate() Devuelve el dia en numero del mes.
 * - getDay() Devuelve el dia de la semana del 0 al 6. Al igual que los arreglos, la enumeracion empieza desde el cero. Es decir, si la semana empieza el dia domingo,
 * en vez de ser 1, sera 0.
 * - getMonth() Devuelve el mes del del año.
 * - getFullYear() Devuelve el año.
 * 
 * 14.- El método toLocaleDateString() devuelve una cadena con una representación sensible al idioma de la parte de la fecha especificada en la zona horaria del
 * agente de usuario.
 * 
 * 15.- Los argumentos locales (es-VE') y options (fechaOpciones = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'}) permiten a las aplicaciones
 * especificar el idioma cuyas convenciones de formato deben utilizarse y permiten personalizar el comportamiento de la función. En las implementaciones más
 * antiguas, que ignoran los argumentos locales y options, la configuración regional utilizada y la forma de la cadena devuelta dependen totalmente de la
 * implementación.
 * 
 * 16.- Los objetos FormData le permiten compilar un conjunto de pares clave/valor para enviar mediante XMLHttpRequest o jQuery (en caso de que sea codigo anterior),
 * o fetch() y axios() que son las tecnologias empleadas actualmente. Están destinados principalmente para el envío de los datos del formulario, pero se pueden
 * utilizar de forma independiente con el fin de transmitir los datos tecleados. Los datos transmitidos estarán en el mismo formato que usa el método submit() del
 * formulario para enviar los datos si el tipo de codificación del formulario se establece en "multipart/form-data".
 * 
 * 17.- Los FormData no se pueden ver mediante un console.log() de manera normal. Es decir, si defino en FormData en una variable y muestro la variable en la consola,
 * esta no va a mostrar nada. Para ello, se puede introducir la variable dentro de un array y se le adiciona un Spread Operator. Esto formateara el array creando una
 * copia que es la que luego se mostrara en pantalla. De esta forma podemos saber que valores estan siendo llamados por el FormData.
 * 
 */