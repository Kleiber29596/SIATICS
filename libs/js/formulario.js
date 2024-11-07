const formulario = document.getElementById('formRegistrarPersona');
const inputs = document.querySelectorAll('#formRegistrarPersona input');
const selects = document.querySelectorAll('#formRegistrarPersona select');
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



const validarFormulario = (e) => {
	switch(e.target.name) {
		case "nombres":
			validarCampo(expresiones.nombre, e.target, 'nombres');
			break;
		case "apellidos":
			validarCampo(expresiones.nombre, e.target, 'apellidos');
			break;
		case "n_documento":
			validarCampo(expresiones.n_documento, e.target, 'n_documento');
			break;
		case "telefono":
			validarCampo(expresiones.telefono, e.target, 'telefono');
			break;
		case "correo":
			validarCampo(expresiones.correo, e.target, 'correo');
			break;
		case "direccion":
			validarCampo(expresiones.direccion, e.target, 'direccion');
			break;
		case "tipo_documento":
			validarCampoSelect(e.target, 'tipo_documento');
			break;
		case "sexo":
			validarCampoSelect(e.target, 'sexo');
			break;

			/* Campos del representante */
		case "nombres_r":
			validarCampo(expresiones.nombre, e.target, 'nombres_r');
			break;
		
		case "apellidos_r":
			validarCampo(expresiones.nombre, e.target, 'apellidos_r');
			break;	
		
		case "tipo_documento_r":
			validarCampoSelect(e.target, 'tipo_documento_r');
			break;	
		
		case "n_documento_r":
			validarCampo(expresiones.n_documento, e.target, 'n_documento_r');
			break;
		
		case "telefono_r":
			validarCampo(expresiones.telefono, e.target, 'telefono_r');
			break;
		case "correo_r":
			validarCampo(expresiones.correo, e.target, 'correo_r');
			break;
		case "direccion_r":
			validarCampo(expresiones.direccion, e.target, 'direccion_r');
			break;

		case "parentesco":
			validarCampoSelect(e.target, 'parentesco');
			break;	
		
	}
}

const validarCampo = (expresion, input, campo) => {
	if (expresion.test(input.value)) {
		document.getElementById(`grupo_${campo}`).classList.remove('formulario__grupo-incorrecto');
		document.getElementById(`grupo_${campo}`).classList.add('formulario__grupo-correcto');
		document.querySelector(`#grupo_${campo} i`).classList.add('fa-check-circle');
		document.querySelector(`#grupo_${campo} i`).classList.remove('fa-times-circle');
		document.querySelector(`#grupo_${campo} .formulario__input-error`).classList.remove('formulario__input-error-activo');
	} else {
		document.getElementById(`grupo_${campo}`).classList.add('formulario__grupo-incorrecto');
		document.getElementById(`grupo_${campo}`).classList.remove('formulario__grupo-correcto');
		document.querySelector(`#grupo_${campo} i`).classList.add('fa-times-circle');
		document.querySelector(`#grupo_${campo} i`).classList.remove('fa-check-circle');
		document.querySelector(`#grupo_${campo} .formulario__input-error`).classList.add('formulario__input-error-activo');
	}
}

const validarCampoSelect = (select, campo) => {
	if (select.value !== "") {
		document.getElementById(`grupo_${campo}`).classList.remove('formulario__grupo-incorrecto');
		document.getElementById(`grupo_${campo}`).classList.add('formulario__grupo-correcto');
		document.querySelector(`#grupo_${campo} i`).classList.add('fa-check-circle');
		document.querySelector(`#grupo_${campo} i`).classList.remove('fa-times-circle');
		document.querySelector(`#grupo_${campo} .formulario__input-error`).classList.remove('formulario__input-error-activo');
	} else {
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

selects.forEach((select) => {
	select.addEventListener('change', validarFormulario);
});


const validarFechaNacimiento = (e) => {
    const input = e.target;
    const fechaSeleccionada = new Date(input.value);
    const fechaActual = new Date();

    if (fechaSeleccionada > fechaActual) {
        document.getElementById(`grupo_fecha_nac`).classList.add('formulario__grupo-incorrecto');
        document.getElementById(`grupo_fecha_nac`).classList.remove('formulario__grupo-correcto');
        document.querySelector(`#grupo_fecha_nac i`).classList.add('fa-times-circle');
        document.querySelector(`#grupo_fecha_nac i`).classList.remove('fa-check-circle');
        document.querySelector(`#grupo_fecha_nac .formulario__input-error`).classList.add('formulario__input-error-activo');
    } else {
        document.getElementById(`grupo_fecha_nac`).classList.add('formulario__grupo-correcto');
        document.getElementById(`grupo_fecha_nac`).classList.remove('formulario__grupo-incorrecto');
        document.querySelector(`#grupo_fecha_nac i`).classList.add('fa-check-circle');
        document.querySelector(`#grupo_fecha_nac i`).classList.remove('fa-times-circle');
        document.querySelector(`#grupo_fecha_nac .formulario__input-error`).classList.remove('formulario__input-error-activo');
    }
};

let fecha_nac_nac;
if((fecha_nac_nac = document.getElementById('fecha_nac')))
{
	fecha_nac_nac.addEventListener('change', validarFechaNacimiento);
}



const validarFormularioConsulta	 = (e) => {
	switch(e.target.name){
		case "n_documento_persona":
			validarCampo(expresiones.n_documento, e.target,'n_documento', 'consultar_persona');
		break;
	}
}


inputs_consulta.forEach((input) =>{
	input.addEventListener('keyup', validarFormularioConsulta);
	input.addEventListener('blur', validarFormularioConsulta);

});