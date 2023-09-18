document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});


function iniciarApp(){
    buscarPorFecha();
};


function buscarPorFecha(){
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function(e){
        const fechaSeleccionada = e.target.value;

        window.location = `?fecha=${fechaSeleccionada}`; // NG - 1.
    })
}



/** NOTAS GENERALES
 * 1.- window.location: Window.location no sólo es una propiedad de sólo lectura, también se le puede asignar un DOMString. Esto significa que puedes trabajar con
 * location como si fuera una cadena de caracteres, de la misma forma que se hizo en el actual ejercicio.
 */