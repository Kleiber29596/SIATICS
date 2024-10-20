const formulario = document.getElementById('formRegistrarPersona');
const inputs = document.querySelectorAll('#formRegistrarPersona input');
const inputs_consulta = document.querySelectorAll('#formRegistrarConsultas input');



const expresiones = {
	usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
	nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
	password: /^.{4,12}$/, // 4 a 12 digitos.
	correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
	telefono: /^\d{7,14}$/, // 7 a 14 numeros.
	n_documento: /^\d{7,8}$/, 
	direccion:/^[a-zA-Z0-9\s.,#-]+$/
}

const validarFormulario	 = (e) => {
	switch(e.target.name){
		case "nombres":
			validarCampo(expresiones.nombre, e.target,'nombres');
		break;
		case "apellidos":
			validarCampo(expresiones.nombre, e.target,'apellidos');
		break;
		case "n_documento":
			validarCampo(expresiones.n_documento, e.target,'n_documento');
		break;
		case "telefono":
			validarCampo(expresiones.telefono, e.target,'telefono');
		break;
		case "correo":
			validarCampo(expresiones.correo, e.target,'correo');
		break;
		case "direccion":
			validarCampo(expresiones.direccion, e.target,'direccion');
		break;
	}
}

const validarCampo = (expresion, input, campo) => {

	if(expresion.test(input.value)) {
		document.getElementById(`grupo_${campo}`).classList.remove('formulario__grupo-incorrecto');
		document.getElementById(`grupo_${campo}`).classList.add('formulario__grupo-correcto');
		document.querySelector(`#grupo_${campo} i`).classList.add('fa-check-circle');
		document.querySelector(`#grupo_${campo} i`).classList.remove('fa-times-circle');
		document.querySelector(`#grupo_${campo} .formulario__input-error`).classList.remove('formulario__input-error-activo');
	}else{
		document.getElementById(`grupo_${campo}`).classList.add('formulario__grupo-incorrecto');
		document.getElementById(`grupo_${campo}`).classList.remove('formulario__grupo-correcto');
		document.querySelector(`#grupo_${campo} i`).classList.add('fa-times-circle');
		document.querySelector(`#grupo_${campo} i`).classList.remove('fa-check-circle');
		document.querySelector(`#grupo_${campo} .formulario__input-error`).classList.add('formulario__input-error-activo');
	}
}
 
inputs.forEach((input) =>{
	input.addEventListener('keyup', validarFormulario);
	input.addEventListener('blur', validarFormulario);

});

inputs_consulta.forEach((input) =>{
	input.addEventListener('keyup', validarFormulario);
	input.addEventListener('blur', validarFormulario);

});