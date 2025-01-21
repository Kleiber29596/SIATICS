$(document).ready(function() {
  // Esto asegura que los elementos fuera del modal también funcionen
  // Esto asegura que los elementos fuera del modal también funcionen
  $('.js-example-basic-multiple').select2();
});

// Re-inicializar Select2 cuando el modal se abre
$('#modalAgregarHistoriaMedica').on('shown.bs.modal', function() {
  $('.js-example-basic-multiple').select2({
      dropdownParent: $('#modalAgregarHistoriaMedica') // Vincular el dropdown al modal
  });
});

// Select multiple medicamentos

$(document).ready(function() {
  // Esto asegura que los elementos fuera del modal también funcionen
  $('.select-multiple_medicamentos').select2();
});


// Re-inicializar Select2 cuando el modal se abre
$('#modalAgregarHistoriaMedica').on('shown.bs.modal', function() {
  $('.select-multiple_medicamentos').select2({
      dropdownParent: $('#modalAgregarHistoriaMedica') // Vincular el dropdown al modal
  });
});

// function mostarModal(name) {
  
//   $("#modalAgregarConsulta").modal("show");


//   // Ejemplo de uso:
//   const elementosConClase = document.getElementsByClassName('modal-backdrop fade show');

//   // Iterar sobre los elementos encontrados:
//   for (let i = 0; i < elementosConClase.length; i++) {
//   console.log(elementosConClase[i]); // Imprime cada elemento
//   elementosConClase[i].style.display = "block"; // Modifica el texto de cada elemento
//   }

//   }

// function cerrarModalConsulta() {
//   $("#modalAgregarConsulta").modal("hide");


//   // Ejemplo de uso:
//   const elementosConClase = document.getElementsByClassName('modal-backdrop fade show');

//   // Iterar sobre los elementos encontrados:
//   for (let i = 0; i < elementosConClase.length; i++) {
//   console.log(elementosConClase[i]); // Imprime cada elemento
//   elementosConClase[i].style.display = "none"; // Modifica el texto de cada elemento
//   }

//   }

function gestionarModal(modalId, accion = 'mostrar') {
  const modal = $(`#${modalId}`);

  if (!modal.length) { 
    console.error(`Modal con ID "${modalId}" no encontrado.`);
    return;
  }

  if (accion === 'mostrar') {
    modal.modal('show');

    const elementosConClase = document.getElementsByClassName('modal-backdrop fade show');


    for (let i = 0; i < elementosConClase.length; i++) {
      console.log(elementosConClase[i]); 
      elementosConClase[i].style.display = "block"; 
    }
  } else if (accion === 'ocultar' || accion === 'cerrar') {
    modal.modal('hide');

    const elementosConClase = document.getElementsByClassName('modal-backdrop fade show');

 
    for (let i = 0; i < elementosConClase.length; i++) {
      console.log(elementosConClase[i]);
      elementosConClase[i].style.display = "none";
    }
  } else {
    console.error(`Acción "${accion}" no válida. Use 'mostrar' u 'ocultar'.`);
  }


}


/* -------------- Citas / Caledario ------------------ */

let calendar;

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('DIVcalendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        headerToolbar: {
            left: 'today',
            //center: 'title',
            right: 'prev,next'
        },
        footerToolbar: {
            //left: 'prev,next today',
            center: 'title',
            //right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: [],
        dateClick: function(info) {
            // Cambiar el color de fondo de la celda seleccionada
            info.dayEl.style.backgroundColor = 'lightblue';

            let id_especialidad_cita = document.getElementById("especialidad").value;
            let id_doctor_cita = document.getElementById("doctor").value;
            const diaLaboral = document.getElementById("diaLaboral").value;

            const dataArray = diaLaboral.split(",").map(item => item.trim());
            const diaMap = {
                'lunes': 1,
                'martes': 2,
                'miercoles': 3,
                'jueves': 4,
                'viernes': 5,
                'sabado': 6,
                'domingo': 0
            };

            const diasLaboralesNumeros = dataArray.map(item => diaMap[item.toLowerCase()] !== undefined ? diaMap[item.toLowerCase()] : null).filter(item => item !== null);
            var nuevaFecha = info.dateStr; // Fecha seleccionada
            var hoy = moment().format('YYYY-MM-DD');
            var f = info.date.getDay(); // Obtener el día de la semana

            if (id_especialidad_cita && id_doctor_cita) {
                if (!diasLaboralesNumeros.includes(f)) {
                    Swal.fire({
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                        title: 'Error',
                        text: 'Este doctor/a no labora en este día.',
                    });
                } else if (nuevaFecha < hoy) {
                    Swal.fire({
                        icon: "warning",
                        confirmButtonColor: "#3085d6",
                        title: 'Cuidado',
                        text: 'No es posible asignar una cita para esta fecha.',
                    });
                } else if (f === 0 || f === 6) {
                    Swal.fire({
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                        title: 'Error',
                        text: 'Estos días no son laborables.',
                    });
                } else {
                    $.ajax({
                        url: "index.php?page=consultarEspeDoct",
                        type: "post",
                        dataType: "json",
                        data: {
                            especialidad: id_especialidad_cita,
                            doctor: id_doctor_cita,
                            nuevaFecha: nuevaFecha,
                        },
                    })
                    .done(function(response) {
                        if (response.data.success) {
                            // Obtener el límite de citas y los días laborales
                            var limiteCita = document.getElementById("limiteCita").value.split(',').map(Number);
                            var diaLaboral = document.getElementById("diaLaboral").value.split(',').map(dia => dia.trim().toLowerCase());

                            // Obtener el día de la fecha seleccionada
                            const fechaSeleccionada = new Date(nuevaFecha);
                            const diaSeleccionado = fechaSeleccionada.toLocaleDateString('es-ES', { weekday: 'long' }).toLowerCase();
                            
                            // Inicializar el conteo de citas para el día seleccionado
                            let totalCitas = 0;

                            // Verificar el conteo de citas para la fecha seleccionada
                            response.data.conteo_FechaCita.forEach(function(conteoCitas) {
                                // Aquí asumimos que conteoCitas.total_citas es el total de citas para la fecha seleccionada
                                totalCitas += conteoCitas.total_citas; // Sumar el total de citas
                            });

                            // Obtener el índice del día seleccionado en el arreglo de días laborales
                            const index = diaLaboral.indexOf(diaSeleccionado);

                            // Verificar si hay disponibilidad solo para el día seleccionado
                            if (index !== -1 && totalCitas < limiteCita[index]) {
                                console.log('Se puede realizar la cita');
                                $('#fecha_cita').val(nuevaFecha);
                                $("#txt-especialidad").val(response.data.nombre_especialidad);
                                $("#txt-doctor").val(response.data.nombre_doctor);
                                $("#modalAgregarCitas").modal('show');
                            } else {
                                // Solo mostrar el mensaje de error si no hay disponibilidad en la fecha seleccionada
                                Swal.fire({
                                    icon: "error",
                                    confirmButtonColor: "#3085d6",
                                    title: 'Lo sentimos',
                                    text: 'Para esta fecha no hay cupo disponible.',
                                });
                            }
                        }
                    })
                    .fail (function(e) {
                        console.log(e);
                    });
                }
            } else {
                Swal.fire({
                    icon: "warning",
                    confirmButtonColor: "#3085d6",
                    title: 'Oops',
                    text: 'Debe seleccionar una especialidad y un doctor.',
                });
            }
        },
        dayCellDidMount: function(info) {
            var diaLaboral = document.getElementById("diaLaboral").value;
            const dataArray = diaLaboral.split(",").map(item => item.trim());
            const diaMap = {
                'lunes': 1,
                'martes': 2,
                'miercoles': 3,
                'jueves': 4,
                'viernes': 5,
                'sabado': 6,
                'domingo': 0
            };

            const diasLaboralesNumeros = dataArray.map(item => diaMap[item.toLowerCase()] !== undefined ? diaMap[item.toLowerCase()] : null).filter(item => item !== null);
            var f = info.date.getDay(); // Obtener el día de la semana del objeto date

            // Cambiar el color de fondo si el día es laboral
            if (diasLaboralesNumeros.includes(f)) {
                info.el.style.backgroundColor = 'yellow'; // Cambiar a un color que desees
            }
        },
        eventClick: function(info) {
          // Mostrar el modal y llenar los datos
          //alert('Se muestran las citas');
          var startDate = info.event.start;
          var formattedDate = moment(startDate).format('YYYY-MM-DD');
          var viewDate = moment(startDate).format('DD-MM-YYYY');
          var doctor = $('#doctor').val();
          var especialidad = $('#especialidad').val();

          /*console.log(formattedDate);
          console.log(doctor);
          console.log(especialidad);*/

          // Limpiar la tabla antes de agregar nuevos datos
          $('#tablaDatos tbody').empty();

          $.ajax({
              url: "index.php?page=BuscarCitasXFechas",
              type: "post",
              dataType: "json",
              data: {
                  doctor: doctor,
                  fechaCita: formattedDate,
                  especialidad: especialidad,
              },
          })
          .done(function (response) {

              if (response.data.success) {
                  // Mostrar información en el modal
                  $('#espe').text(response.data.especialidad.nombre_especialidad);
                  $('#fecha').text(viewDate);
                  $('#dataModalLabel').text('Citas pendientes');
                  let nom_doc = 'Dr(a). ' + response.data.obtenerDoctor.nombre;
                  $('#doct').text(nom_doc);
                  $('#espe_green').show();
                  $('#est').text('Pendientes');
                  $('#ob').hide();
                  $('#espe_red').hide();
                  $('#tablaDatos').empty();
                  // Agregar citas a la tabla

                  let tablaContenido = '<thead>' +
                      '<tr>' +
                          '<th scope="col">ID</th>' +
                          '<th scope="col">Nombre</th>' +
                          '<th scope="col">N° Documento</th>' +
                          '<th scope="col">Observacion</th>' +
                      '</tr>' + 
                  '</thead>' +
                  '<tbody>'; // Iniciar el tbody
                  
                  // Iterar sobre las citas y construir las filas de la tabla
                  response.data.citas.forEach(function(cita) {
                      tablaContenido += 
                          '<tr>' +
                              '<th scope="row">' + cita.num + '</th>' +
                              '<td>' + cita.nombre + '</td>' +
                              '<td>' + cita.cedula + '</td>' +
                              '<td>' + cita.observacion + '</td>' +
                          '</tr>';
                  });

                  tablaContenido += '</tbody>';

                  // Agregar el contenido a la tabla
                  $('#tablaDatos').append(tablaContenido);

                  // Mostrar el modal
                  $('#dataModal').modal('show');
              } else {
                  Swal.fire({
                      icon: "error",
                      confirmButtonColor: "#3085d6",
                      title: response.data.message,
                      text: response.data.info,
                  });
              }
          })
          .fail(function (e) {
              console.error('Error en la solicitud:', e);
              Swal.fire({
                  icon: "error",
                  confirmButtonColor: "#3085d6",
                  title: 'Error',
                  text: 'No se pudo obtener la información. Intente nuevamente.',
              });
          });
        }
    });

    calendar.render();
});

$(document).ready(function() {
    $('#tablaDatos').DataTable({
        lengthChange: false,
        pageLength: 5,
        searching: false,
        paging: true,  
        language: {
            infoEmpty: "No hay entradas para mostrar",
            info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
            zeroRecords: "No se encontraron registros coincidentes",
            infoFiltered: "(filtrado de _MAX_ entradas totales)",
        }
    });
});



//---------------------------------------Cargar eventos al calendario------------------------------------//
function loadEvents(events) {
    // Obtener los valores de los elementos
    var limiteCita = document.getElementById("limiteCita").value; // "15, 12"
    //var limiteCita = '2,2';
    var diaLaboral = document.getElementById("diaLaboral").value; // "Martes, Jueves"

    // Imprimir los valores para depuración
    //console.log("limiteCita:", limiteCita);
    //console.log("diaLaboral:", diaLaboral);

    // Convertir las cadenas separadas por comas en arreglos
    limiteCita = limiteCita.split(',').map(Number); // Convertir a números
    diaLaboral = diaLaboral.split(',').map(dia => dia.trim().toLowerCase()); // Eliminar espacios y convertir a minúsculas

    var citasPorDia = {};

    // Inicializar el conteo de citas por día
    for (var i = 0; i < diaLaboral.length; i++) {
        citasPorDia[diaLaboral[i]] = 0; // Inicializa el conteo en 0
    }

    if (events) {
        // Transformar los eventos para que contengan solo el título
        const transformedEvents = events.map(event => {
            const dia = new Date(event.start).toLocaleDateString('es-ES', { weekday: 'long' }).toLowerCase(); // Obtener el día de la semana y convertir a minúsculas

            const index = diaLaboral.indexOf(dia); // Verificar si el día está en el arreglo de días laborales

            // Verificar si el día está en el arreglo de días laborales
            if (index !== -1) {
                // Verificar si el límite de citas ha sido alcanzado
                const totalCitas = event.conteo; // Total de citas para ese día

                //console.log(`Citas actuales para ${dia}:`, citasPorDia[dia]);
                //console.log(`Total de citas con event.conteo para ${dia}:`, totalCitas);

                if (totalCitas < limiteCita[index]) {
                    citasPorDia[dia] = event.conteo; // Sumar el conteo de citas para ese día
                    var conteo = limiteCita[index] - totalCitas;
                    //console.log(`Citas actualizadas para ${dia}. Total de citas:`, citasPorDia[dia]);
                    //console.log('total de citas ' + totalCitas + ' < ' + limiteCita[index]);
                    return {
                        title: conteo, // Asegúrate de que 'conteo' sea la propiedad correcta
                        start: event.start,   // Asegúrate de que 'start' sea una fecha válida
                        end: event.end,       // Asegúrate de que 'end' sea una fecha válida
                        color: '#41a232',     // Color del evento
                        textColor: '#ffffff'  // Cambia 'with' a un color válido
                    };
                } else {
                    var conteo = limiteCita[index] - totalCitas;
                    // Si el límite ha sido alcanzado, puedes agregar un evento indicando que está lleno
                    //console.log(`Límite alcanzado para ${dia}. No se puede agregar más citas.`);
                    return {
                        title: conteo, // Mensaje de que ya no se pueden agregar citas
                        start: event.start,
                        end: event.end,
                        color: '#f1231a', // Color para indicar que está lleno
                        textColor: '#ffffff'
                    };
                }
            } else {
                console.log("Día no encontrado en diaLaboral:", dia);
            }
        }).filter(event => event !== undefined); // Filtrar eventos indefinidos

        // Primero, eliminamos todos los eventos existentes
        calendar.removeAllEvents(); // Eliminar eventos existentes

        // Luego, agregamos los nuevos eventos
        calendar.addEventSource(transformedEvents); // Agregar nuevos eventos
        calendar.render();
    } else {
            calendar.removeAllEvents(); // Eliminar eventos existentes
            calendar.render();
        }
    }

/* -------------- mostrar asignacion Cita -------------------------- */

$(document).ready(function(){
  $("#formCalendarCita").submit(function(event){   

    event.preventDefault();
    var especialidad = $("#especialidad").val();
    var doctor = $("#doctor").val();
     /*console.log(especialidad);
     console.log(doctor);*/
    $.ajax({
      url: "index.php?page=consultarEspeDoct",
      type: "post",
      dataType: "json",
      data: {
        especialidad: especialidad,
        doctor: doctor,
      },
    })
    .done(function (response) {
       console.log(response);
         if (response.data.success == true) {
            $("#txt-especialidad").val(response.data.nombre_especialidad);
            $("#txt-doctor").val(response.data.nombre_doctor);
            $("#modalAgregarCitas").modal('show');
         }
      })
    .fail(function (e) {
      console.log(e);
    });

  });
});

/* -------------- Citas / Registrar Cita ------------------ */

var agregar_cita;
if ((agregar_cita = document.getElementById("agregar_cita"))) {
  agregar_cita.addEventListener("click", agregarCita, false);

  function agregarCita() {
    var ID = $("#ID").val();
    let fecha_cita = document.getElementById("fecha_cita").value;
    let observacion_cita = document.getElementById("observacion_cita").value;
    let id_especialidad_cita = document.getElementById("especialidad").value;
    let estatus_cita = 1;
    let id_doctor_cita = document.getElementById("doctor").value;

   if (ID) {
      $.ajax({
          url: "index.php?page=registrarCita",
          type: "post",
          dataType: "json",
          data: {
            ID: ID,
            id_doctor_cita: id_doctor_cita,
            fecha_cita: fecha_cita,
            observacion_cita: observacion_cita,
            estatus_cita: estatus_cita,
            id_especialidad_cita: id_especialidad_cita,
          },
        })
          .done(function (response) {
            //console.log(response);
            if (response.data.success == true) {
              document.getElementById("formRegistrarCita").reset();
              document.getElementById("formCalendarCita").reset();

              $("#modalAgregarCitas").val("");
              $("#n_documento_persona").val("");
              $("#modalAgregarCitas").modal("hide");

              Swal.fire({
                icon: "success",
                confirmButtonColor: "#3085d6",
                title: response.data.message,
                text: response.data.info,
              });

              $("#tabla_citas").DataTable().ajax.reload();
              //document.getElementById("formCalendarCita").reset();
            } else if(response.data.success == false) {
              Swal.fire({
                icon: "warning",
                confirmButtonColor: "#3085d6",
                title: response.data.message,
                text: response.data.info,
              });
            }
          })
          .fail(function (e) {
            //console.log(e);
            Swal.fire({
                icon: "error",
                confirmButtonColor: "#3085d6",
                title: 'Error',
                text: e.data.message,
              });
          });
        }else{
          Swal.fire({
            icon: "error",
            confirmButtonColor: "#3085d6",
            title: 'Error',
            text: 'Debe ingresar un numero de cedula.',
          });
        }
  }
}

//---------------------seleccion de doctor segun la especialidad-----------------//
$(document).ready(function () {
  $("#especialidad").on("change", function () {
    $("#especialidad option:selected").each(function () {
      elegido = $(this).val();
      $.ajax({
        url: "index.php?page=llenarSelectDoctor",
        type: "post",
        dataType: "json",
        data: {
          elegido: elegido,
        },
      })
      .done(function (response) {
        console.log(response);
        if (response.data.success == true) {
          //Limpiar select de municipios
          var estado_municipio = (document.getElementById(
            "doctor"
          ).innerHTML = '<option value="">Seleccione</option>');

          for (es = 0; es < response.data.data.length; es++) {
            //Crea el elemento <option> dentro del select municipio
            var itemOption = document.createElement("option");

            //Contenido de los <option> del select municipios
            var doctor = document.createTextNode(
              response.data.data[es].nombres +
                " " + " C.I -" +
                response.data.data[es].n_documento
            );
            var id_doctor = document.createTextNode(
              response.data.data[es].id_doctor
            );

            //Crear atributo value para los elemento option
            var attValue = document.createAttribute("value");
            attValue.value = response.data.data[es].id_doctor;
            itemOption.setAttributeNode(attValue);

            //Añadir contenido a los <option> creados
            itemOption.appendChild(doctor);

            document.getElementById("doctor").appendChild(itemOption);
          }           
        }

      })
      .fail(function () {
        console.log("error");
      });
    });
  });
});



$(document).ready(function () {
  $("#doctor").on("change", function () {
    $("#doctor option:selected").each(function () {
      elegido = $(this).val();
      $.ajax({
        url: "index.php?page=llenarSelectHorarioDoctor",
        type: "post",
        dataType: "json",
        data: {
          id_doctor: elegido,
        },
      })
      .done(function (response) {
        //console.log('horario: ', response);

       if (Array.isArray(response.data.events)) {
            let diasLaborales = [];
            let limiteCita = [];

            // Supongamos que quieres mostrar el título del primer evento
            if (response.data.events.length > 0) { // Verifica que el arreglo no esté vacío
                response.data.events.forEach(event => {
                    //console.log(event.title+ ' ' +event.start+ ' ' +event.end+ ' ' +event.color+ ' ' +event.textColor ); // Muestra el título de cada evento
                    if (Array.isArray(event.dia)) {
                        // Acumula los días laborales en el arreglo
                        diasLaborales = diasLaborales.concat(event.dia);
                        limiteCita = limiteCita.concat(event.diaDiff);
                    } else {
                        // Si event.dia no es un arreglo, agrega el valor directamente
                        diasLaborales.push(event.dia);
                        limiteCita.push(event.diaDiff);
                    }
                    document.getElementById("diaLaboral").value = diasLaborales.join(", ");
                    document.getElementById("limiteCita").value = limiteCita.join(", ");
                    //console.log('dias laborales por dentro: ', diasLaborales);
                });
                //console.log('dias laborales por fuera: ', response.data.events);
                loadEvents(response.data.citas);
            } else {
                console.log("El arreglo de eventos está vacío.");
            }
        } else {
            console.error("response.data.events no es un array:", response.data.events);
        }
      })
      .fail(function (e) {
        console.log(e);
      });
    });
  });
});


let contador = 0;

function mayus(e) {
  e.value = e.value.toUpperCase();
}
function pmayus(e) {
    // Obtener el valor actual del campo
    let valor = e.value;

    // Eliminar espacios
    valor = valor.replace(/\s+/g, '');

    // Transformar la primera letra en mayúscula y concatenar el resto de la cadena
    e.value = valor.charAt(0).toUpperCase() + valor.slice(1);
}

// Función para obtener los datos de todas las filas

function obtenerDatosTabla(tabla) {
  const datos = []; // Inicializamos un array vacío para almacenar los datos

  const filas = tabla.querySelectorAll('tr');

  // Iterar sobre cada fila (excepto la primera, que contiene los encabezados)
  for (let i = 1; i < filas.length; i++) {
    const fila = filas[i];
    const celdas = fila.querySelectorAll('td');

    // Crear un nuevo array para almacenar los datos de cada fila
    const filaDatos = [];

    // Iterar sobre cada celda de la fila y agregar el dato al array de la fila
    for (let j = 0; j < celdas.length; j++) {
      const celda = celdas[j];
      const dato = celda.textContent;
      filaDatos.push(dato);
    }

    // Agregar el array de datos de la fila al array principal
    datos.push(filaDatos);
  }


  return datos; // Retornamos el array con todos los datos
}

/* Loader */
// $(document).ready(function () {
//   setTimeout(() => {
//     document
//       .getElementById("cont-loader")
//       .setAttribute("style", "display:none;");
//   }, "1000");
// });

/* -------------- Modulo Usuario ------------------ */

  
/*----------------- Listar Usuarios -------------*/
$(document).ready(function () {
  $("#tablaUsuario").DataTable({
    order: [[0, "DESC"]],
    procesing: true,
    serverSide: true,
    ajax: "index.php?page=listarUsuarios",
    pageLength: 4,
    createdRow: function (row, data, dataIndex) {
      if (data[9] == 0) {
        $(row).addClass("table-danger");
      } else {
        //$(row).addClass('table-success');
      }
    },
    columnDefs: [
      {
        orderable: false,
        targets: 6,
        render: function (data, type, row, meta) {
          if (row[7] == 1) {
            let botones =
              `
                    <button type="button" class="btn btn-primary btn-sm" onclick="verUsuario(` +
              row[6] +
              `)"><i class="bi bi-eye-fill"></i></button>&nbsp;
    
                   <button type="button" class="btn btn-warning btn-sm"  onclick="listarActualizacionUsuario(` +
              row[6] +
              `)"><i class="fas fa-edit"></i></button>&nbsp;
    
                   <button type="button" class="btn btn-success btn-sm" title="Inactivar Usuario" onclick="inactivarUsuario(` +
              row[6] +
              `)"><i class="bi bi-toggle-off fs-6"></i></button>  `;
            return botones;
          } else {
            let botones =
              `
                <button type="button" class="btn btn-primary btn-sm" onclick="verUsuario(` +
              row[6] +
              `)"><i class="bi bi-eye-fill"></i></button>&nbsp;

               <button type="button" class="btn btn-warning btn-sm"  onclick="listarActualizacionUsuario(` +
              row[6] +
              `)"><i class="fas fa-edit"></i></button>&nbsp;

               <button type="button" class="btn btn-danger btn-sm" title="Activar usuario" onclick="inactivarUsuario(` +
              row[6] +
              `)"><i class="bi bi-toggle-on fs-6"></i></button>  `;
            return botones;
          }
        },
      },
    ],
    dom: "Bfrtip",
    language: {
      decimal: "",
      emptyTable: "No hay información",
      info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
      infoFiltered: "(Filtrado de _MAX_ total entradas)",
      infoPostFix: "",
      thousands: ",",
      lengthMenu: "Mostrar _MENU_ Entradas",
      loadingRecords: "Cargando...",
      processing: "Procesando...",
      search: "Buscar:",
      zeroRecords: "Sin resultados encontrados",
      paginate: {
        first: "Primero",
        last: "Ultimo",
        next: "Siguiente",
        previous: "Anterior",
      },
    },
  });
});


const agregarHorarioButton = document.getElementById("agregar_horario");
//const eliminar_horario = document.querySelector(`eliminar_horario`);
const diasAgregados = [];
const camposContainer = document.getElementById("camposContainer");

if (agregarHorarioButton) {
  agregarHorarioButton.addEventListener("click", consultarHorario, false);
  
  function consultarHorario(){
    let dia = document.getElementById("dia").value;
    let H_entrada = document.getElementById("H_entrada").value;
    let H_salida = document.getElementById("H_salida").value;

    if(dia == "" || H_entrada == "" || H_salida == ""){
        Swal.fire({
            icon: 'error',
            title: 'Atención',
            confirmButtonColor: '#0d6efd',
            text: 'Debe llenar todos los campos'
        });
        return;
    } else {
      if (diasAgregados.includes(dia)) {
        console.log("Horarios actuales:", diasAgregados.includes(dia));
        console.log("Horarios actuales:", diasAgregados);
        console.log("Horarios actuales:", dia);
        alert("El día seleccionado ya existe. Por favor, elige otro día.");
      } else {
        diasAgregados.push(dia);
        const nuevoHorario = document.createElement("div");
        nuevoHorario.classList.add("horario");
        nuevoHorario.innerHTML = `<div class="row mt-2" id="camposNew">
          <div class="col-md-4">
              <label class="form-group" for="dia">Día de la semana</label>
              <input type="text" class="form-control" name="campo1" value="${dia}" disabled>
          </div>
          <div class="col-md-3">
              <label class="form-group" for="H_entrada">Hora de entrada</label>
              <input type="time" class="form-control" name="campo2" value="${H_entrada}" disabled>
          </div>
          <div class="col-md-3">
              <label class="form-group" for="H_salida">Hora de Salida</label>
              <input type="time" class="form-control" name="campo3" value="${H_salida}" disabled>
          </div>
          <div class="col-md-1" style="display: flex; justify-content: flex-end; align-items: flex-end;">
              <div class="form-group">
                  <button type="button" class="btn btn-danger btn-circle eliminar_horario" name="eliminar_horario" id="eliminar_horario" title="Eliminar este horario">
                      <i class="fas fa-minus"></i>
                  </button>
              </div>
          </div>
        </div>`;
        
        // Agregar el nuevo horario al contenedor
        camposContainer.appendChild(nuevoHorario);

        console.log("Día agregado:", dia);
        console.log("Horarios actuales:", diasAgregados);
        
        // Limpiar campos
        document.getElementById("dia").value = "";
        document.getElementById("H_entrada").value = "";
        document.getElementById("H_salida").value = "";
      }
    }    
  }
}

if (camposContainer) {
  camposContainer.addEventListener("click", function(event) {
      // Verificar si el elemento clicado es un botón de eliminar
      if (event.target.closest(".btn-danger")) {
          // Eliminar el horario correspondiente
          const horarioDiv = event.target.closest(".row"); // Encuentra el contenedor del horario
          const selectDia = document.querySelector('input[name="campo1[]"]');
          const valorDia = selectDia.value;
          if (horarioDiv) {
              horarioDiv.remove(); // Elimina el contenedor del horario
              const index = diasAgregados.indexOf(dia);
              if (index > -1) {
                  diasAgregados.splice(index, 1);
              }
              console.log(valorDia);
              alert("Horario eliminado.");
          }
      }
  });
}

function validarFechaNacimiento() {//Codigo de jesus NO TOCAR POR FAVOR
  const fechaNacimiento = document.getElementById('fechaNacimiento').value; // Suponiendo que el input tiene el id "fechaNacimiento"
  const hoy = new Date();
  const fechaNacimientoDate = new Date(fechaNacimiento);

  // Validar si la fecha es una fecha válida
  if (isNaN(fechaNacimientoDate)) {
    alert('Por favor, ingresa una fecha válida.');
    document.getElementById('fechaNacimiento').value = '';
    return;
  }

  // Validar si la fecha es en el futuro
  if (fechaNacimientoDate > hoy) {
    alert('La fecha de nacimiento no puede ser en el futuro.');
    document.getElementById('fechaNacimiento').value = '';
  }

  // Calcular la edad
  const edad = hoy.getFullYear() - fechaNacimientoDate.getFullYear();
  const mes = hoy.getMonth() - fechaNacimientoDate.getMonth();
  if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimientoDate.getDate()))   
 {
    edad--;
  }

  // Validar si la edad es mayor o igual a 18
  if (edad < 18) {
    alert('Debes ser mayor de edad.');
    document.getElementById('fechaNacimiento').value = '';
  }
}


/* -------------- Agregar Usuario ------------------ */

if (document.getElementById("agregar_usuario")) {
    const agregar_usuario = document.getElementById("agregar_usuario");
    
    agregar_usuario.addEventListener("click", agregarusuario, false);
    
    function agregarusuario(e) {
        e.preventDefault();

        //-------------------- datos de persona--------------//
        let p_nombre = document.getElementById("p_nombre").value;
        let s_nombre = document.getElementById("s_nombre").value;
        let p_apellido = document.getElementById("p_apellido").value;
        let s_apellido = document.getElementById("s_apellido").value;
        //let sexo = document.getElementsByName("sexo"); // Obtener el valor
        let fechaNacimiento = document.getElementById("fechaNacimiento").value; // Obtener el valor
        let numTelf = document.getElementById("numTelf").value; // Obtener el valor
        let tipoDoc = document.getElementById("T_doc").value; // Obtener el valor
        let numeroDoc = document.getElementById("cedu").value; // Obtener el valor
        let correo = document.getElementById("correo").value;
        let direccion_c = document.getElementById("direccion_c").value;
        let tipo_persona = document.getElementById("tipo_persona").value;

        //---------------------------- datos horario ---------------------///
        let cap_Dia = document.querySelectorAll('input[name="campo1"]');
        let cap_H_entrada = document.querySelectorAll('input[name="campo2"]');
        let cap_H_salida = document.querySelectorAll('input[name="campo3"]');

        //----------------------------Datos de usuario-----------------//
        let contrasena = document.getElementById("contrasena").value;
        let confirmar_contrasena = document.getElementById("confirmar_contrasena").value;
        let usuario = document.getElementById("usuario").value;
        let rol = document.getElementById("rol").value;
        let especialidad = document.getElementById("especialidad").value;
        let archivo = document.getElementById("subirfoto2").value;
        
        var sexo = document.getElementsByName("sexo");
        
        for (let i = 0; i < sexo.length; i++) {
          if (sexo[i].checked) {
            // Si el radio está seleccionado, obtener su valor
            var sexoSeleccionado = sexo[i].value;
            console.log("El sexo seleccionado es:", sexoSeleccionado);
            break;
          }
        }
       

        let horarios = [];

        cap_Dia.forEach((input, index) => {
            horarios.push({
                dia: input.value,
                hora_entrada: cap_H_entrada[index].value,
                hora_salida: cap_H_salida[index].value
            });
        });

        
        var datosFormUsuario = {
            p_nombre: p_nombre,
            p_apellido: p_apellido,
            s_nombre: s_nombre,
            s_apellido: s_apellido,
            sexo: sexoSeleccionado,
            fechaNacimiento: fechaNacimiento,
            numTelf: numTelf,
            tipoDoc: tipoDoc,
            numeroDoc: numeroDoc,
            correo: correo,
            direccion_c: direccion_c,
            tipo_persona: tipo_persona,

            
            horarios: horarios,

            
            contrasena: contrasena,
            usuario: usuario,
            rol: rol,
            especialidad: especialidad,
            archivo: archivo
        };

        console.log(datosFormUsuario);
        
       if (contrasena != confirmar_contrasena) {
          Swal.fire({
            icon: "error",
            title: "Atención",
            text: "Las contraseñas no coinciden.",
            confirmButtonColor: "#3085d6",
          });
        }else{
          $.ajax({
            url: "index.php?page=registrarUsuario",
            type: "post",
            dataType: "json",
            data: {
                datosFormUsuario: JSON.stringify(datosFormUsuario),
            },
          })
          .done(function (response) {
            console.log(response);
              if (response) {
                 Swal.fire({
                    icon: 'success',
                    title: 'Excelente',
                    text: 'Los datos han sido registrados de manera exitosa.',
                  });
                document.getElementById("formRegistrarUsuario").reset();
                document.getElementById("camposNew").innerHTML = '';
                $("#agregarUsuarioModal").modal("hide");
                $("#tablaUsuario").DataTable().ajax.reload();
                nuevoHorario = []; // Limpiar el arreglo
                horarios = []; // Limpiar el arreglo
              
              };
          })
          .fail(function (error) {
            console.log("El error es este: ", error);
              Swal.fire({
                icon: "error",
                title: "Atención",
                text: "El servidor tuvo problemas al registrar los datos.",
                confirmButtonColor: "#3085d6",
              });
          });
        }
    }
}



confirmar_contrasena = document.getElementById('confirmar_contrasena')

if(confirmar_contrasena) {
  confirmar_contrasena.addEventListener('input', function () {
    const contrasena = document.getElementById('contrasena').value;
    const confirmarContrasena = this.value;
    const messageElement = document.getElementById('check_password_match');

    if (contrasena != confirmarContrasena) {
        messageElement.textContent = "No coinciden las constraseñas";
        messageElement.style.color = "red";
    } else {
        messageElement.textContent = "Las claves coinciden";
        messageElement.style.color = "green";
    }
});
}


  $(document).ready(function () {
    $("#tbl_consultas").DataTable({
      order: [[0, "DESC"]],
      procesing: true,
      serverSide: true,
      ajax: "index.php?page=listarConsultas",
      pageLength: 10,
      columnDefs: [
        {
          orderable: false,
          targets: 5,
          render: function (data, type, row, meta) {
            let botones =
              `
                      <button type="button" class="btn btn-primary btn-sm" onclick="VerDatosPersona(` +
              row[5] +
              `)"><i class="fas fa-eye"></i></button>&nbsp;
      
                     <button type="button" class="btn btn-warning btn-sm"  onclick="listarDatosConsulta(` +
              row[5] +
              `)"><i class="fas fa-edit"></i></button>&nbsp;
  
              <a href="index.php?page=imprimirRecipe&amp;id=`+ row[5]+`" target="_blank" class="btn btn-secondary btn-sm"><i
              class="fas fa-print"></i></a>&nbsp;
       `;
            return botones;
          },
        },
      ],
      dom: "Bfrtip",
      language: {
        decimal: "",
        emptyTable: "No hay información",
        info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
        infoFiltered: "(Filtrado de _MAX_ total entradas)",
        infoPostFix: "",
        thousands: ",",
        lengthMenu: "Mostrar _MENU_ Entradas",
        loadingRecords: "Cargando...",
        processing: "Procesando...",
        search: "Buscar:",
        zeroRecords: "Sin resultados encontrados",
        paginate: {
          first: "Primero",
          last: "Ultimo",
          next: "Siguiente",
          previous: "Anterior",
        },
      },
    });
  });

  /*------ listar Citas ---------*/
$(document).ready(function () {
  $("#tabla_citas").DataTable({
    order: [[0, "DESC"]],
    procesing: true,
    serverSide: true,
    ajax:"index.php?page=listarCitas",
    pageLength: 6,
    createdRow: function (row, data, dataIndex) {
      if (data[5] == 0) {
        //  $(row).addClass('table-success');
       
      } else {
        // $(row).addClass("table-danger");
      }
    },
    columnDefs: [
      {
        orderable: false,
        targets: 4,
        render: function (data, type, row, meta) {
          if (row[4] == 1) {
            let botones =
              `
                    <button type="button" title="Actualizar" class="btn btn-primary btn-sm" onclick="listarVer(` +
              row[5] +
              `)"><i class="fas fa-eye"></i></button>&nbsp;
    
                   <button type="button" title="Ver" class="btn btn-warning btn-sm"  onclick="listarModificacionCita(` +
              row[5] +
              `)"><i class="fas fa-edit"></i></button>&nbsp;

              <button type="button" title="Finalizar" class="btn btn-danger btn-sm"  onclick="finalizarCita(` +
              row[5] +
              `)"><i class="fas fa-power-off"></i></button>&nbsp;

               
                    `;
            return botones;
          } else {
            let botones =
              `
                <button type="button" title="Ver" class="btn btn-primary btn-sm" onclick="listarVer(` +
              row[5] +
              `)"><i class="fas fa-eye"></i></button>&nbsp;

               <button type="button" title="Actualizar" class="btn btn-warning btn-sm"  onclick="listarModificacionCita(` +
              row[5] +
              `)"><i class="fas fa-edit"></i></button>&nbsp;
              
              <button type="button" title="Finalizar" title="Finalizar" class="btn btn-danger btn-sm"  onclick="finalizarCita(` +
              row[5] +
              `)" disabled><i class="fas fa-power-off"></i></button>&nbsp;
              
              `;
            return botones;
          }
        },
      },
    ],
    dom: "Bfrtip",
    language: {
      decimal: "",
      emptyTable: "No hay información",
      info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
      infoFiltered: "(Filtrado de _MAX_ total entradas)",
      infoPostFix: "",
      thousands: ",",
      lengthMenu: "Mostrar _MENU_ Entradas",
      loadingRecords: "Cargando...",
      processing: "Procesando...",
      search: "Buscar:",
      zeroRecords: "Sin resultados encontrados",
      paginate: {
        first: "Primero",
        last: "Ultimo",
        next: "Siguiente",
        previous: "Anterior",
      },
    },
  });
});



/*Listar datos para actualizacion de usuario*/
function listarActualizacionUsuario(id) {
  let id_usuario = id;

  let id_usuario_update = document.getElementById("id_usuario_update").value;
  let n_documento       = document.getElementById("n_documento_u").value;
  let tipo_d            = document.getElementById("tipo_documento_u").value;
  let primer_nombre     = document.getElementById("p_nombre_u").value;
  let segundo_nombre    = document.getElementById("s_nombre_u").value;
  let primer_apellido   = document.getElementById("p_apellido_u").value;
  let segundo_apellido  = document.getElementById("s_apellido_u").value;
  // let estatus           = document.getElementById("estatus_u").value;
  let listar = "listar";

  $.ajax({
    url: "index.php?page=listarDatosUsuario",
    type: "post",
    dataType: "json",
    data: {
      id_usuario: id_usuario,
    },
  })
    .done(function (response) {
      if (response.data.success == true) {
        document.getElementById("id_usuario_update").value = response.data.id;
        document.getElementById("id_persona_u").value = response.data.id_persona;
        document.getElementById("n_documento_u").value       = response.data.documento;
        document.getElementById("tipo_documento_u").value    = response.data.tipo_doc;
        document.getElementById("p_nombre_u").value   = response.data.p_nombre;
        document.getElementById("s_nombre_u").value   = response.data.s_nombre;
        document.getElementById("p_apellido_u").value   = response.data.p_apellido;
        document.getElementById("s_apellido_u").value   = response.data.s_apellido;
        document.getElementById("usuario_u").value = response.data.usuario;
        document.getElementById("telefono_u").value = response.data.telefono;
        document.getElementById("correo_u").value = response.data.correo;
        document.getElementById("direccion_u").value = response.data.direccion;
        // document.getElementById("estatus_u").value = response.data.estatus;
        document.getElementById("rol_u").value = response.data.id_rol;
        // document.getElementById("img_update_preview").setAttribute("src", "foto_usuario/" + response.data.foto);

        $("#modalActualizarUsuarios").modal("show");
      } else {
      }
    })
    .fail(function () {
      console.log("error");
    });
}

$(document).ready(function () {
  $("#check_foto").change(function () {
    if ($(this).is(":checked")) {
      console.log("El checkbox ha sido seleccionado");
      document.getElementById("cont_input_file").removeAttribute("style");
      // Agrega aquí el código que deseas ejecutar cuando el checkbox es seleccionado
    } else {
      //console.log("El checkbox ha sido deseleccionado");
      document
        .getElementById("cont_input_file")
        .setAttribute("style", "display:none;");
      // Agrega aquí el código que deseas ejecutar cuando el checkbox es deseleccionado
    }
  });
});

$("#check_foto").is(":checked");
/* -------------- Modificar Usuario ------------------ */

$("#formActualizarUsuario")
  .unbind("submit")
  .bind("submit", function (e) {
    e.preventDefault();

    let id_usuario_update = document.getElementById("id_usuario_update").value;
    let cedula = document.getElementById("cedula_update").value;
    let nombre = document.getElementById("nombre_update").value;
    let apellido = document.getElementById("apellido_update").value;
    let usuario = document.getElementById("usuario_update").value;
    let contrasena = document.getElementById("contrasena_update").value;
    let correo = document.getElementById("correo_update").value;
    let estatus = document.getElementById("estatus_update").value;
    let rol_update = document.getElementById("rol_update").value;
    let confirmar_contrasena_update = document.getElementById(
      "confirmar_contrasena_update"
    ).value;

    /* comprobar campos vacios */
    if (
      cedula == "" ||
      nombre == "" ||
      apellido == "" ||
      usuario == "" ||
      contrasena == "" ||
      correo == "" ||
      estatus == "" ||
      rol_update == ""
    ) {
      Swal.fire({
        icon: "error",
        title: "Atención",
        text: "Todos los campos son obligatorios",
        confirmButtonColor: "#3085d6",
      });
      return;
    }

    if (contrasena != confirmar_contrasena_update) {
      Swal.fire({
        icon: "error",
        title: "Atención",
        text: "Las constraseñas no coinciden.",
        confirmButtonColor: "#3085d6",
      });
      return;
    }

    $.ajax({
      url: "index.php?page=modificarUsuario",
      type: "POST",
      data: new FormData(this),
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function () {
        //btnSaveLoad();
      },
      success: function (response) {
        var respuesta = JSON.parse(response);

        if (respuesta.data.success == true) {
          console.log(respuesta.data);
          Swal.fire({
            icon: "success",
            confirmButtonColor: "#3085d6",
            title: respuesta.data.message,
            text: respuesta.data.info,
          });

          document.getElementById("formActualizarUsuario").reset();

          $("#modalActualizarUsuarios").modal("hide");

          $("#tablaUsuario").DataTable().ajax.reload();
        } else {
          Swal.fire({
            icon: "error",
            confirmButtonColor: "#3085d6",
            title: respuesta.data.message,
            text: respuesta.data.info,
          });
        }
      },
    });
  });

/* -------------- Activar e Inactivar Usuario ------------------ */
function inactivarUsuario(id) {
  var id_usuario = id;

  Swal.fire({
    title: "¿Está seguro de modificar el estado del usuario?",
    text: "El usuario quedara inactivo, pero su registro quedara guardado en la traza.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "index.php?page=inactivarUsuario",
        type: "post",
        dataType: "json",
        data: {
          id_usuario: id_usuario,
        },
      })
        .done(function (response) {
          if (response.data.success == true) {
            $("#tablaUsuario").DataTable().ajax.reload();
          } else {
            Swal.fire({
              icon: "error",
              title: response.data.message,
              confirmButtonColor: "#0d6efd",
              text: response.data.info,
            });
          }
        })
        .fail(function () {
          console.log("error");
        });
    }
  });
}

/*-----------------Listar Roles-------------*/
$(document).ready(function () {
  $("#tablaRoles").DataTable({
    order: [[0, "DESC"]],
    procesing: true,
    serverSide: true,
    ajax: "index.php?page=listarRoles",
    pageLength: 4,
    createdRow: function (row, data, dataIndex) {
      if (data[4] == 0) {
        $(row).addClass("table-danger");
      } else {
        //$(row).addClass('table-success');
      }
    },
    columnDefs: [
      {
        orderable: false,
        targets: 3,
        render: function (data, type, row, meta) {
          if (row[4] == 1) {
            let botones =
              `
                      <button type="button" class="btn btn-primary btn-sm" onclick="verRoles(` +
              row[0] +
              `)"><i class="fas fa-eye"></i></button>&nbsp;
     
                     <button type="button" class="btn btn-warning btn-sm"  onclick="listarActualizacionRoles(` +
              row[0] +
              `)"><i class="fas fa-edit"></i></button>&nbsp;
     
                     <button type="button" class="btn btn-danger btn-sm" onclick="inactivarRoles(` +
              row[0] +
              `)"><i class="fas fa-trash"></i></button>  `;
            return botones;
          } else {
            let botones =
              `
                  <button type="button" class="btn btn-primary btn-sm" onclick="VerRoles(` +
              row[0] +
              `)"><i class="fas fa-eye"></i></button>&nbsp;
 
                 <button type="button" class="btn btn-warning btn-sm"  onclick="listarActualizacionRoles(` +
              row[0] +
              `)"><i class="fas fa-edit"></i></button>&nbsp;
 
                 <button type="button" class="btn btn-success btn-sm" onclick="inactivarRoles(` +
              row[0] +
              `)"><i class="fas fa-fas fa-retweet"></i></button>  `;
            return botones;
          }
        },
      },
    ],
    dom: "Bfrtip",
    language: {
      decimal: "",
      emptyTable: "No hay información",
      info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
      infoFiltered: "(Filtrado de _MAX_ total entradas)",
      infoPostFix: "",
      thousands: ",",
      lengthMenu: "Mostrar _MENU_ Entradas",
      loadingRecords: "Cargando...",
      processing: "Procesando...",
      search: "Buscar:",
      zeroRecords: "Sin resultados encontrados",
      paginate: {
        first: "Primero",
        last: "Ultimo",
        next: "Siguiente",
        previous: "Anterior",
      },
    },
  });
});

/* -------------- Agregar Roles------------------ */
// var agregar_roles;
var agregar_roles;
if ((agregar_roles = document.getElementById("agregar_roles"))) {
  agregar_roles.addEventListener("click", agregarRoles, false);

  function agregarRoles() {
    let rol = document.getElementById("rol").value;

    let estatus = document.getElementById("estatus").value;
    /* comprobar campos vacios */
    if (rol == "" || estatus == "") {
      Swal.fire({
        icon: "error",
        title: "Campos vacíos",
        text: "Todos los campos son obligatorios",
        confirmButtonColor: "#3085d6",
      });
      return;
    }

    $.ajax({
      url: "index.php?page=registrarRoles",
      type: "post",
      dataType: "json",
      data: {
        rol: rol,

        estatus: estatus,
      },
    })
      .done(function (response) {
        if (response.data.success == true) {
          document.getElementById("formRegistrarRoles").reset();

          $("#modalAgregarRoles").modal("hide");

          Swal.fire({
            icon: "success",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });

          $("#tablaRoles").DataTable().ajax.reload();
        } else {
          Swal.fire({
            icon: "error",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });
        }
      })
      .fail(function () {
        console.log("error");
      });
  }
}
$("#formRegistrarRoles")
  .unbind("submit")
  .bind("submit", function (e) {
    e.preventDefault();

    let rol = document.getElementById("rol").value;
    let estatus = document.getElementById("estatus").value;

    /* comprobar campos vacios */
    if (rol == "" || estatus == "") {
      Swal.fire({
        icon: "error",
        title: "Atención",
        text: "Todos los campos son obligatorios",
        confirmButtonColor: "#3085d6",
      });
      return;
    }

    $.ajax({
      url: "index.php?page=registrarRoles",
      type: "POST",
      data: new FormData(this),
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function () {
        //btnSaveLoad();
      },
      success: function (response) {
        var respuesta = JSON.parse(response);

        if (respuesta.data.success == true) {
          Swal.fire({
            icon: "success",
            confirmButtonColor: "#3085d6",
            title: respuesta.data.message,
            text: respuesta.data.info,
          });

          $("#tablaRoles").DataTable().ajax.reload();

          document.getElementById("formRegistrarRoles").reset();
          //$("#radiosfoto").click();

          $("#modalAgregarRoles").modal("hide");
        } else {
          Swal.fire({
            icon: "warning",
            confirmButtonColor: "#3085d6",
            title: respuesta.data.message,
            text: respuesta.data.info,
          });
        }
      },
    });
  });

/* -------------- Ver roles ------------------ */
function verRoles(id) {
  let id_roles = id;

  $.ajax({
    url: "index.php?page=verRoles",
    type: "post",
    dataType: "json",
    data: {
      id_roles: id_roles,
    },
  })
    .done(function (response) {
      if (response.data.success == true) {
        document.getElementById("rol_roles").innerHTML =
          "Nombre: " + response.data.rol;

        document.getElementById("fecha_roles").innerHTML =
          "Fecha: " + response.data.fecha;

        if (response.data.estatus == 1) {
          document.getElementById("estatus_roles").innerHTML =
            "Estado: <button class='btn btn-success'>Activo</button>";
        } else {
          document.getElementById("estatus_roles").innerHTML =
            "Estado: <button class='btn btn-danger'>inactivo</button>";
        }

        $("#modalVisualizarRoles").modal("show");
      } else {
      }
    })
    .fail(function () {
      console.log("error");
    });
}

/* -------------- Modificar Roles ------------------ */

var modificar_roles;
if ((modificar_roles = document.getElementById("modificar_roles"))) {
  modificar_roles.addEventListener("click", modificarRoles, false);

  function modificarRoles() {
    let id_roles = document.getElementById("id_roles_update").value;

    let rol = document.getElementById("rol_update").value;

    let estatus = document.getElementById("estatus_update").value;
    /* comprobar campos vacios */
    if (rol == "" || estatus == "") {
      Swal.fire({
        icon: "error",
        title: "Campos vacíos",
        text: "Todos los campos son obligatorios",
        confirmButtonColor: "#3085d6",
      });
      return;
    }
    $.ajax({
      url: "index.php?page=modificarRoles",
      type: "post",
      dataType: "json",
      data: {
        id_roles: id_roles,

        rol: rol,

        estatus: estatus,
      },
    })
      .done(function (response) {
        if (response.data.success == true) {
          document.getElementById("formActualizarRoles").reset();

          $("#modalActualizarRoles").modal("hide");

          Swal.fire({
            icon: "success",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });

          $("#tablaRoles").DataTable().ajax.reload();
        } else {
          Swal.fire({
            icon: "error",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });
        }
      })
      .fail(function () {
        console.log("error");
      });
  }
}
$("#formActualizarRoles")
  .unbind("submit")
  .bind("submit", function (e) {
    e.preventDefault();

    let id_roles_update = document.getElementById("id_roles_update").value;

    let rol = document.getElementById("rol_update").value;

    let estatus = document.getElementById("estatus_update").value;

    /* comprobar campos vacios */
    if (rol == "" || estatus == "") {
      Swal.fire({
        icon: "error",
        title: "Atención",
        text: "Todos los campos son obligatorios",
        confirmButtonColor: "#3085d6",
      });
      return;
    }
    $.ajax({
      url: "index.php?page=modificarRoles",
      type: "POST",
      data: new FormData(this),
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function () {
        //btnSaveLoad();
      },
      success: function (response) {
        var respuesta = JSON.parse(response);

        if (respuesta.data.success == true) {
          console.log(respuesta.data);
          Swal.fire({
            icon: "success",
            confirmButtonColor: "#3085d6",
            title: respuesta.data.message,
            text: respuesta.data.info,
          });

          document.getElementById("formActualizarRoles").reset();

          $("#formActualizarRoles").modal("hide");

          $("#tablaRoles").DataTable().ajax.reload();
        } else {
          Swal.fire({
            icon: "error",
            confirmButtonColor: "#3085d6",
            title: respuesta.data.message,
            text: respuesta.data.info,
          });
        }
      },
    });
  });

/* --------------listarActualizacionRoles ------------------ */
function listarActualizacionRoles(id) {
  let id_roles = id;
  let id_roles_update = document.getElementById("id_roles_update").value;
  let rol = document.getElementById("rol_update").value;
  let estatus = document.getElementById("estatus_update").value;

  let listar = "listar";

  $.ajax({
    url: "index.php?page=verRoles",
    type: "post",
    dataType: "json",
    data: {
      id_roles: id_roles,
    },
  })
    .done(function (response) {
      if (response.data.success == true) {
        document.getElementById("id_roles_update").value = response.data.id;
        document.getElementById("rol_update").value = response.data.rol;
        document.getElementById("estatus_update").value = response.data.estatus;

        $("#modalActualizarRoles").modal("show");
      } else {
      }
    })
    .fail(function () {
      console.log("error");
    });
}

/* -------------- Activar e Inactivar Roles ------------------ */
function inactivarRoles(id) {
  var id_roles = id;

  Swal.fire({
    title: "¿Está seguro de moficar el estado del rol?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "index.php?page=inactivarRoles",
        type: "post",
        dataType: "json",
        data: {
          id_roles: id_roles,
        },
      })
        .done(function (response) {
          if (response.data.success == true) {
            $("#tablaRoles").DataTable().ajax.reload();
          } else {
            Swal.fire({
              icon: "error",
              title: response.data.message,
              confirmButtonColor: "#0d6efd",
              text: response.data.info,
            });
          }
        })
        .fail(function () {
          console.log("error");
        });
    }
  });
}



/*listar actualizacion especialidades */
$(document).ready(function () {
  $("#tbl_especialidad").DataTable({
    order: [[0, "DESC"]],
    procesing: true,
    serverSide: true,
    ajax: "index.php?page=listarEspecialidades",
    pageLength: 10,
    columnDefs: [
      {
        orderable: false,
        targets: 3,
        render: function (data, type, row, meta) {
          let botones =
            `
                <button type="button" class="btn btn-primary btn-sm" onclick="verEspecialidad(` +
            row[3] +
            `)"><i class="bi bi-eye-fill"></i></button>&nbsp;

               <button type="button" class="btn btn-warning btn-sm"  onclick="listarActualizacionEspecialidad(` +
            row[3] +
            `)"><i class="fas fa-edit"></i></button>&nbsp;

            `;
          return botones;
        },
      },
    ],
    dom: "Bfrtip",
    language: {
      decimal: "",
      emptyTable: "No hay información",
      info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
      infoFiltered: "(Filtrado de _MAX_ total entradas)",
      infoPostFix: "",
      thousands: ",",
      lengthMenu: "Mostrar _MENU_ Entradas",
      loadingRecords: "Cargando...",
      processing: "Procesando...",
      search: "Buscar:",
      zeroRecords: "Sin resultados encontrados",
      paginate: {
        first: "Primero",
        last: "Ultimo",
        next: "Siguiente",
        previous: "Anterior",
      },
    },
  });
});


/*Listar Motivos */

$(document).ready(function () {
  $("#tbl_motivos").DataTable({
    order: [[0, "DESC"]],
    procesing: true,
    serverSide: true,
    ajax: "index.php?page=listarMotivos",
    pageLength: 10,
    columnDefs: [
      {
        orderable: false,
        targets: 2,
        render: function (data, type, row, meta) {
          let botones =
            `
                <button type="button" class="btn btn-primary btn-sm" onclick="verMotivo(` +
            row[2] +
            `)"><i class="fas fa-eye"></i></button>&nbsp;

               <button type="button" class="btn btn-warning btn-sm"  onclick="listarActualizacionMotivo(` +
            row[2] +
            `)"><i class="fas fa-edit"></i></button>&nbsp;

            `;
          return botones;
        },
      },
    ],
    dom: "Bfrtip",
    language: {
      decimal: "",
      emptyTable: "No hay información",
      info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
      infoFiltered: "(Filtrado de _MAX_ total entradas)",
      infoPostFix: "",
      thousands: ",",
      lengthMenu: "Mostrar _MENU_ Entradas",
      loadingRecords: "Cargando...",
      processing: "Procesando...",
      search: "Buscar:",
      zeroRecords: "Sin resultados encontrados",
      paginate: {
        first: "Primero",
        last: "Ultimo",
        next: "Siguiente",
        previous: "Anterior",
      },
    },
  });
});


/*------ listar Medicamentos ---------*/
$(document).ready(function () {
  $("#tbl_medicamentos").DataTable({
    order: [[0, "DESC"]],
    procesing: true,
    serverSide: true,
    ajax: "index.php?page=listarMedicamentos",
    pageLength: 9,
    columnDefs: [
      {
        orderable: false,
        targets: 2,
        render: function (data, type, row, meta) {
          let botones =
            `
                    <button type="button" class="btn btn-primary btn-sm" onclick="listarVer(` +
            row[2] +
            `)"><i class="fas fa-eye"></i></button>&nbsp;
    
                   <button type="button" class="btn btn-warning btn-sm"  onclick="listarActualizacionMedicamentos(` +
            row[2] +
            `)"><i class="fas fa-edit"></i></button>&nbsp;
    
                    `;
          return botones;
        },
      },
    ],
    dom: "Bfrtip",
    language: {
      decimal: "",
      emptyTable: "No hay información",
      info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
      infoFiltered: "(Filtrado de _MAX_ total entradas)",
      infoPostFix: "",
      thousands: ",",
      lengthMenu: "Mostrar _MENU_ Entradas",
      loadingRecords: "Cargando...",
      processing: "Procesando...",
      search: "Buscar:",
      zeroRecords: "Sin resultados encontrados",
      paginate: {
        first: "Primero",
        last: "Ultimo",
        next: "Siguiente",
        previous: "Anterior",
      },
    },
  });
});


/* -------------- Listar datos para ver ------------------ */

function VerPersona(id) {
  let id_persona = id;

  let listar = "listar";

  $.ajax({
    url: "index.php?page=listarDatosPersona",
    type: "post",
    dataType: "json",
    data: {
      id_persona: id_persona,
    },
  })
    .done(function (response) {
      if (response.data.success == true) {
        document.getElementById("nombre_apellido").innerHTML =
          "Nombre/Apellido: " +
          response.data.nombre_apellido;
        document.getElementById("documento").innerHTML =
          "Documento: " + response.data.documento;
        document.getElementById("").innerHTML =
          "Edad: " + response.data.edad;
        document.getElementById("sexo").innerHTML =
          "Sexo: " + response.data.telefono;
        document.getElementById("telefono_paciente").innerHTML =
          "Teléfono: " + response.data.telefono;
        document.getElementById("direccion_paciente").innerHTML =
          "Dirección: " + response.data.direccion;
        document.getElementById("fecha_registro").innerHTML =
          "Fecha: " + response.data.fecha;

        if (response.data.estatus == 1) {
          document.getElementById("estado_paciente").innerHTML =
            "Estado: <button class='btn btn-success'>Activo</button>";
        } else {
          document.getElementById("estado_paciente").innerHTML =
            "Estado: <button class='btn btn-danger'>inactivo</button>";
        }

        if (response.data.origen == 1) {
          document.getElementById("cedula_paciente").innerHTML =
            "Cédula de identidad: V- " + response.data.cedula;
        } else {
          document.getElementById("cedula_paciente").innerHTML =
            "Cédula de identidad: E- " + response.data.cedula;
        }

        $("#modalVisualizarPaciente").modal("show");
      } else {
      }
    })
    .fail(function () {
      console.log("error");
    });
}

/* -------------- Ver Usuario ------------------ */
function verUsuario(id) {
  let id_usuario = id;

  let listar = "listar";

  $.ajax({
    url: "index.php?page=verUsuario",
    type: "post",
    dataType: "json",
    data: {
      id_usuario: id_usuario,
    },
  })
    .done(function (response) {
      if (response.data.success == true) {
        document.getElementById("nombre_apellido_u").innerHTML ='<span class="badge" style="font-size: 15px;">Nombre/Apellido: </span>'+response.data.nombre_apellido;
        document.getElementById("nombre_usuario").innerHTML ='<span class="badge" style="font-size: 15px;">Usuario: </span>'+ response.data.usuario;
        document.getElementById("documento_u").innerHTML ='<span class="badge" style="font-size: 15px;">N° documento: </span>'+ response.data.documento;
        document.getElementById("rol_usuario").innerHTML ='<span class="badge" style="font-size: 15px;">Rol: </span>'+ response.data.rol;
        document.getElementById("fecha_u").innerHTML = response.data.fecha;
        document.getElementById("foto_usuario").setAttribute('src', `libs/img/${response.data.foto}`);


        if (response.data.estatus == 1) {
          document.getElementById("estatus_usuario").innerHTML =
            "<span class='badge' style='font-size: 15px;' >Estatus:</span> <span class='badge bg-success'>Activo</span>";
        } else {
          document.getElementById("estatus_usuario").innerHTML =
            "<span class='badge' style='font-size: 15px;'>Estatus: </span> <span class='badge bg-danger'>Inactivo</span>";
        }

        $("#modalVisualizarUsuario").modal("show");
      } else {
      }
    })
    .fail(function () {
      console.log("error");
    });
}

/* -------------- Modificar Usuario ------------------ */
var modificar_usuario;
if ((modificar_usuario = document.getElementById("modificar_usuario"))) {
  modificar_usuario.addEventListener("click", modificarUsuario, false);
  async function modificarUsuario() {
    let id_usuario = document.getElementById("id_usuario_update").value;
    let id_persona = document.getElementById("id_persona_u").value;
    let documento_u = document.getElementById("n_documento_u").value;
    let tipo_doc_u = document.getElementById("tipo_documento_u").value;
    let p_nombre_u = document.getElementById("p_nombre_u").value;
    let s_nombre_u = document.getElementById("s_nombre_u").value;
    let p_apellido_u = document.getElementById("p_apellido_u").value;
    let s_apellido_u = document.getElementById("s_apellido_u").value;
    let correo_u = document.getElementById("correo_u").value;
    let direccion_u = document.getElementById("direccion_u").value;
    let telefono = document.getElementById("telefono_u").value;
  
    // Datos usuario
    let rol = document.getElementById("rol_u").value;
    let usuario = document.getElementById("usuario_u").value;
  
    try {
      const response = await $.ajax({
        url: "index.php?page=modificarUsuario",
        type: "post",
        dataType: "json",
        data: {
          id_usuario: id_usuario,
          id_persona: id_persona,
          documento: documento_u,
          tipo_doc: tipo_doc_u,
          p_nombre: p_nombre_u,
          s_nombre: s_nombre_u,
          p_apellido: p_apellido_u,
          s_apellido: s_apellido_u,
          correo: correo_u,
          direccion: direccion_u,
          telefono: telefono,
          rol: rol,
          usuario: usuario,
        }
      });
  
      if (response.data.success == true) {
        document.getElementById("formActualizarUsuario").reset();
        $("#modalActualizarUsuarios").modal("hide");
  
        Swal.fire({
          icon: "success",
          confirmButtonColor: "#3085d6",
          title: response.data.message,
          text: response.data.info,
        });
  
        $("#tablaUsuario").DataTable().ajax.reload();
      } else {
        Swal.fire({
          icon: "error",
          confirmButtonColor: "#3085d6",
          title: response.data.message,
          text: response.data.info,
        });
      }
    } catch (error) {
      console.error("Error en la solicitud AJAX: ", error);
    }
  }
}

// /* -------------- Activar e Inactivar Usuario ------------------ */
// function inactivarUsuario(id) {
//   var id_usuario = id;

//   Swal.fire({
//     title: "¿Está seguro de moficar el estado del usuario?",
//     text: "El paciente sera dado de alta y el registro quedara guardado en la traza.",
//     icon: "warning",
//     showCancelButton: true,
//     confirmButtonColor: "#3085d6",
//     cancelButtonColor: "#d33",
//     confirmButtonText: "Si",
//     cancelButtonText: "Cancelar",
//   }).then((result) => {
//     if (result.isConfirmed) {
//       $.ajax({
//         url: "index.php?page=inactivarUsuario",
//         type: "post",
//         dataType: "json",
//         data: {
//           id_usuario: id_usuario,
//         },
//       })
//         .done(function (response) {
//           if (response.data.success == true) {
//             $("#tablaUsuario").DataTable().ajax.reload();
//           } else {
//             Swal.fire({
//               icon: "error",
//               title: response.data.message,
//               confirmButtonColor: "#0d6efd",
//               text: response.data.info,
//             });
//           }
//         })
//         .fail(function () {
//           console.log("error");
//         });
//     }
//   });
// }

var agregar_especialidad;
if ((agregar_especialidad = document.getElementById("agregar_especialidad"))) {
  agregar_especialidad.addEventListener("click", agregarEspecialidad, false);

  function agregarEspecialidad() {
    let especialidad         = document.getElementById("especialidad").value;
    let modalidad            = document.getElementById("modalidad").value;
    let tm_cita              = document.getElementById("TM_cita").value;
    if (tm_cita == '') {
      tm_cita.value = 'N/A';
    }
    
    $.ajax({
      url: "index.php?page=registrarEspecialidad",
      type: "post",
      dataType: "json",
      data: {
        especialidad: especialidad,
        modalidad: modalidad,
        tm_cita: tm_cita,
      },
    })
      .done(function (response) {
        if (response.data.success == true) {
          document.getElementById("formRegistrarEspecialidad").reset();

          $("#modalAgregarEspecialidad").modal("hide");

          Swal.fire({
            icon: "success",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });

          $("#tbl_especialidad").DataTable().ajax.reload();
        } else {
          Swal.fire({
            icon: "danger",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });
        }
      })
      .fail(function () {
        console.log("error");
      });
  }
}
const modalidad = document.getElementById('modalidad');
const tm_cita = document.getElementById('TM_cita');
if(modalidad){
  const campoTM = document.getElementById('divTM');

  modalidad.addEventListener('change', function() {
    if (this.value == 'Por cita') {
      campoTM.style.display = 'inline-block'; // Mostrar campo de texto
    } else {
      campoTM.style.display = 'none'; // Ocultar campo de texto
      tm_cita.value = 'N/A';
    }
  });

}

const modalidad_update = document.getElementById('modalidad_update');
const TM_cita_update = document.getElementById('TM_cita_update');
if(modalidad_update){
  const campoTM_update = document.getElementById('divTM_update');

  modalidad_update.addEventListener('change', function() {
    if (this.value == 'Por cita') {
      campoTM_update.style.display = 'inline-block'; // Mostrar campo de texto
    } else {
      campoTM_update.style.display = 'none'; // Ocultar campo de texto
      TM_cita_update.value = 'N/A';
    }
  });

}

   

/*-------------- Agregar Persona ------------------ */

/* --------- REGISTRAR PERSONA ----------- */

agregar_persona = document.getElementById("agregar_persona")
if (agregar_persona) {
  agregar_persona.addEventListener("click", agregarPersona, false);

  function agregarPersona() {

    /*Datos de la persona */

    let primer_nombre     = document.getElementById("primer_nombre").value;
    let segundo_nombre    = document.getElementById("segundo_nombre").value;
    let primer_apellido   = document.getElementById("primer_apellido").value;
    let segundo_apellido  = document.getElementById("segundo_apellido").value;
    let tipo_documento    = document.getElementById("tipo_documento").value;
    let n_documento       = document.getElementById("n_documento").value;
    let telefono          = document.getElementById("telefono").value;
    let correo            = document.getElementById("correo").value;
    let direccion         = document.getElementById("direccion").value;
    let sexo              = document.getElementById("sexo").value;
    let tipo_persona      = document.getElementById("tipo_persona").value;
    let fecha_nac         = document.getElementById("fecha_nac").value;

    var sexoP = document.getElementsByName("sexo");
        
        for (let i = 0; i < sexoP.length; i++) {
          if (sexoP[i].checked) {
            // Si el radio está seleccionado, obtener su valor
            var sexoSeleccionadoP = sexoP[i].value;
            console.log("El sexo seleccionado es:", sexoSeleccionadoP);
            break;
          }
        }



    $.ajax({
      url: "index.php?page=registrarPersona",
      type: "post",
      dataType: "json",
      data: {
        
        // Datos de la persona
        primer_nombre: primer_nombre,
        segundo_nombre: segundo_nombre,
        primer_apellido: primer_apellido,
        segundo_apellido: segundo_apellido,
        tipo_documento: tipo_documento,
        n_documento: n_documento,
        telefono: telefono,
        fecha_nac: fecha_nac,
        sexo: sexoSeleccionadoP,
        correo: correo,
        direccion: direccion,
        tipo_persona: tipo_persona,

      },
    })
      .done(function (response) {
        if (response.data.success == true) {

           // $("#modalAgregarPersona").modal("hide");
           gestionarModal('modalAgregarPersona', 'ocultar');
           document.getElementById("formRegistrarPersona").reset(); 
      
          const limpiarEstilosValidacion = () => {
            // Listado de los campos a los que se les quiere quitar los estilos de validación
            const campos = ['primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido', 'direccion', 'telefono', 'tipo_documento','n_documento','correo','fecha_nac' ];
        
            campos.forEach(campo => {
                const grupo = document.getElementById(`grupo_${campo}`);
                grupo.classList.remove('formulario__grupo-incorrecto', 'formulario__grupo-correcto'); // Remueve clases de validación
                const icono = document.querySelector(`#grupo_${campo} i`);
                if (icono) {
                    icono.classList.remove('fa-check-circle', 'fa-times-circle'); // Remueve iconos de validación
                }
                const errorTexto = document.querySelector(`#grupo_${campo} .formulario__input-error`);
                if (errorTexto) {
                    errorTexto.classList.remove('formulario__input-error-activo'); // Oculta mensajes de error
                }
            });
        };
        
        // Llamar a esta función cuando necesites limpiar los estilos de validación
        limpiarEstilosValidacion();
        
         

         

          Swal.fire({
            icon: "success",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });

          $("#tbl_personas").DataTable().ajax.reload();
          
 


        } else {
          
          Swal.fire({
            icon: "danger",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });
        }
      })
      .fail(function () {
        console.log("error");
      });
  }
}

const agregarHistoriaMedicaButton = document.getElementById("agregar_historia_medica");

if (agregarHistoriaMedicaButton) {
  agregarHistoriaMedicaButton.addEventListener("click", async () => {
    // Obtener las enfermedades seleccionadas del select múltiple
    const enfermedadesSeleccionadas = Array.from(
      document.querySelector('.select-multiple-enfermedades').selectedOptions
    ).map((option) => option.value);

    // Medicamentos seleccionados del select múltiple
    const medicamentosSeleccionados = Array.from(
      document.querySelector('.select-multiple-medicamentos').selectedOptions
    ).map((option) => option.value);

    const tipo_sangre           = document.getElementById("tipo_sangre").value;
    const fumador               = document.getElementById("fumador").checked ? "Sí" : "No";
    const alcohol               = document.getElementById("alcohol").checked ? "Sí" : "No";
    const ac_fisica             = document.getElementById("ac_fisica").checked ? "Sí" : "No";
    const medicado              = document.getElementById("medicado").checked ? "Sí" : "No";
    const ciru_hospi            = document.getElementById("ciru_hospi").value;
    const alergia               = document.getElementById("alergia").value;
    const antec_fami            = document.getElementById("antec_fami").value;
    const id_persona_h          = document.getElementById("id_representado").value;
    const frecuencia_f          = document.getElementById("frecuencia_f").value;
    const frecuencia_alcohol    = document.getElementById("frecuencia_alcohol").value;
    const frecuencia_ac_f       = document.getElementById("frecuencia_ac_f").value;

    const data = {
      enfermedades: enfermedadesSeleccionadas,
      tipo_sangre: tipo_sangre,
      fumador: fumador,
      alcohol: alcohol,
      ac_fisica: ac_fisica,
      medicado: medicado,
      ciru_hospi: ciru_hospi,
      alergia: alergia,
      id_persona_h: id_persona_h,
      antec_fami: antec_fami,
      medicamentos :medicamentosSeleccionados,
      frecuencia_alcohol :frecuencia_alcohol,
      frecuencia_f :frecuencia_f,
      frecuencia_ac_f: frecuencia_ac_f
    };

    try {
      const response = await fetch("index.php?page=registrarHistoriaMedica", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data),
      });

      const result = await response.json();

      if (result.data.success) {
        document.getElementById("formRegistrarHistoriaMedica").reset();
        gestionarModal('registrarHistoriaMedica', 'ocultar');
        
        Swal.fire({
          icon: "success",
          confirmButtonColor: "#3085d6",
          title: result.data.message,
          text: result.data.info,
        });

        window.location.href = `http://localhost/SIATICS/index.php?page=verPersona&id=${response.data.id_persona_h}`;
      } else {
        Swal.fire({
          icon: "danger",
          confirmButtonColor: "#3085d6",
          title: result.data.message,
          text: result.data.info,
        });
      }
    } catch (error) {
      console.error("Error al enviar los datos:", error);
    }
  });
}




/* --------- REGISTRAR REPRESENTANTE ----------- */

agregar_representante = document.getElementById("agregar_representante")
if (agregar_representante) {
  agregar_representante.addEventListener("click", agregarRepresentante, false);

  function agregarRepresentante() {

    /*Datos del representante */

    let primer_nombre_r     = document.getElementById("primer_nombre_r").value;
    let segundo_nombre_r    = document.getElementById("segundo_nombre_r").value;
    let primer_apellido_r   = document.getElementById("primer_apellido_r").value;
    let segundo_apellido_r  = document.getElementById("segundo_apellido_r").value;
    let tipo_documento_r    = document.getElementById("tipo_documento_r").value;
    let n_documento_r       = document.getElementById("n_documento_r").value;
    let telefono_r          = document.getElementById("telefono_r").value;
    let correo_r            = document.getElementById("correo_r").value;
    let direccion_r         = document.getElementById("direccion_r").value;
    let parentesco          = document.getElementById("parentesco").value;
    let id_representado     = document.getElementById("id_representado").value;
    let fecha_nac_r         = document.getElementById("fecha_nac_r").value;
    let sexoR               = document.getElementsByName("sexo");
    let tipo_persona         = document.getElementsByName("tipo_persona");
     // let id_representante    = document.getElementById("id_representante").value;
    // let id_persona_r        = document.getElementById("id_persona_r").value;

    for (let i = 0; i < sexoR.length; i++) {
      if (sexoR[i].checked) {
        // Si el radio está seleccionado, obtener su valor
        var sexoSeleccionadoR = sexoR[i].value;
        console.log("El sexo seleccionado es:", sexoSeleccionadoR);
        break;
      }
    }

    $.ajax({
      url: "index.php?page=registrarRepresentante",
      type: "post",
      dataType: "json",
      data: {
        
        // Datos del representante
        primer_nombre_r: primer_nombre_r,
        segundo_nombre_r: segundo_nombre_r,
        primer_apellido_r: primer_apellido_r,
        segundo_apellido_r: segundo_apellido_r,
        tipo_documento_r: tipo_documento_r,
        n_documento_r: n_documento_r,
        telefono_r: telefono_r,
        correo_r: correo_r,
        direccion_r: direccion_r,
        parentesco: parentesco,
        id_representado: id_representado,
        fecha_nac_r: fecha_nac_r,
        sexo: sexoSeleccionadoR,
        tipo_persona: tipo_persona
        // id_representante: id_representante,
        // id_persona_r: id_persona_r

      },
    })
      .done(function (response) {
        if (response.data.success == true) {
      
          const limpiarEstilosValidacionRepresentante = () => {
            // Listado de los campos a los que se les quiere quitar los estilos de validación
            const campos = ['primer_nombre_r', 'segundo_nombre_r', 'primer_apellido_r', 'segundo_apellido_r', 'direccion_r', 'telefono_r', 'tipo_documento_r', 'n_documento_r', 'parentesco'];
        
            campos.forEach(campo => {
                const grupo = document.getElementById(`grupo_${campo}`);
                grupo.classList.remove('formulario__grupo-incorrecto', 'formulario__grupo-correcto'); // Remueve clases de validación
                const icono = document.querySelector(`#grupo_${campo} i`);
                if (icono) {
                    icono.classList.remove('fa-check-circle', 'fa-times-circle'); // Remueve iconos de validación
                }
                const errorTexto = document.querySelector(`#grupo_${campo} .formulario__input-error`);
                if (errorTexto) {
                    errorTexto.classList.remove('formulario__input-error-activo'); // Oculta mensajes de error
                }
            });
        };
        
        // Llamar a esta función cuando necesites limpiar los estilos de validación
        limpiarEstilosValidacionRepresentante();
        
          document.getElementById("formRegistrarRepresentante").reset();

          $("#modalAgregarRepresentante").modal("hide");

          Swal.fire({
            icon: "success",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });

          window.location.href = `http://localhost/SIATICS/index.php?page=verPersona&id=${response.data.id_representado}`;

 


        } else {
          
          Swal.fire({
            icon: "danger",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });
        }
      })
      .fail(function () {
        console.log("error");
      });
  }
}


/* --------- REGISTRAR REPRESENTADO ----------- */

agregar_representado = document.getElementById("agregar_representado")
if (agregar_representado) {
  agregar_representado.addEventListener("click", agregarRepresentado, false);

  function agregarRepresentado() {

    /*Datos del representado */

    let primer_nombre_re     = document.getElementById("primer_nombre_re").value;
    let segundo_nombre_re    = document.getElementById("segundo_nombre_re").value;
    let primer_apellido_re   = document.getElementById("primer_apellido_re").value;
    let segundo_apellido_re  = document.getElementById("segundo_apellido_re").value;
    let tipo_documento_re    = document.getElementById("tipo_documento_re").value;
    let n_documento_re       = document.getElementById("n_documento_re").value;
    let telefono_re          = document.getElementById("telefono_re").value;
    let correo_re            = document.getElementById("correo_re").value;
    let direccion_re         = document.getElementById("direccion_re").value;
    let parentesco           = document.getElementById("parentesco_re").value;
    let id_representante     = document.getElementById("id_representante").value;
    let fecha_nac_re         = document.getElementById("fecha_nac_re").value;
    let sexoRe               = document.getElementsByName("sexo");
    let tipo_persona         = document.getElementsByName("tipo_persona");
    
    
    for (let i = 0; i < sexoRe.length; i++) {
      if (sexoRe[i].checked) {
        // Si el radio está seleccionado, obtener su valor
        var sexoSeleccionadoRe = sexoRe[i].value;
        break;
      }
    }

    $.ajax({
      url: "index.php?page=registrarRepresentado",
      type: "post",
      dataType: "json",
      data: {
        
        // Datos del representado
        primer_nombre_re: primer_nombre_re,
        segundo_nombre_re: segundo_nombre_re,
        primer_apellido_re: primer_apellido_re,
        segundo_apellido_re: segundo_apellido_re,
        tipo_documento_re: tipo_documento_re,
        n_documento_re: n_documento_re,
        telefono_re: telefono_re,
        correo_re: correo_re,
        direccion_re: direccion_re,
        parentesco: parentesco,
        id_representante: id_representante,
        fecha_nac_re: fecha_nac_re,
        sexo: sexoSeleccionadoRe,
        tipo_persona: tipo_persona

      },
    })
      .done(function (response) {
        if (response.data.success == true) {
      
          const limpiarEstilosValidacionRepresentado = () => {
            // Listado de los campos a los que se les quiere quitar los estilos de validación
            const campos = ['primer_nombre_r', 'segundo_nombre_r', 'primer_apellido_r', 'segundo_apellido_r', 'direccion_r', 'telefono_r', 'tipo_documento_r', 'n_documento_r', 'parentesco'];
        
            campos.forEach(campo => {
                const grupo = document.getElementById(`grupo_${campo}`);
                grupo.classList.remove('formulario__grupo-incorrecto', 'formulario__grupo-correcto'); // Remueve clases de validación
                const icono = document.querySelector(`#grupo_${campo} i`);
                if (icono) {
                    icono.classList.remove('fa-check-circle', 'fa-times-circle'); // Remueve iconos de validación
                }
                const errorTexto = document.querySelector(`#grupo_${campo} .formulario__input-error`);
                if (errorTexto) {
                    errorTexto.classList.remove('formulario__input-error-activo'); // Oculta mensajes de error
                }
            });
        };
        
        // Llamar a esta función cuando necesites limpiar los estilos de validación
        limpiarEstilosValidacionRepresentado();
        
          document.getElementById("formRegistrarRepresentado").reset();

          $("#modalAgregarRepresentado").modal("hide");

          Swal.fire({
            icon: "success",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });

          window.location.href = `http://localhost/SIATICS/index.php?page=verPersona&id=${response.data.id_representante}`;

 


        } else {
          
          Swal.fire({
            icon: "danger",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });
        }
      })
      .fail(function () {
        console.log("error");
      });
  }
}



let n_documento_persona = document.getElementById("n_documento");

if (n_documento_persona) {

  console.log(n_documento_persona);
    n_documento_persona.addEventListener("blur", function () {
    n_documento = n_documento_persona.value;

    if (n_documento) {
        $.ajax({
            url: "index.php?page=verificarDocumento",
            type: "post",
            dataType: "json",
            data: { n_documento: n_documento },
        })
        .done(function (response) {
            if (response.success == false) {
              Swal.fire({
                icon: "warning",
                confirmButtonColor: "#3085d6",
                title: "¡Número de documento duplicado!",
                text: "Por favor, verifica el número y vuelve a intentarlo."
            });

                // Bloquear el botón de guardar si el documento ya existe
                document.getElementById("agregar_persona").disabled = true;
            } else {
                // Desbloquear el botón si el documento está disponible
                document.getElementById("agregar_persona").disabled = false;
            }
        })
        .fail(function () {
            console.log("error en la verificación");
        });
    }
  });
}


function validarFecha(fechaIngresada) {
  // Convertimos la fecha ingresada a un objeto Date
  const fecha = new Date(fechaIngresada);

  // Obtenemos la fecha actual
  const fechaActual = new Date();

  // Comparamos las fechas
  if (fecha > fechaActual) {
    return false; // Indicamos que la fecha no es válida
  } else {
    return true; // Indicamos que la fecha es válida
  }
}

const fechaNacInput = document.getElementById("fecha_nac");






/* -------------- Listar datos para actualización ------------------ */

function listarActualizacionEspecialidad(id) {
  let id_especialidad = id;

  let listar = "listar";

  $.ajax({
    url: "index.php?page=listarActualizacionEspecialidad",
    type: "post",
    dataType: "json",
    data: {
      id_especialidad: id_especialidad

    },
  })
    .done(function (response) {
      if (response.data.success == true) {
        document.getElementById("id_especialidad").value =
          response.data.id_especialidad;
      document.getElementById(
            "update_especialidad"
          ).value = response.data.especialidad;
      document.getElementById(
            "modalidad_update"
          ).value = response.data.modalidad;
        
      document.getElementById(
            "TM_cita_update"
          ).value = response.data.tm_porcita;
      
      if(response.data.tm_porcita !== 'N/A') {
        document.getElementById("divTM_update").removeAttribute('style');

      } else {
        document.getElementById("divTM_update").setAttribute('style','display:none');
      }

        
        $("#modalActualizarEspecialidad").modal("show");

      } else {
      }
    })
    .fail(function () {
      console.log("error");
    });
}

/* -------------- Modificar Especialidad ------------------ */
var modificar_especialidad;
if (
  (modificar_especialidad = document.getElementById("modificar_especialidad"))
) {
  modificar_especialidad.addEventListener(
    "click",
    modificarEspecialidad,
    false
  );

  async  function modificarEspecialidad() {

    let id_especialidad = document.getElementById(
      "id_especialidad"
    ).value;
    let especialidad = document.getElementById(
      "update_especialidad"
    ).value;
    let modalidad = document.getElementById(
      "modalidad_update"
    ).value;
  
    let tm_porcita = document.getElementById(
      "TM_cita_update"
    ).value;

    try {
      const response = await $.ajax({
        url: "index.php?page=modificarEspecialidad",
        type: "post",
        dataType: "json",
        data: {
          id_especialidad: id_especialidad,
          especialidad: especialidad,
          modalidad: modalidad,
          tm_porcita: tm_porcita
        }
      });
    
      if (response.data.success == true) {
        document.getElementById("formActualizarEspecialidad").reset();
        $("#modalActualizarEspecialidad").modal("hide");
    
        Swal.fire({
          icon: "success",
          confirmButtonColor: "#3085d6",
          title: response.data.message,
          text: response.data.info,
        });
    
        $("#tbl_especialidad").DataTable().ajax.reload();
      } else {
        Swal.fire({
          icon: "error",
          confirmButtonColor: "#3085d6",
          title: response.data.message,
          text: response.data.info,
        });
      }
    } catch (error) {
      console.error("Error en la solicitud AJAX: ", error);
    }
  }
}




/* -------------- Activar e Inactivar Especialidad------------------ */
function inactivarEspecialidad(id) {
  var id_especialidad = id;

  Swal.fire({
    title: "¿Está seguro de modificar el estado de la especialidad?",
    text: "La especialidad quedara inactiva?.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "index.php?page=inactivarEspecialidad",
        type: "post",
        dataType: "json",
        data: {
          id_especialidad: id_especialidad,
        },
      })
        .done(function (response) {
          if (response.data.success == true) {
            $("#tabla_especialidad").DataTable().ajax.reload();
          } else {
            Swal.fire({
              icon: "error",
              title: response.data.message,
              confirmButtonColor: "#0d6efd",
              text: response.data.info,
            });
          }
        })
        .fail(function () {
          console.log("error");
        });
    }
  });
}

/* -------------- Agregar Doctor ------------------ */
var agregar_doctor;
if ((agregar_doctor = document.getElementById("agregar_doctor"))) {
  agregar_doctor.addEventListener("click", agregarDoctor, false);

  function agregarDoctor() {
    let nombres = document.getElementById("nombres_doctor").value;
    let apellidos = document.getElementById("apellidos_doctor").value;
    let tipo_documento = document.getElementById("tipo_documento_doctor").value;
    let n_documento = document.getElementById("n_documento_doctor").value;
    let fecha_nac = document.getElementById("fecha_nac_doctor").value;
    let sexo = document.getElementById("sexo_doctor").value;
    let especialidad = document.getElementById("especialidad_doctor").value;
    let telefono = document.getElementById("telefono_doctor").value;
    let estado = document.getElementById("estado").value;
    let municipio = document.getElementById("municipio").value;
    let parroquia = document.getElementById("parroquia").value;
    let correo = document.getElementById("correo_doctor").value;
    let hora_inicio = document.getElementById("hora_inicio").value;
    let hora_fin = document.getElementById("hora_fin").value;
    let dia_inicio = document.getElementById("dia_inicio").value;
    let dia_fin = document.getElementById("dia_fin").value;

    $.ajax({
      url: "index.php?page=registrarDoctor",
      type: "post",
      dataType: "json",
      data: {
        nombres: nombres,
        apellidos: apellidos,
        tipo_documento: tipo_documento,
        n_documento: n_documento,
        fecha_nac: fecha_nac,
        sexo: sexo,
        especialidad: especialidad,
        telefono: telefono,
        estado: estado,
        municipio: municipio,
        parroquia: parroquia,
        correo: correo,
        hora_inicio: hora_inicio,
        hora_fin: hora_fin,
        dia_inicio: dia_inicio,
        dia_fin: dia_fin,
      },
    })
      .done(function (response) {
        if (response.data.success == true) {
          document.getElementById("formRegistrarDoctor").reset();

          $("#modalAgregarDoctor").modal("hide");

          Swal.fire({
            icon: "success",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });

          $("#tabla_doctor").DataTable().ajax.reload();
        } else {
          Swal.fire({
            icon: "danger",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });
        }
      })
      .fail(function () {
        console.log("error");
      });
  }
}

/*Listar datos para actualizacion de Doctor*/
function listarActualizacionDoctor(id) {
  let id_doctor = id;

  let update_nombres = document.getElementById("update_nombres_doctor").value;
  let update_apellidos = document.getElementById(
    "update_apellidos_doctor"
  ).value;
  let update_tipo_documento = document.getElementById(
    "update_tipo_documento"
  ).value;

  let update_n_documento = document.getElementById(
    "update_n_documento_doctor"
  ).value;
  let update_fecha_nac = document.getElementById("update_fecha_nac").value;
  let update_sexo = document.getElementById("update_sexo").value;
  let update_especialidad = document.getElementById(
    "update_id_especialidad"
  ).value;
  let update_telefono = document.getElementById("update_telefono").value;
  let update_estado = document.getElementById("update_estado").value;
  let update_municipio = document.getElementById("update_municipio").value;
  let update_parroquia = document.getElementById("update_parroquia").value;
  let update_correo = document.getElementById("update_correo_doctor").value;
  let id_persona = document.getElementById("id_persona").value;

  $.ajax({
    url: "index.php?page=listarActualizacionDoctor",
    type: "post",
    dataType: "json",
    data: {
      id_doctor: id_doctor,
    },
  })
    .done(function (response) {
      if (response.data.success == true) {
        document.getElementById("update_nombres_doctor").value =
          response.data.nombres;
        document.getElementById("update_apellidos_doctor").value =
          response.data.apellidos;
        document.getElementById("update_tipo_documento").value =
          response.data.tipo_documento;
        document.getElementById("update_n_documento_doctor").value =
          response.data.n_documento;
        document.getElementById("update_fecha_nac").value =
          response.data.fecha_nacimiento;
        document.getElementById("update_sexo").value = response.data.sexo;
        document.getElementById("update_estado").value =
          response.data.id_estado;
        document.getElementById("update_municipio").value =
          response.data.id_municipio;
        document.getElementById("update_parroquia").value =
          response.data.id_parroquia;
        document.getElementById("update_correo_doctor").value =
          response.data.correo;
        document.getElementById("update_telefono").value =
          response.data.telefono;
        document.getElementById("update_id_especialidad").value =
          response.data.id_especialidad;
        document.getElementById("update_hora_inicio").value =
          response.data.hora_inicio;
        document.getElementById("update_hora_fin").value =
          response.data.hora_fin;
        document.getElementById("update_dia_inicio").value =
          response.data.dia_inicio;
        document.getElementById("update_dia_fin").value = response.data.dia_fin;
        document.getElementById("id_doctor").value = response.data.id_doctor;
        document.getElementById("id_persona").value = response.data.id_persona;
        $("#modalActualizarDoctor").modal("show");
      } else {
      }
    })
    .fail(function () {
      console.log("error");
    });
}

/* -------------- Modificar Doctor ------------------ */
var modificar_doctor;
if ((modificar_doctor = document.getElementById("modificar_doctor"))) {
  modificar_doctor.addEventListener("click", modificarDoctor, false);

  function modificarDoctor() {
    let id_doctor = document.getElementById("id_doctor").value;
    let id_persona = document.getElementById("id_persona").value;
    let update_nombres = document.getElementById("update_nombres_doctor").value;
    let update_apellidos = document.getElementById(
      "update_apellidos_doctor"
    ).value;
    let update_tipo_documento = document.getElementById(
      "update_tipo_documento"
    ).value;
    let update_n_documento = document.getElementById(
      "update_n_documento_doctor"
    ).value;
    let update_fecha_nac = document.getElementById("update_fecha_nac").value;
    let update_sexo = document.getElementById("update_sexo").value;
    let update_id_especialidad = document.getElementById(
      "update_id_especialidad"
    ).value;

    let update_telefono = document.getElementById("update_telefono").value;
    let update_estado = document.getElementById("update_estado").value;
    let update_municipio = document.getElementById("update_municipio").value;
    let update_parroquia = document.getElementById("update_parroquia").value;
    let update_hora_inicio =
      document.getElementById("update_hora_inicio").value;
    let update_hora_fin = document.getElementById("update_hora_fin").value;
    let update_dia_inicio = document.getElementById("update_dia_inicio").value;
    let update_dia_fin = document.getElementById("update_dia_fin").value;
    let update_correo = document.getElementById("update_correo_doctor").value;

    $.ajax({
      url: "index.php?page=modificarDoctor",
      type: "post",
      dataType: "json",
      data: {
        id_doctor: id_doctor,
        id_persona: id_persona,
        update_nombres: update_nombres,
        update_apellidos: update_apellidos,
        update_tipo_documento: update_tipo_documento,
        update_n_documento: update_n_documento,
        update_fecha_nac: update_fecha_nac,
        update_sexo: update_sexo,
        update_id_especialidad: update_id_especialidad,
        update_estado: update_estado,
        update_municipio: update_municipio,
        update_parroquia: update_parroquia,
        update_hora_inicio: update_hora_inicio,
        update_hora_fin: update_hora_fin,
        update_dia_inicio: update_dia_inicio,
        update_dia_fin: update_dia_fin,
        update_telefono: update_telefono,
        update_correo: update_correo,
      },
    })
      .done(function (response) {
        if (response.data.success == true) {
          document.getElementById("formActualizarDoctor").reset();

          $("#modalActualizarDoctor").modal("hide");

          Swal.fire({
            icon: "success",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });

          $("#tabla_doctor").DataTable().ajax.reload();
        } else {
          Swal.fire({
            icon: "danger",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });
        }
      })
      .fail(function () {
        console.log("error");
      });
  }
}

/* -------------- Activar e Inactivar UN Doctor ------------------ */
function inactivarDoctor(id) {
  var id_doctor = id;

  Swal.fire({
    title: "¿Está seguro de modificar el estado del Doctor?",
    text: "El Doctor quedara inactivo y el registro quedará guardado en la traza.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "index.php?page=inactivarDoctor",
        type: "post",
        dataType: "json",
        data: {
          id_doctor: id_doctor,
        },
      })
        .done(function (response) {
          if (response.data.success == true) {
            $("#tabla_doctor").DataTable().ajax.reload();
          } else {
            Swal.fire({
              icon: "error",
              title: response.data.message,
              confirmButtonColor: "#0d6efd",
              text: response.data.info,
            });
          }
        })
        .fail(function () {
          console.log("error");
        });
    }
  });
}

$(document).ready(function () {
  $("#estado").on("change", function () {
    $("#estado option:selected").each(function () {
      elegido = $(this).val();
      $.ajax({
        url: "index.php?page=llenarSelectEstado",
        type: "post",
        dataType: "json",
        data: {
          elegido: elegido,
        },
      })
        .done(function (response) {
          if (response.data.success == true) {
            //Limpiar select de municipios
            var estado_municipio = (document.getElementById(
              "municipio"
            ).innerHTML = '<option value="">Seleccione</option>');

            for (es = 0; es < response.data.data.length; es++) {
              //Crea el elemento <option> dentro del select municipio
              var itemOption = document.createElement("option");

              //Contenido de los <option> del select municipios
              var municipio = document.createTextNode(
                response.data.data[es].municipio
              );
              var id_municipio = document.createTextNode(
                response.data.data[es].id_municipio
              );

              //Crear atributo value para los elemento option
              var attValue = document.createAttribute("value");
              attValue.value = response.data.data[es].id_municipio;
              itemOption.setAttributeNode(attValue);

              //Añadir contenido a los <option> creados
              itemOption.appendChild(municipio);

              document.getElementById("municipio").appendChild(itemOption);
            }
          }
        })
        .fail(function () {
          console.log("error");
        });
    });
  });
});

$(document).ready(function () {
  $("#municipio").on("change", function () {
    $("#municipio option:selected").each(function () {
      municipio = $(this).val();
      $.ajax({
        url: "index.php?page=llenarSelectParroquia",
        type: "post",
        dataType: "json",
        data: {
          municipio: municipio,
        },
      })
        .done(function (response) {
          if (response.data.success == true) {
            //Limpiar select de municipios
            document.getElementById("parroquia").innerHTML =
              '<option value="">Seleccione</option>';

            for (es = 0; es < response.data.data.length; es++) {
              //Crea el elemento <option> dentro del select municipio
              var itemOption = document.createElement("option");

              //Contenido de los <option> del select municipios
              var parroquia = document.createTextNode(
                response.data.data[es].parroquia
              );
              var id_parroquia = document.createTextNode(
                response.data.data[es].id_parroquia
              );

              //Crear atributo value para los elemento option
              var attValue = document.createAttribute("value");
              attValue.value = response.data.data[es].id_parroquia;
              itemOption.setAttributeNode(attValue);

              //Añadir contenido a los <option> creados
              itemOption.appendChild(parroquia);

              document.getElementById("parroquia").appendChild(itemOption);
            }
          }
        })
        .fail(function () {
          console.log("error");
        });
    });
  });
});

$(document).ready(function () {
  $("#update_estado").on("change", function () {
    $("#update_estado option:selected").each(function () {
      elegido = $(this).val();
      $(document).ready(function () {
        $("#municipio").on("change", function () {
          $("#municipio option:selected").each(function () {
            municipio = $(this).val();
            $.ajax({
              url: "index.php?page=llenarSelectParroquia",
              type: "post",
              dataType: "json",
              data: {
                municipio: municipio,
              },
            })
              .done(function (response) {
                if (response.data.success == true) {
                  //Limpiar select de municipios
                  document.getElementById("parroquia").innerHTML =
                    '<option value="">Seleccione</option>';

                  for (es = 0; es < response.data.data.length; es++) {
                    //Crea el elemento <option> dentro del select municipio
                    var itemOption = document.createElement("option");

                    //Contenido de los <option> del select municipios
                    var parroquia = document.createTextNode(
                      response.data.data[es].parroquia
                    );
                    var id_parroquia = document.createTextNode(
                      response.data.data[es].id_parroquia
                    );

                    //Crear atributo value para los elemento option
                    var attValue = document.createAttribute("value");
                    attValue.value = response.data.data[es].id_parroquia;
                    itemOption.setAttributeNode(attValue);

                    //Añadir contenido a los <option> creados
                    itemOption.appendChild(parroquia);

                    document
                      .getElementById("parroquia")
                      .appendChild(itemOption);
                  }
                }
              })
              .fail(function () {
                console.log("error");
              });
          });
        });
      });
      $.ajax({
        url: "index.php?page=llenarSelectEstado",
        type: "post",
        dataType: "json",
        data: {
          elegido: elegido,
        },
      })
        .done(function (response) {
          if (response.data.success == true) {
            //Limpiar select de municipios
            var estado_municipio = (document.getElementById(
              "update_municipio"
            ).innerHTML = '<option value="">Seleccione</option>');

            for (es = 0; es < response.data.data.length; es++) {
              //Crea el elemento <option> dentro del select municipio
              var itemOption = document.createElement("option");

              //Contenido de los <option> del select municipios
              var municipio = document.createTextNode(
                response.data.data[es].municipio
              );
              var id_municipio = document.createTextNode(
                response.data.data[es].id_municipio
              );

              //Crear atributo value para los elemento option
              var attValue = document.createAttribute("value");
              attValue.value = response.data.data[es].id_municipio;
              itemOption.setAttributeNode(attValue);

              //Añadir contenido a los <option> creados
              itemOption.appendChild(municipio);

              document
                .getElementById("update_municipio")
                .appendChild(itemOption);
            }
          }
        })
        .fail(function () {
          console.log("error");
        });
    });
  });
});

$(document).ready(function () {
  $("#update_municipio").on("change", function () {
    $("#update_municipio option:selected").each(function () {
      let municipio = $(this).val();
      $.ajax({
        url: "index.php?page=llenarSelectParroquia",
        type: "post",
        dataType: "json",
        data: {
          municipio: municipio,
        },
      })
        .done(function (response) {
          if (response.data.success == true) {
            // Limpiar select de parroquias
            document.getElementById("update_parroquia").innerHTML =
              '<option value="">Seleccione</option>';

            for (let es = 0; es < response.data.data.length; es++) {
              // Crea el elemento <option> dentro del select parroquia
              let itemOption = document.createElement("option");

              // Contenido de los <option> del select parroquias
              let parroquia = document.createTextNode(
                response.data.data[es].parroquia
              );

              // Crear atributo value para los elementos option
              itemOption.value = response.data.data[es].id_parroquia;

              // Añadir contenido a los <option> creados
              itemOption.appendChild(parroquia);
              document
                .getElementById("update_parroquia")
                .appendChild(itemOption);
            }
          }
        })
        .fail(function () {
          console.log("error");
        });
    });
  });
});



//--------------------select especialidad/doctor ----------------------//

$(document).ready(function () {
  $("#especialidad").on("change", function () {
    $("#especialidad option:selected").each(function () {
      elegido = $(this).val();
      $.ajax({
        url: "index.php?page=llenarSelectDoctor",
        type: "post",
        dataType: "json",
        data: {
          elegido: elegido,
        },
      })
        .done(function (response) {
          if (response.data.success == true) {
            //Limpiar select de municipios
            var estado_municipio = (document.getElementById(
              "doctor"
            ).innerHTML = '<option value="">Seleccione</option>');

            for (es = 0; es < response.data.data.length; es++) {
              //Crea el elemento <option> dentro del select municipio
              var itemOption = document.createElement("option");

              //Contenido de los <option> del select municipios
              var txt_doctor = document.createTextNode(
                response.data.data[es].nombres +
                  " " + " C.I -" +
                response.data.data[es].n_documento
              );
              var id_doctor = document.createTextNode(
                response.data.data[es].id_doctor
              );

              //Crear atributo value para los elemento option
              var attValue = document.createAttribute("value");
              attValue.value = response.data.data[es].id_doctor;
              itemOption.setAttributeNode(attValue);

              //Añadir contenido a los <option> creados
              itemOption.appendChild(txt_doctor);

              document.getElementById("doctor").appendChild(itemOption);
            }
          }
        })
        .fail(function () {
          console.log("error");
        });
    });
  });
});

$(document).ready(function () {
  $("#fecha_cita").on("change", function () {
    document.getElementById("cont-loader").removeAttribute("style");
    var fecha_seleccionada = $(this).val();
    var doctor_seleccionado = document.getElementById("doctor").value;
    let contenedor_citas_disponibles = document.getElementById(
      "contenedor_citas_disponibles"
    );
    let citas_disponibles = document.getElementById("citas_disponibles");
    let contenedor_estatus_observacion = document.getElementById(
      "contenedor_estatus_observacion"
    );
    $.ajax({
      url: "index.php?page=obtenerCitasDisponibles",
      type: "post",
      dataType: "json",
      data: {
        fecha_seleccionada: fecha_seleccionada,
        doctor_seleccionado: doctor_seleccionado,
      },
    })
      .done(function (response) {
        if (response.data.success == true) {
          // Lógica para manejar la respuesta exitosa

          document.getElementById("citas_disponibles").innerHTML =
            response.data.citas_disponibles;
          if (response.data.citas_disponibles == 0) {
            document
              .getElementById("citas_disponibles")
              .setAttribute("class", "btn btn-danger");
          } else {
            document
              .getElementById("citas_disponibles")
              .setAttribute("class", "btn btn-success");
          }

          document
            .getElementById("cont-loader")
            .setAttribute("style", "display:none;");
          contenedor_citas_disponibles.removeAttribute("style");
          contenedor_estatus_observacion.removeAttribute("style");
          document
            .getElementById("cont-loader")
            .setAttribute("style", "display:none;");
        }
      })
      .fail(function () {
        console.log("Error en la solicitud AJAX");
      });
  });
});

$(document).ready(function () {
  $("#update_especialidad").on("change", function () {
    $("#update_especialidad option:selected").each(function () {
      elegido = $(this).val();
      $.ajax({
        url: "index.php?page=llenarSelectDoctorUpdate",
        type: "post",
        dataType: "json",
        data: {
          elegido: elegido,
        },
      })
        .done(function (response) {
          if (response.data.success == true) {
            //Limpiar select de municipios
            var select_doctor = (document.getElementById(
              "update_doctor"
            ).innerHTML = '<option value="">Seleccione</option>');

            for (es = 0; es < response.data.data.length; es++) {
              //Crea el elemento <option> dentro del select municipio
              var itemOption = document.createElement("option");

              //Contenido de los <option> del select municipios
              var doctor = document.createTextNode(
                response.data.data[es].nombres +
                  " " +
                  response.data.data[es].apellidos +
                  " C.I -" +
                  response.data.data[es].n_documento +
                  " - " +
                  response.data.data[es].dias_trabajo
              );
              var id_doctor = document.createTextNode(
                response.data.data[es].id_doctor
              );

              //Crear atributo value para los elemento option
              var attValue = document.createAttribute("value");
              attValue.value = response.data.data[es].id_doctor;
              itemOption.setAttributeNode(attValue);

              //Añadir contenido a los <option> creados
              itemOption.appendChild(doctor);

              document.getElementById("update_doctor").appendChild(itemOption);
            }
          }
        })
        .fail(function () {
          console.log("error");
        });
    });
  });
});



/*------------ listar Ver Cita ------------------*/
function listarVer(id){
  let id_cita = id;

   $.ajax({
        url: "index.php?page=listarActualizacionCita",
        type: "post",
        dataType: "json",
        data: {
          id_cita: id_cita,
        },
      })
        .done(function (response) {
          
          let ob = document.getElementById('observacion_cita').innerHTML = response.data.observacion;
            console.log(ob);
          if (response.data.success == true) {
            $('#espe').text(response.data.nom_especialidad);
            $('#fecha').text(response.data.fecha_cita);
            $('#doct').text(response.data.Nom_doctor);
            $('#espe_green').hide();
            $('#espe_red').hide();
          
            if (response.data.estatus == 1) {
              $('#est').text('Pendiente');
              $('#espe_green').show();
            }else if (response.data.estatus == 0) {
              $('#est').text('Finalizado');
              $('#espe_red').show();
            }
            
            

            
            $('#tablaDatos tbody').empty();
            $('#dataModalLabel').text('Datos de la citas');
            response.data.datos_personas.forEach(function(D_persona) {
                // Agregar cada cédula como un nuevo <tr> en la tabla
                $('#tablaDatos tbody').append(
                  '<tr>' +
                      '<th style="background-color:#bfc1c3;">Nº documento</th>' +
                      '<th style="background-color:#bfc1c3;">Nombres/Apellidos</th>' +
                      '<th style="background-color:#bfc1c3;">Telefono</th>' +
                      '<th style="background-color:#bfc1c3;">Sexo</th>' +
                      '<th style="background-color:#bfc1c3;">Edad</th>' +
                      '<th style="background-color:#bfc1c3;">Dirección</th>' +
                  '</tr>' +
                  '<tr id="trDatos">' +
                      '<td id="n_doc">'+ D_persona.cedula +'</td>' +
                      '<td id="nom_ape">'+ D_persona.nombre +'</td>' +
                      '<td id="tlf">'+  D_persona.telefono +'</td>' +
                      '<td id="sex">'+ D_persona.sexo +'</td>' +
                      '<td id="edad">'+ D_persona.edad +'</td>' +
                      '<td id="direcc">'+ D_persona.direccion +'</td>' +
                  '</tr>'
                );
            });
            //$('#tablaDatos').empty();
            $("#dataModal").modal("show");
          } else {
            Swal.fire({
              icon: "danger",
              confirmButtonColor: "#3085d6",
              title: response.data.message,
              text: response.data.info,
            });
          }
        })
        .fail(function (e) {
          console.log(e);
        });
  //alert('id de la cita para ver' + id_cita);
}


/* -------------- Listar datos para actualización ------------------ */
  function listarModificacionCita(id) {
    let id_cita = id;
    //console.log(id_cita);
     $.ajax({
        url: "index.php?page=listarActualizacionCita",
        type: "post",
        dataType: "json",
        data: {
          id_cita: id_cita,
        },
      })
        .done(function (response) {
          
          if (response.data.success == true) {
           document.getElementById('observacion_cita_update').value = response.data.observacion;
           document.getElementById('id_cita').value = response.data.id_cita;
           
            
            $('#tabla_datosPersona tbody').empty();
            $('#txt-doc').empty();
            response.data.datos_personas.forEach(function(D_persona) {
                // Agregar cada cédula como un nuevo <tr> en la tabla
                $('#tabla_datosPersona tbody').append(
                  '<tr id="trDatos">' +
                      '<td id="n_doc">'+ D_persona.cedula +'</td>' +
                      '<td id="nom_ape">'+ D_persona.nombre +'</td>' +
                      '<td id="tlf">'+  D_persona.telefono +'</td>' +
                      '<td id="sex">'+ D_persona.sexo +'</td>' +
                      '<td id="edad">'+ D_persona.edad +'</td>' +
                      '<td id="direcc">'+ D_persona.direccion +'</td>' +
                  '</tr>'
                );
            });
            //console.log(response.data.id_especialidad);
            //document.getElementById('txt-esp').value = response.data.id_especialidad;
            $('#txt-esp').val(response.data.nom_especialidad);
            $('#id-esp').val(response.data.id_especialidad);
            response.data.select_doctor.forEach(function(doc){
              $('#txt-doc').append(
                  '<option value=' + doc.id_doctor + '>' + 'Dr(a). ' + doc.nombres + '.  ' + doc.tipo_documento + '-' + doc.n_documento + '</option>'
                );
              //$('#txt-doc').val();
            });
            document.getElementById('txt-doc').value = response.data.id_doctor;              
            $('#fech_cita').val(response.data.fecha_cita);
            $('#observacion_cita').val(response.data.observacion);
            document.getElementById('observacion_cita').value = response.data.observacion;
            $('#modalModificarCitas').modal('show');
          } else {
            Swal.fire({
              icon: "danger",
              confirmButtonColor: "#3085d6",
              title: response.data.message,
              text: response.data.info,
            });
          }
        })
        .fail(function (e) {
          console.log(e);
        });
    //alert('id de la cita para actualizar' + id_cita);
  }


/* -------------- Modificar Cita ------------------ */
var modificar_cita;
if ((modificar_cita = document.getElementById("modificar_cita"))) {
  modificar_cita.addEventListener("click", modificarCita, false);

  function modificarCita() {
    let id_cita = document.getElementById("id_cita").value;
    let id_persona = document.getElementById("id_persona").value;
    let id_doctor = document.getElementById("txt-doc").value;
    let fecha_cita = document.getElementById("fech_cita").value;
    let observacion = document.getElementById("observacion_cita_update").value;
    let id_especialidad = document.getElementById("id-esp").value;

    $.ajax({
      url: "index.php?page=modificarCita",
      type: "post",
      dataType: "json",
      data: {
        id_cita: id_cita,
        id_persona: id_persona,
        id_doctor: id_doctor,
        fecha_cita: fecha_cita,
        observacion: observacion,
        id_especialidad: id_especialidad,
        
      },
    })
      .done(function (response) {
        if (response.data.success == true) {
          document.getElementById("formModificarCita").reset();

          $("#modalModificarCitas").modal("hide");

          Swal.fire({
            icon: "success",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });
          
          $("#tabla_citas").DataTable().ajax.reload();
        } else {
          Swal.fire({
            icon: "danger",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });
        }
      })
      .fail(function () {
        console.log("error");
      });

  }

}

/* -------------- Agregar medicamentos ------------------ */
let agregar_medicamento = document.getElementById("agregar_medicamento");
if (agregar_medicamento) {
  
  agregar_medicamento.addEventListener("click", agregarMedicamentos, false);

  function agregarMedicamentos() {
    let nombre_medicamento = document.getElementById("nombre_medicamento").value;
    let id_presentacion = document.getElementById("presentacion").value;
    let id_categoria = document.getElementById("categoria").value;

    $.ajax({
      url: "index.php?page=registrarMedicamento",
      type: "post",
      dataType: "json",
      data: {
        nombre_medicamento: nombre_medicamento,
        id_categoria: id_categoria,
        id_presentacion: id_presentacion,
      },
      
    })
      .done(function (response) {
        if (response.data.success == true) {
          document.getElementById("formRegistrarMedicamentos").reset();

          $("#modalAgregarMedicamentos").modal("hide");

          Swal.fire({
            icon: "success",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });

          $("#tbl_medicamentos").DataTable().ajax.reload();
        } else {
          Swal.fire({
            icon: "error",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });
        }
      })
      .fail(function () {
        console.log("error");
      });
  }

}

  

  /* -------------- Agregar motivo ------------------ */

  let agregar_motivo = document.getElementById('agregar_motivo');
  if(agregar_motivo) {

    agregar_motivo.addEventListener('click', agregarMotivo, false)

    function agregarMotivo() {
      let motivo = document.getElementById("motivo").value;
      let especialidad_motivo = document.getElementById("especialidad_motivo").value;
      $.ajax({
        url: "index.php?page=registrarMotivo",
        type: "post",
        dataType: "json",
        data: {
          motivo: motivo,
          especialidad_motivo: especialidad_motivo,
        },
        
      })
        .done(function (response) {
          if (response.data.success == true) {
            document.getElementById("formRegistrarMotivo").reset();
            $("#modalAgregarMotivo").modal("hide");
  
            Swal.fire({
              icon: "success",
              confirmButtonColor: "#3085d6",
              title: response.data.message,
              text: response.data.info,
            });
  
            $("#tbl_motivo").DataTable().ajax.reload();
          } else {
            Swal.fire({
              icon: "error",
              confirmButtonColor: "#3085d6",
              title: response.data.message,
              text: response.data.info,
            });
          }
        })
        .fail(function () {
          console.log("error");
        });
    }
  

  }
  
/*-------------------- Actualizar Medicamentos -------------------*/


function listarDatosMedicamento(id) {
  let id_medicamento = id;

  $.ajax({
    url: "index.php?page=consultarMedicamento",
    type: "post",
    dataType: "json",
    data: {
      id_medicamento: id_medicamento,
    },
  })
    .done(function (response) {
      if (response.data.success == true) {
        document.getElementById('r_medicamento_update').innerHTML = response.data.id_presentacion_medicamento;
        document.getElementById('presentacion_update').innerHTML  = response.data.id_presentacion;

        $("#modalActualizarMedicamentos").modal("show");
      } else {
       
      }
    })
    .fail(function () {
      console.log("Error en la solicitud AJAX.");
    });
}




function listarDatosPersona(id) {
  let id_persona = id;

  $.ajax({
    url: "index.php?page=listarDatosUpdate",
    type: "post",
    dataType: "json",
    data: {
      id_persona: id_persona,
    },
  })
    .done(function (response) {
      if (response.data.success == true) {
        document.getElementById("id_persona").value = response.data.id_persona;
        document.getElementById("update_tipo_documento").value =
          response.data.tipo_documento;
        document.getElementById("update_n_documento").value =
          response.data.n_documento;
        document.getElementById("update_p_nombre").value   = response.data.p_nombre;
        document.getElementById("update_s_nombre").value   = response.data.s_nombre;
        document.getElementById("update_p_apellido").value = response.data.p_apellido;
        document.getElementById("update_s_apellido").value = response.data.s_apellido;
        document.getElementById("update_sexo").value = response.data.sexo;
        document.getElementById("update_telefono").value =
          response.data.telefono;
        document.getElementById("update_correo").value = response.data.correo;
          response.data.parroquia;
        document.getElementById("update_fecha_nac").value =
          response.data.fecha_nacimiento;
        document.getElementById("update_direccion").value =
          response.data.direccion;

        $("#modalActualizarPersonas").modal("show");
      } else {
        console.log("No se encontraron datos o la respuesta no es exitosa.");
      }
    })
    .fail(function () {
      console.log("Error en la solicitud AJAX.");
    });
}

$(document).ready(function () {
  $("#tbl_personas").DataTable({
    order: [[0, "DESC"]],
    procesing: true,
    serverSide: true,
    ajax: "index.php?page=listarPersonas",    
    pageLength: 10,
    columnDefs: [
      {
        orderable: false,
        targets: 2,
        render: function (data, type, row, meta) {
          let botones =
            `<a class="btn btn-primary btn-sm" title="Ver jornada" href="?page=verPersona&amp;id=` + 
            row[2] + 
            `"><i class="fas fa-eye"></i></a> 
                  &nbsp;
    
                   <button type="button" class="btn btn-warning btn-sm"  onclick="listarDatosPersona(` +
            row[2] +
            `)"><i class="fas fa-edit"></i></button>&nbsp;

     `;
          return botones;
        },
      },
    ],
    dom: "Bfrtip",
    language: {
      decimal: "",
      emptyTable: "No hay información",
      info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
      infoFiltered: "(Filtrado de _MAX_ total entradas)",
      infoPostFix: "",
      thousands: ",",
      lengthMenu: "Mostrar _MENU_ Entradas",
      loadingRecords: "Cargando...",
      processing: "Procesando...",
      search: "Buscar:",
      zeroRecords: "Sin resultados encontrados",
      paginate: {
        first: "Primero",
        last: "Ultimo",
        next: "Siguiente",
        previous: "Anterior",
      },
    },
  });
});

const modificar_persona = document.getElementById('modificar_persona')
if( modificar_persona){

  modificar_persona.addEventListener('click', modificarPersona, false);

  function modificarPersona() {

    let id_persona        = document.getElementById("id_persona").value;
    let tipo_documento    = document.getElementById("update_tipo_documento").value;
    let n_documento       = document.getElementById("update_n_documento").value;
    let update_p_nombre   = document.getElementById("update_p_nombre").value;
    let update_s_nombre   = document.getElementById("update_s_nombre").value;
    let update_p_apellido = document.getElementById("update_p_apellido").value;
    let update_s_apellido = document.getElementById("update_s_apellido").value;
    let sexo              = document.getElementById("update_sexo").value;
    let fecha_nac         = document.getElementById("update_fecha_nac").value;
    let telefono          = document.getElementById("update_telefono").value;
    let correo            = document.getElementById("update_correo").value;
    let direccion         = document.getElementById("update_direccion").value;
    
   
    $.ajax({
      url: "index.php?page=modificarPersona",
      type: "post",
      dataType: "json",
      data: {
        id_persona: id_persona,
        tipo_documento: tipo_documento,
        n_documento: n_documento,
        p_nombre: update_p_nombre,
        s_nombre: update_s_nombre,
        p_apellido: update_p_apellido,
        s_apellido: update_s_apellido,
        sexo: sexo,
        fecha_nac: fecha_nac,
        telefono: telefono,
        direccion: direccion,
        correo: correo,
      },
    })
      .done(function (response) {
        if (response.data.success) {
          $("#formActualizarPersonas")[0].reset();
          $("#modalActualizarPersonas").modal("hide");
          $("#tbl_personas").DataTable().ajax.reload();
  
          Swal.fire({
            icon: "success",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });
        } else {
          Swal.fire({
            icon: "error",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });
        }
      })
      .fail(function () {
        console.log("error");
      });
  }
  

}

function VerDatosPersona(id) {
  let id_persona = id;

  $.ajax({
    url: "index.php?page=verDatosPersona",
    type: "post",
    dataType: "json",
    data: {
      id_persona: id_persona,
    },
  })
    .done(function (response) {
      if (response.data.success == true) {
        document.getElementById("ver_nombres_apellidos").innerHTML =
          response.data.nombres + " " + response.data.apellidos;
        document.getElementById("ver_n_documento").innerHTML =
          response.data.tipo_documento + "-" + response.data.n_documento;
        document.getElementById("ver_fecha_nacimiento").innerHTML =
          response.data.fecha_nacimiento;
        document.getElementById("ver_telefono").innerHTML =
          response.data.telefono;
        document.getElementById("ver_correo").innerHTML = response.data.correo;
        document.getElementById("ver_sexo").innerHTML = response.data.sexo;
        document.getElementById("ver_direccion").innerHTML =
          response.data.nombre_estado +
          ", Municipio " +
          response.data.nombre_municipio +
          ", Parroquia " +
          response.data.nombre_parroquia;

        $("#modalVerPersona").modal("show");
      } else {
        console.log("No se encontraron datos o la respuesta no es exitosa.");
      }
    })
    .fail(function () {
      console.log("Error en la solicitud AJAX.");
    });
}


/* --------------  Consultar Persona ------------------ */

let consultar_persona;
if(consultar_persona = document.getElementById("consultar_persona")){
 
consultar_persona.addEventListener("click", consultarPersona, false);

function consultarPersona() {
  let n_documento_persona = document.getElementById(
    "n_documento_persona"
  ).value;
 
  //console.log(n_documento_persona);

  let contenedor_formulario_persona = document.getElementById(
    "Contenedor_formulario_persona"
  );
  let contenedor_datos_persona = document.getElementById(
    "contenedor_datos_persona"
  );
  let contenedor_buscar_persona = document.getElementById(
    "contenedor_buscar_persona"
  );
  let id_persona = document.getElementById("id_persona");

  $.ajax({
    url: "index.php?page=consultarPersona",
    type: "post",
    dataType: "json",
    data: {
      n_documento_persona: n_documento_persona,
    },
  })
    .done(function (response) {
      //console.log(response);
      if (response.data.success == true) {
        document.getElementById("n_documento").innerHTML =
          response.data.n_documento_persona;
        document.getElementById("nombres_apellidos_persona").innerHTML =
          response.data.nombres_persona;
        document.getElementById("sexo_persona").innerHTML =
          response.data.sexo_persona;
        document.getElementById("tlf_persona").innerHTML =
          response.data.tlf_persona;
        document.getElementById("direccion_persona").innerHTML = response.data.direccion
        document.getElementById("ID").setAttribute("value", response.data.id_persona);
        document.getElementById("edad").innerHTML = response.data.edad
        contenedor_datos_persona.removeAttribute("style");
        Swal.fire({
          icon: "success",
          title: response.data.message,
          confirmButtonColor: "#0d6efd",
          text: response.data.info,
        });
      } else if (response.data.success == false) {
        contenedor_datos_persona.setAttribute("style", "display: none;");
          // Eliminar el valor del campo ID
          document.getElementById("ID").setAttribute("value", "");

        Swal.fire({
          icon: "warning",
          confirmButtonColor: "#3085d6",
          title: response.data.message,
          text: response.data.info,
        });
      }
    })
    .fail(function (error) {
      console.log(error);
    });
  }
  
}

/*-------------------------------------------------*/

document.addEventListener("DOMContentLoaded", function() {
    // Obtener el botón por su ID
    const botonConsulta = document.getElementById("citaPersona_consulta");
    const inputIds = ['p_nombre', 's_nombre', 'p_apellido', 's_apellido', 'sexoMasculino', 
        'sexoFemenino', 'fechaNacimiento', 'numTelf', 'correo', 'direccion_c'];

    botonConsulta.addEventListener("click", function() {
        // Obtener el valor de la cédula cada vez que se hace clic en el botón
        const Ced = document.getElementById('cedu').value;

           if (Ced == '') {
                Swal.fire({
                  icon: "warning",
                  title: '¡Cuidado!',
                  confirmButtonColor: "#3085d6",
                  text: 'Campo cedula vacio',
                });
           }else{
                 $.ajax({
                   url: "index.php?page=consultarPersonaUsuario",
                   type: "post",
                   dataType: "json",
                   data: {
                     n_documento_persona: Ced,
                   },
                 })
               .done(function (response) {
                if (response.data.success == true) {
                    Swal.fire({
                      icon: "success",
                      title: response.data.message,
                      confirmButtonColor: "#0d6efd",
                      text: response.data.info,
                    });

                    $('#p_nombre').val(response.data.p_nombre);
                    $('#s_nombre').val(response.data.s_nombre);
                    $('#p_apellido').val(response.data.p_apellido);
                    $('#s_apellido').val(response.data.s_apellido);
                    if (response.data.sexo == 'M'){
                        $('#sexoFemenino').prop('checked', false);
                        $('#sexoMasculino').prop('checked', true);
                    }else if (response.data.sexo == 'F'){
                        $('#sexoMasculino').prop('checked', false);
                        $('#sexoFemenino').prop('checked', true);
                    };
                    $('#fechaNacimiento').val(response.data.fecha_nac);
                    $('#numTelf').val(response.data.telefono);
                    $('#correo').val(response.data.correo);
                    $('#direccion_c').val(response.data.direccion);
                    inputIds.forEach(function(id) {
                        $("#" + id).prop("disabled", true);
                    });
                    /*$('s_nombre').text();
                    $('s_nombre').text();
                    $('s_nombre').text();*/          
                }else{
                    $('#p_nombre').val('');
                    $('#s_nombre').val('');
                    $('#p_apellido').val('');
                    $('#s_apellido').val('');

                    $('#sexoMasculino').val('');
                    $('#sexoFemenino').val('');

                    $('#fechaNacimiento').val('');
                    $('#numTelf').val('');
                    $('#correo').val('');
                    $('#direccion_c').val('');
                    $('#sexoMasculino').prop('checked', false);
                    $('#sexoFemenino').prop('checked', false);
                    Swal.fire({
                      icon: "warning",
                      confirmButtonColor: "#3085d6",
                      title: response.data.message,
                      text: response.data.info,
                    });
                    inputIds.forEach(function(id) {
                        $("#" + id).prop("disabled", false);
                    });
                }        
               })
               .fail(function (error) {
                 console.log(error);
               });
           }
    });
});


/* --------------  Consultar Persona / Modulo consultas ------------------ */

let consultar_persona_c;


if(consultar_persona_c = document.getElementById("consultar_persona_c")){

consultar_persona_c.addEventListener("click", consultarPersonaC, false);

function consultarPersonaC() {
 let n_documento_persona = document.getElementById(
   "n_documento_persona"
 ).value;

 //console.log(n_documento_persona);

 let contenedor_formulario_persona = document.getElementById(
   "Contenedor_formulario_persona"
 );
 let contenedor_datos_persona = document.getElementById(
   "contenedor_datos_persona"
 );
 let contenedor_buscar_persona = document.getElementById(
   "contenedor_buscar_persona"
 );
 let id_persona = document.getElementById("id_persona");

 let contenedor_cita = document.getElementById("contenedor_cita");

 $.ajax({
   url: "index.php?page=consultarPersonaC",
   type: "post",
   dataType: "json",
   data: {
     n_documento_persona: n_documento_persona,
   },
 })
   .done(function (response) {
     if (response.data.success == true) {
       //Datos del paciente
       document.getElementById("n_documento").innerHTML =
         response.data.n_documento_persona;
       document.getElementById("nombres_apellidos_persona").innerHTML =
         response.data.nombres_persona;
       document.getElementById("sexo_persona").innerHTML =
         response.data.sexo_persona;
       document.getElementById("tlf_persona").innerHTML =
         response.data.tlf_persona;
       document.getElementById("direccion_persona").innerHTML = response.data.direccion;
       document.getElementById("ID").setAttribute("value", response.data.id_persona);
       document.getElementById("edad").innerHTML = response.data.edad
       contenedor_datos_persona.removeAttribute("style");


       //limpiar datos de la cita agendada

       document.getElementById("especialidad_cita").innerHTML ='';
       document.getElementById("especialista_cita").innerHTML ='';
       document.getElementById("observacion_cita").innerHTML =  
       document.getElementById("fecha_cita").innerHTML ='';
       document.getElementById("estatus_cita").innerHTML ='';
       document.getElementById("id_cita_agendada").setAttribute("value", '');

       contenedor_cita.setAttribute("style", 'display:none;');

       if(response.data.estatus  == 1) {

         document.getElementById("especialidad_cita").innerHTML = response.data.especialidad;
         document.getElementById("especialista_cita").innerHTML =  response.data.especialista;
         document.getElementById("observacion_cita").innerHTML =  response.data.observacion;
         document.getElementById("fecha_cita").innerHTML =  `<span class="badge bg-success"> <i class="bi bi-calendar"></i> ${response.data.fecha} </span>`;
         document.getElementById("estatus_cita").innerHTML = `<span class="badge bg-success">Pendiente</span>`;
         document.getElementById("id_cita_agendada").setAttribute("value", response.data.id_cita);
         document.getElementById("validar_fecha").setAttribute("value", response.data.validar_fecha);
        
         contenedor_cita.removeAttribute("style");

       }

       Swal.fire({
         icon: "success",
         title: response.data.message,
         confirmButtonColor: "#0d6efd",
         text: response.data.info,
       });
     } else {
       contenedor_datos_persona.setAttribute("style", "display: none;");
         // Eliminar el valor del campo ID
         document.getElementById("ID").setAttribute("value", "");

       Swal.fire({
         icon: "warning",
         confirmButtonColor: "#3085d6",
         title: response.data.message,
         text: response.data.info,
       });
     }
   })
   .fail(function (error) {
     console.log(error);
   });
 }
 
}



/* -------------- Consultar Persona ------------------ */

let buscar_representante;
if (buscar_representante = document.getElementById("buscar_representante")) {
 
  buscar_representante.addEventListener("click", consultarRepresentante, false);

  function consultarRepresentante() {
    let documento_representante = document.getElementById("documento_representante").value;

    let contenedor_datos_representante = document.getElementById("contenedor_datos_representante");
    let datos_representante = document.getElementById("datos_representante");
    let id_representante = document.getElementById("id_representante");
    let id_persona_r = document.getElementById("id_persona_r");

    $.ajax({
      url: "index.php?page=consultarRepresentante",
      type: "post",
      dataType: "json",
      data: {
        documento_representante: documento_representante,
      },
    })
      .done(function (response) {
        if (response.data.success) {
          document.getElementById("documento_r").textContent = response.data.documento_representante;
          document.getElementById("nombres_representante").textContent = response.data.nombres;
          document.getElementById("apellidos_representante").textContent = response.data.apellidos;
          document.getElementById("parentesco_representante").innerHTML = 
            response.data.parentesco ? response.data.parentesco :
            `<select class="form-control" id="parentesco" name="parentesco">
                 <option value="">Seleccione</option>
                 <option value="padre">Padre</option>
                 <option value="madre">Madre</option>
                 <option value="otro">Otro</option>
             </select>`;
        document.getElementById("id_representante").setAttribute("value", response.data.id_representante);
        document.getElementById("id_persona_r").setAttribute("value", response.data.id_persona_r);
        contenedor_datos_representante.removeAttribute("style");
        datos_representante.setAttribute("style", "display: none;");
        Swal.fire({
          icon: "success",
          title: response.data.message,
          confirmButtonColor: "#0d6efd",
          text: response.data.info,
        });
      } else {
        contenedor_datos_representante.setAttribute("style", "display: none;");
          // Eliminar el valor del campo ID
        datos_representante.removeAttribute("style");
        buscar_representante.removeAttribute("style")
        document.getElementById("id_representante").setAttribute("value", "");
        document.getElementById("documento_representante").setAttribute("value", "");

        Swal.fire({
          icon: "warning",
          confirmButtonColor: "#3085d6",
          title: response.data.message,
          text: response.data.info,
        });
      }
    })
    .fail(function (error) {
      console.log(error);
    });
  }
  
}






let presionArterialInput = document.getElementById("presion_arterial");
 if(presionArterialInput) {
  presionArterialInput.addEventListener("blur", function () {
    const presion = presionArterialInput.value;
    console.log(presion);

    const presionRegex = /^\d{1,3}\/\d{1,3}$|^$/;

    if (!presionRegex.test(presion)) {
      Swal.fire({
        icon: 'error',
        title: 'Presión Arterial inválida',
        text: 'Por favor, ingrese la presión arterial en el formato correcto (ej: 120/80).'
      });
    } else {
      // Resto de tu código
    }
  });
}


let alturaInput = document.getElementById("altura");
if (alturaInput) {
  alturaInput.addEventListener("blur", function() {
    const altura = alturaInput.value;
    console.log(altura);

    // Expresión regular para validar alturas entre 1.00 y 2.00 metros
    const alturaRegex = /^1\.\d{2}$|^2\.00$|^$/;

    if (!alturaRegex.test(altura)) {
      Swal.fire({
        icon: 'error',
        title: 'Altura inválida',
        text: 'Por favor, ingrese la altura en metros con dos decimales (ej: 1.75).'
      });
    } else {
      // Resto de tu código
    }
  });
}



let pesoInput = document.getElementById("peso");
if (pesoInput) {
  pesoInput.addEventListener("blur", function() {
    const peso = pesoInput.value;
    console.log(peso);

    const pesoRegex =  /^[1-9][0-9]{0,2}$|^$/;

    if (!pesoRegex.test(peso)) {
      Swal.fire({
        icon: 'error',
        title: 'Peso inválido',
        text: 'Por favor, ingrese un peso válido (ej: 75 kg).'
      });
    } else {
      // Resto de tu código
    }
  });
}

  


if (document.getElementById("agregar_consulta")) {document
  .getElementById("agregar_consulta")
  .addEventListener("click", agregarConsulta, false);

function agregarConsulta() {
  // Datos de la consulta
  let id_persona           = document.getElementById("ID").value;
  let persona              = document.getElementById("nombres_apellidos_persona");
  let nombre_persona       = persona.textContent;
  let edad                 = document.getElementById("edad").value;
  let tipo_consulta        = document.getElementById("tipo_consulta").value;
  let opcion_consulta      = document.getElementById("tipo_consulta");
  let consulta             = opcion_consulta.options[opcion_consulta.selectedIndex].text;
  let diagnostico          = document.getElementById("diagnostico").value;
  let peso                 = document.getElementById("peso").value;
  let altura               = document.getElementById("altura").value;
  let presion_arterial     = document.getElementById("presion_arterial").value;

  let id_cita_agendada     = document.getElementById("id_cita_agendada").value
  let id_especialidad      = document.getElementById("id_especialidad_consulta").value;
  let id_especialista      = document.getElementById("id_especialista_consulta").value;
  
  if(id_persona == ""){

    Swal.fire({
      icon: 'error',
      title: 'Atención',
      confirmButtonColor: '#0d6efd',
      text: 'Debe seleccionar un paciente'
  });

  return false;
  }
  
  
  const pesoRegex = /^([1-9][0-9]{0,2}|100)?$/;
  
  if (!pesoRegex.test(peso)) {
    Swal.fire({
      icon: 'error',
      title: 'Peso inválido',
      text: 'Por favor, ingrese un valor numérico de hasta 3 dígitos (ej: 75 kg).'
    });
    return false;
  }
  
 


 if(id_persona == ""  || tipo_consulta == "" || diagnostico == ""){

  Swal.fire({
    icon: 'error',
    title: 'Todos los campos son obligatorios',
    text: 'Por favor, llene todos los campos.'
  });

  return false;

 }

 


  

  // Datos del recipe
  let instrucciones = document.getElementById("instrucciones").value;

  const tablaMedicamentos = document.getElementById('multiples_medicamentos');
  var datosMedicamentos = obtenerDatosTabla(tablaMedicamentos);

  const listaMedicamentos = datosMedicamentos.map(medicamento => {
    // Asegúrate de que `medicamento` sea un array
    return `<li>${medicamento.join(' ')}</li>`;
  }).join('');
const confirmMessage = `
<ul style="text-align: left;">
<li><strong>Persona:</strong> ${nombre_persona}</li>
<li><strong>Tipo de Consulta:</strong> ${consulta}</li>
<li><strong>Peso:</strong> ${peso? peso:'Sin información'}</li>
<li><strong>Altura:</strong> ${altura? altura:'Sin información'}</li>
<li><strong>Presión arterial:</strong> ${presion_arterial? presion_arterial:'Sin información'}</li>
<li><strong>Diagnóstico:</strong> ${diagnostico}</li>
</ul>

<p><strong>Medicamentos recetados:</strong></p>
<ul>
  ${listaMedicamentos? listaMedicamentos: '<li>Sin información</li>'}
</ul>

<p><strong>Instrucciones adicionales:</strong></p>
<ul>
<li>${instrucciones? instrucciones:'Sin información'}</li>
</ul>
`;




  Swal.fire({
    title: "Estas seguro de guardar los datos?",
    html: confirmMessage, // Use HTML for better formatting
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, confirmar!"
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "index.php?page=registrarConsulta",
        type: "post",
        dataType: "json",
        data: {
          id_persona: id_persona,
          edad: edad,
          tipo_consulta: tipo_consulta,
          diagnostico: diagnostico,
          peso: peso,
          altura: altura,
          presion_arterial: presion_arterial,
          instrucciones:instrucciones,
          id_cita_agendada: id_cita_agendada,
          id_especialidad: id_especialidad,
          id_especialista: id_especialista
        },
      })
        .done(function (response) {
          if (response.data.success == true) {
            document.getElementById("formRegistrarConsultas").reset();
            let contenedor = document.getElementById("contenedor_datos_medicamentos");
            contenedor.setAttribute("style", "display: none;");
  
            //$("#modalAgregarConsulta").modal("hide");

           gestionarModal('modalAgregarConsulta', 'ocultar');
  
            Swal.fire({
              icon: "success",
              confirmButtonColor: "#3085d6",
              title: response.data.message,
              text: response.data.info,
            });
            
  
            $("#tbl_consultas").DataTable().ajax.reload();
          } else {
            Swal.fire({
              icon: "error",
              confirmButtonColor: "#3085d6",
              title: response.data.message,
              text: response.data.info,
            });
          }
        })
        .fail(function () {
          console.log("error");
        });
    }
  });

  
}
}


const frecuenciaInput = document.getElementById('frecuencia');



/* -------------- Recipes / Consultar Medicamento ------------------ */

const agregarMedicamentoButton = document.getElementById("agregar_medicamento_recipe");
if (agregarMedicamentoButton) {

  agregarMedicamentoButton.addEventListener("click", consultarMedicamento, false);

    function consultarMedicamento()
    {
        
        let id_medicamento                  = document.getElementById("medicamento").value;
        let dosis                           = document.getElementById("dosis").value;
        let unidad_medida                   = document.getElementById("unidad_medida").value;
        let frecuencia                      = document.getElementById("frecuencia").value;
        let cantidad                        = document.getElementById("cantidad_duracion").value;
        let intervalo                       = document.getElementById("intervalo").value;
        let contenedor_datos_medicamentos   = document.getElementById("contenedor_datos_medicamentos");
        let multiples_medicamentos          = document.getElementById("multiples_medicamentos");

        if(id_medicamento == "" || dosis == "" || unidad_medida == "" || frecuencia == "" || cantidad == "" || intervalo == ""){
          Swal.fire({
              icon: 'error',
              title: 'Atención',
              confirmButtonColor: '#0d6efd',
              text: 'Debe llenar todos los campos'
          });
          return;
      }

      if (isNaN(dosis) || dosis <= 0) {
          Swal.fire({
              icon: 'error',
              title: 'Atención',
              confirmButtonColor: '#0d6efd',
              text: 'La dosis debe ser un número mayor a 0'
          });
          return;
      }

      if (isNaN(frecuencia) || frecuencia <= 0) {
          Swal.fire({
              icon: 'error',
              title: 'Atención',
              confirmButtonColor: '#0d6efd',
              text: 'La frecuencia debe ser un número válido'
          });
          return;
      }

      if (isNaN(cantidad) || cantidad <= 0) {
          Swal.fire({
              icon: 'error',
              title: 'Atención',
              confirmButtonColor: '#0d6efd',
              text: 'La duración debe ser mayor que 0'
          });
          return false;
      }

      if (isNaN(cantidad) || cantidad <= 0) {
          Swal.fire({
              icon: 'error',
              title: 'Atención',
              confirmButtonColor: '#0d6efd',
              text: 'El intervalo debe ser mayor que 0'
          });
          return false;
      }
        $.ajax({
            url: "index.php?page=consultarMedicamento",
            type: 'post',
            dataType: 'json',
            data: {
                    id_medicamento : id_medicamento,
                    dosis: dosis,
                    unidad_medida : unidad_medida,
                    frecuencia: frecuencia,
                    cantidad : cantidad,
                    intervalo: intervalo,
            }
        })
        .done(function(response) {
            if (response.data.success == true) 
            {

                Swal.fire({
                    icon: 'success',
                    title: response.data.message,
                    confirmButtonColor: '#0d6efd',
                    text: response.data.info
                });

                contador = contador + 1;

                contenedor_datos_medicamentos.removeAttribute('style');
				
                let class_contenedor = "row contenedor_"+contador;
                let id_contenedor    = "contenedor_"+contador;
                let id_accion = "id_accion"+contador;

                let id_medicamento  = "id_medicamento_"+contador;
                let id_nombre       = "id_nombre_"+contador;
                let id_presentacion = "id_presentacion_"+contador;

                //Contenedor de los estudios
                var cont_elemento = document.createElement("tr");
                //cont_elemento.setAttribute("class", "table-success");
                cont_elemento.setAttribute("id", id_contenedor);
				        cont_elemento.setAttribute("style", "border: solid 1px #ccc; padding: 10px; background:#e2e3e5;");
                document.getElementById("multiples_medicamentos").appendChild(cont_elemento);



              //td que almacena el nombre del medicamento
              var td_medicamento = document.createElement("td")
              td_medicamento.setAttribute("id", id_nombre);
              td_medicamento.setAttribute("class", 'codigo_contable');
              td_medicamento.setAttribute("style", "border: solid 1px #ccc; padding: 10px;");
              cont_elemento.appendChild(td_medicamento);


              //td que almacena la presentacion
              var td_presentacion = document.createElement("td")
              td_presentacion.setAttribute("id", id_presentacion);
              td_presentacion.setAttribute("class", 'codigo_contable');
              td_presentacion.setAttribute("style", "border: solid 1px #ccc; padding: 10px;");
              cont_elemento.appendChild(td_presentacion);

              
                //Columna que almacena el boton borrar
                var td_accion_borrar = document.createElement("td")
                td_accion_borrar.setAttribute("id", id_accion);
				        td_accion_borrar.setAttribute("class", 'acciones');
				        td_accion_borrar.setAttribute("style", "border: solid 1px #ccc; text-align: center; padding: 10px;");
                cont_elemento.appendChild(td_accion_borrar);
                
                //Boton borrar
                var btn_delete = document.createElement("button")
                btn_delete.setAttribute("class","btn btn-danger btn-sm");
                btn_delete.setAttribute("title","Remover");
                btn_delete.setAttribute("type","button");
                btn_delete.setAttribute("onclick","removerMedicamento("+response.data.id_medicamento+")");
                btn_delete.setAttribute("style","background:#dc3545; color: #FFF;");
                td_accion_borrar.appendChild(btn_delete);

                

                //Icono del boton borrar
                var icono_btn_delete = document.createElement("i")
                icono_btn_delete.setAttribute("class","fas fa-trash");
                icono_btn_delete.setAttribute("data-id", "");
                btn_delete.appendChild(icono_btn_delete);

                
				       document.getElementById(id_nombre).innerHTML       = response.data.nombre_medicamento+' '+response.data.presentacion;

               if(response.data.dosis > 1) {
                document.getElementById(id_presentacion).innerHTML  = response.data.dosis+' '+response.data.unidad_medida+'s cada '+response.data.frecuencia+' horas por '+response.data.cantidad+' '+response.data.intervalo;

               }else{
                document.getElementById(id_presentacion).innerHTML  = response.data.dosis+' '+response.data.unidad_medida+' cada '+response.data.frecuencia+' horas por '+response.data.cantidad+' '+response.data.intervalo;
               }
			
            }
            else
            {
              Swal.fire({
                icon: 'error',
                title: response.data.message,
                confirmButtonColor: '#0d6efd',
                text: response.data.info
              });

                
            }
        })
        .fail(function() {
            console.log("error");
        });
    }

}


/* -------------- Citas / Remover estudio ------------------ */
function removerMedicamento(id)
{

let id_medicamento = id;

    let id_contenedor    = "contenedor_"+contador;

    $.ajax({
        url: "index.php?page=removerMedicamento",
        type: 'post',
        dataType: 'json',
        data: {
          
              id_medicamento : id_medicamento
        }
    })
    .done(function(response) {
        if (response.data.success == true) 
        {

          Swal.fire({
            icon: 'success',
            confirmButtonColor: '#3085d6',
            title: response.data.message,
            text:  response.data.info
          });

            let contenedor_padre = document.getElementById(""+id_contenedor+"");
    
            contenedor_padre.remove();

            contador = contador - 1;

            if(contador == 0)
            {
                document.getElementById("contenedor_datos_medicamentos").setAttribute('style', "display:none;");
            }
        }
        else
        {
    Swal.fire({
      icon: 'error',
      title: response.data.message,
      confirmButtonColor: '#0d6efd',
      text: response.data.info
    });
        }
    })
    .fail(function() {

        console.log("error");
    });

}


$('#medicamento').select2({
  dropdownParent: $('#modalAgregarConsulta')
});

$('#r_medicamento').select2({
  dropdownParent: $('#modalAgregarMedicamentos')
});

$('#tipo_consulta').select2({
  dropdownParent: $('#modalAgregarConsulta')
});

$('#especialidad_motivo').select2({
  dropdownParent: $('#modalAgregarMotivo')
});


$('#estado').select2({
  dropdownParent: $('#modalAgregarPersona')
});

$('#presentacion').select2({
  dropdownParent: $('#modalAgregarMedicamentos')
});

$('#categoria').select2({
  dropdownParent: $('#modalAgregarMedicamentos')
});








$(document).ready(function () {
  $("#update_especialidad").on("change", function () {
    $("#update_especialidad option:selected").each(function () {
      elegido = $(this).val();
      $.ajax({
        url: "index.php?page=llenarSelectDoctorUpdate",
        type: "post",
        dataType: "json",
        data: {
          elegido: elegido,
        },
      })
        .done(function (response) {
          if (response.data.success == true) {
            //Limpiar select de municipios
            var select_doctor = (document.getElementById(
              "update_doctor"
            ).innerHTML = '<option value="">Seleccione</option>');

            for (es = 0; es < response.data.data.length; es++) {
              //Crea el elemento <option> dentro del select municipio
              var itemOption = document.createElement("option");

              //Contenido de los <option> del select municipios
              var doctor = document.createTextNode(
                response.data.data[es].nombres +
                  " " +
                  response.data.data[es].apellidos +
                  " C.I -" +
                  response.data.data[es].n_documento +
                  " - " +
                  response.data.data[es].dias_trabajo
              );
              var id_doctor = document.createTextNode(
                response.data.data[es].id_doctor
              );

              //Crear atributo value para los elemento option
              var attValue = document.createAttribute("value");
              attValue.value = response.data.data[es].id_doctor;
              itemOption.setAttributeNode(attValue);

              //Añadir contenido a los <option> creados
              itemOption.appendChild(doctor);

              document.getElementById("update_doctor").appendChild(itemOption);
            }
          }
        })
        .fail(function () {
          console.log("error");
        });
    });
  });
});



/* -------------- Listar datos para actualización ------------------ */



/* -------------- Modificar Cita ------------------ */
var modificar_cita;
if ((modificar_cita = document.getElementById("modificar_cita"))) {
  modificar_cita.addEventListener("click", modificarCita, false);

  function modificarCita() {
    let id_cita = document.getElementById("update_id_cita").value;
    let id_paciente = document.getElementById("update_id_paciente_cita").value;
    let update_especialidad = document.getElementById(
      "update_especialidad"
    ).value;
    let update_doctor = document.getElementById("update_doctor").value;
    let update_fecha_cita = document.getElementById("update_fecha_cita").value;
    let update_estatus_cita = document.getElementById(
      "update_estatus_cita"
    ).value;
    let update_observacion_cita = document.getElementById(
      "update_observacion_cita"
    ).value;

    $.ajax({
      url: "index.php?page=modificarCita",
      type: "post",
      dataType: "json",
      data: {
        id_cita: id_cita,
        id_paciente: id_paciente,
        update_especialidad: update_especialidad,
        update_doctor: update_doctor,
        update_fecha_cita: update_fecha_cita,
        update_estatus_cita: update_estatus_cita,
        update_observacion_cita: update_observacion_cita,
      },
    })
      .done(function (response) {
        if (response.data.success == true) {
          document.getElementById("formActualizarCita").reset();

          $("#modalActualizarCita").modal("hide");

          Swal.fire({
            icon: "success",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });

          $("#tabla_citas").DataTable().ajax.reload();
        } else {
          Swal.fire({
            icon: "danger",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });
        }
      })
      .fail(function () {
        console.log("error");
      });
  }
}


/* -------------- Obtener datos para actualizar la consultas ------------------ */
function listarDatosConsulta(id) {
  let id_consulta = id;
  
  $.ajax({
    url: "index.php?page=listarDatosConsulta",
    type: "post",
    dataType: "json",
    data: {
      id_consulta: id_consulta,
    },
  })
    .done(function (response) {
      if (response.data.success == true) {
        document.getElementById("id_consulta_update").value =
          response.data.id_consulta;
        document.getElementById("nombres_persona").value =
          response.data.nombres_persona;
        document.getElementById("update_tipo_consulta").value =
          response.data.tipo_consulta;
        document.getElementById("update_peso").value =
          response.data.peso;
        document.getElementById("update_altura").value =
          response.data.altura;
        document.getElementById("update_presion_arterial").value =
          response.data.presion_arterial;
        document.getElementById("update_diagnostico").value =
          response.data.diagnostico;
          document.getElementById("id_consulta_update").value =
          response.data.id_consulta;
        

          if(response.data.receta_medicamentos.length < 1)
            {
              console.log(response.data.receta_medicamentos.length);
              document.getElementById("multiples_medicamentos_update").innerHTML =
              "<tr><th>Medicamento</th><th>tratamiento</th><th>Observación</th><th>Estatus</th><th>Acciones</th></tr><tr style='text-align:center; font-size: 17px; '><td colspan='5'>No hay medicamentos recetados</td></tr>";
            }else{
              console.log(response.data.receta_medicamentos.length);
              document.getElementById("multiples_medicamentos_update").innerHTML =
              "<tr><th>Medicamento</th><th>tratamiento</th><th>Observación</th><th>Estatus</th><th>Acciones</th></tr></tr>";
      
              response.data.receta_medicamentos.forEach(function (medicamento, index) {
                contador = contador + 1;
          
                //7document.getElementById("total_beneficiarios_view").innerHTML = contador;
          
                let class_contenedor = "row contenedor_" + medicamento.id_recipe_medicamento;
                let id_contenedor = "contenedor_" + medicamento.id_recipe_medicamento;
          
                let id_medicamento = "id_medicamento_" + medicamento.id_recipe_medicamento;
                let id_presentacion = "id_presentacion_" + medicamento.id_recipe_medicamento;
                let id_estatus = "id_estatus_" + medicamento.id_recipe_medicamento;
                let  id_observacion = "id_observacion_" + medicamento.id_recipe_medicamento;

                let id_boton_borrar = "id_boton_borrar_" + medicamento.id_recipe_medicamento;
                
                //Contenedor de los detalles agregados
                var cont_elemento = document.createElement("tr");
                cont_elemento.setAttribute("id", id_contenedor);
                cont_elemento.setAttribute("class", "contenedor_medicamento");
                cont_elemento.setAttribute(
                  "style",
                  "background:#e2e3e5; border:  solid 1px #ccc; text-align: center; padding: 10px;"
                );
                document
                  .getElementById("multiples_medicamentos_update")
                  .appendChild(cont_elemento);
          
                //td que almacena los nombres de las especies
                var td_medicamentos = document.createElement("td");
                td_medicamentos.setAttribute("id", id_medicamento);
                td_medicamentos.setAttribute("class", "ente");
                td_medicamentos.setAttribute(
                  "style",
                  "border: solid 1px #ccc; text-align: center; padding: 10px;"
                );
                cont_elemento.appendChild(td_medicamentos);
          
                //td que almacena que almacena las presentaciones de las especies
                var td_presentacion = document.createElement("td");
                td_presentacion.setAttribute("id", id_presentacion);
                td_presentacion.setAttribute("class", "cuenta_movimiento");
                td_presentacion.setAttribute(
                  "style",
                  "border: solid 1px #ccc; text-align: center; padding: 10px;"
                );
                cont_elemento.appendChild(td_presentacion);


                //td obersevacion
                var td_observacion = document.createElement("td");
                td_observacion.setAttribute("id", id_observacion);
                td_observacion.setAttribute("class", "estatus");
                td_observacion.setAttribute(
                  "style",
                  "border: solid 1px #ccc; text-align: center; padding: 10px;"
                );
                cont_elemento.appendChild(td_observacion);
                
          
                //td estatus
                var td_estatus = document.createElement("td");
                td_estatus.setAttribute("id", id_estatus);
                td_estatus.setAttribute("class", "estatus");
                td_estatus.setAttribute(
                  "style",
                  "border: solid 1px #ccc; text-align: center; padding: 10px;"
                );
                cont_elemento.appendChild(td_estatus);
          
                //Columna que almacena el boton borrar
                var td_accion_borrar = document.createElement("td");
                td_accion_borrar.setAttribute("id", id_boton_borrar);
                td_accion_borrar.setAttribute("class", "acciones");
                td_accion_borrar.setAttribute(
                  "style",
                  "border: solid 1px #ccc; text-align: center; padding: 10px;"
                );
                cont_elemento.appendChild(td_accion_borrar);
          
          
                // //Boton Modificar
                // var btn_update = document.createElement("button");
                // btn_update.setAttribute("class", "btn btn-warning btn-sm");
                // btn_update.setAttribute("title", "Modificar");
                // btn_update.setAttribute("type", "button");
                // btn_update.setAttribute(
                //   "onclick",
                //   "ModificarRecetaMedica(" + medicamento.id_recipe_medicamento + ")"
                // );
                // btn_update.setAttribute(
                //   "style",
                //   "background:#ffc107; color: #FFF; margin-left: 10px;"
                // );
                // td_accion_borrar.appendChild(btn_update);
          
                //Boton suspender
                var btn_suspender = document.createElement("button");
                btn_suspender.setAttribute("class", "btn btn-danger btn-sm");
                btn_suspender.setAttribute("title", "Suspender tratamiento");
                if(medicamento.estatus == 0)
                {
                  btn_suspender.setAttribute("disabled", "true");
                }
                btn_suspender.setAttribute("type", "button");
                btn_suspender.setAttribute(
                  "onclick",
                  "activarSuspension(" + medicamento.id_recipe_medicamento + ")"
                );
                btn_suspender.setAttribute(
                  "style",
                  "background: #bb2d3b; color: #FFF; margin-left: 10px;"
                );
                td_accion_borrar.appendChild(btn_suspender);
                
          
                // //Icono del boton modificar
                // var icono_btn_update = document.createElement("i");
                // icono_btn_update.setAttribute("class", "fas fa-edit");
                // icono_btn_update.setAttribute("data-id", "");
                // btn_update.appendChild(icono_btn_update);
          
                //Icono del boton suspender
                var icono_btn_suspender = document.createElement("i");
                icono_btn_suspender.setAttribute("class", "fas fa-ban");
                icono_btn_suspender.setAttribute("data-id", "");
                btn_suspender.appendChild(icono_btn_suspender);
          
                if(medicamento.dosis > 1 & medicamento.frecuencia > 1) {
                  document.getElementById(id_medicamento).innerHTML  = medicamento.nombre_medicamento+' '+medicamento.presentacion;
                  document.getElementById(id_presentacion).innerHTML = medicamento.dosis+' '+medicamento.unidad_medida+'s cada '+medicamento.frecuencia+'  horas por '+medicamento.duracion;
                  if(medicamento.estatus == 0){
                    document.getElementById(id_estatus).innerHTML = '<span class="badge bg-danger" style="color: white;">Suspendido</span>';
                    document.getElementById(id_observacion).innerHTML = medicamento.observacion_suspension;
                  }else{
                    document.getElementById(id_estatus).innerHTML = '<span class="badge bg-success" style="color: white;">habilitado</span>';
                    document.getElementById(id_observacion).innerHTML = "No hay observación";
                  }
                } else if (medicamento.dosis > 1 & medicamento.frecuencia == 1) {
                  document.getElementById(id_medicamento).innerHTML  = medicamento.nombre_medicamento+' '+medicamento.presentacion;
                  document.getElementById(id_presentacion).innerHTML = medicamento.dosis+' '+medicamento.unidad_medida+'s cada '+medicamento.frecuencia+'  hora por '+medicamento.duracion;  
                  if(medicamento.estatus == 0){
                    document.getElementById(id_estatus).innerHTML = '<span class="badge bg-danger" style="color: white;">Suspendido</span>';
                    document.getElementById(id_observacion).innerHTML = medicamento.observacion_suspension;
                  }else{
                    document.getElementById(id_estatus).innerHTML = '<span class="badge bg-success" style="color: white;">habilitado</span>';
                    document.getElementById(id_observacion).innerHTML = "No hay observación";
                  }    
                } else if (medicamento.dosis == 1 & medicamento.frecuencia > 1) {
                  document.getElementById(id_medicamento).innerHTML  = medicamento.nombre_medicamento+' '+medicamento.presentacion;
                  document.getElementById(id_presentacion).innerHTML = medicamento.dosis+' '+medicamento.unidad_medida+' cada '+medicamento.frecuencia+'  horas por '+medicamento.duracion; 
                  if(medicamento.estatus == 0){
                    document.getElementById(id_estatus).innerHTML = '<span class="badge bg-danger" style="color: white;">Suspendido</span>';
                    document.getElementById(id_observacion).innerHTML = medicamento.observacion_suspension;
                  }else{
                    document.getElementById(id_estatus).innerHTML = '<span class="badge bg-success" style="color: white;">habilitado</span>';
                    document.getElementById(id_observacion).innerHTML = "No hay observación";
                  }           
                } else {
                  document.getElementById(id_medicamento).innerHTML  = medicamento.nombre_medicamento+' '+medicamento.presentacion;
                  document.getElementById(id_presentacion).innerHTML = medicamento.dosis+' '+medicamento.unidad_medida+' cada '+medicamento.frecuencia+'  hora por '+medicamento.duracion;
                  if(medicamento.estatus == 0){
                    document.getElementById(id_estatus).innerHTML = '<span class="badge bg-danger" style="color: white;">Suspendido</span>';
                    document.getElementById(id_observacion).innerHTML = medicamento.observacion_suspension;
                  }else{
                    document.getElementById(id_estatus).innerHTML = '<span class="badge bg-success" style="color: white;">habilitado</span>';
                    document.getElementById(id_observacion).innerHTML = "No hay observación";
                  }       
                }
               
            
                document
                  .getElementById("contenedor_datos_medicamentos_update")
                  .removeAttribute("style");
              });
          
            }
        
        $("#modalActualizarConsultas").modal("show");
      } else {
      }
    })
    .fail(function () {
      console.log("error");
    });
}

/* -------------- Suspender tratamiento ------------------ */

function activarSuspension(id) {

  let id_receta = id;
  
  const contenedor_observacion_suspension = document.getElementById("contenedor_observacion_suspension");
  const observacion_suspension = document.getElementById("observacion_suspension");
  contenedor_observacion_suspension.removeAttribute("style");
  let id_receta_suspension = document.getElementById("id_receta_suspension").value = id_receta;

}

function desactivarSuspension() {
  const contenedor_observacion_suspension = document.getElementById("contenedor_observacion_suspension");
  contenedor_observacion_suspension.setAttribute("style", "display:none;");
  const observacion_suspension = document.getElementById("observacion_suspension");
  observacion_suspension.value = "";

  Swal.fire({ icon: "success", title: "Operación cancelada exitosamente", confirmButtonColor: "#3085d6" });
}

function suspenderTratamiento() {

  let id_receta_suspension = document.getElementById("id_receta_suspension").value;
  let observacion_suspension = document.getElementById("observacion_suspension").value;
  let id_consulta_update = document.getElementById("id_consulta_update").value;

  $.ajax({ 
    url: "index.php?page=suspenderTratamiento", 
    type: "post", 
    dataType: "json", 
    data: { 
      id_receta_suspension    : id_receta_suspension,
      observacion_suspension  : observacion_suspension,
      id_consulta_update      : id_consulta_update
    } }).done(function (response) {
    if (response.data.success == true) {

      document.getElementById("contenedor_observacion_suspension").setAttribute("style", "display:none;");

      Swal.fire({ 
        icon: "success", 
        title: response.data.message, 
        confirmButtonColor: "#3085d6", 
        text: response.data.info 
      });

      //Refrescar los datos de la receta
      
      if(response.data.receta_medicamentos.length < 1)
        {
          console.log(response.data.receta_medicamentos.length);
          document.getElementById("multiples_medicamentos_update").innerHTML =
          "<tr><th>Medicamento</th><th>tratamiento</th><th>Observación</th><th>Estatus</th><th>Acciones</th></tr><tr style='text-align:center; font-size: 17px; '><td colspan='5'>No hay medicamentos recetados</td></tr>";
        }else{
          console.log(response.data.receta_medicamentos.length);
          document.getElementById("multiples_medicamentos_update").innerHTML =
          "<tr><th>Medicamento</th><th>tratamiento</th><th>Observación</th><th>Estatus</th><th>Acciones</th></tr></tr>";
  
          response.data.receta_medicamentos.forEach(function (medicamento, index) {
            contador = contador + 1;
      
            //7document.getElementById("total_beneficiarios_view").innerHTML = contador;
      
            let class_contenedor = "row contenedor_" + medicamento.id_recipe_medicamento;
            let id_contenedor = "contenedor_" + medicamento.id_recipe_medicamento;
      
            let id_medicamento = "id_medicamento_" + medicamento.id_recipe_medicamento;
            let id_presentacion = "id_presentacion_" + medicamento.id_recipe_medicamento;
            let id_estatus = "id_estatus_" + medicamento.id_recipe_medicamento;
            let  id_observacion = "id_observacion_" + medicamento.id_recipe_medicamento;

            let id_boton_borrar = "id_boton_borrar_" + medicamento.id_recipe_medicamento;
            
            //Contenedor de los detalles agregados
            var cont_elemento = document.createElement("tr");
            cont_elemento.setAttribute("id", id_contenedor);
            cont_elemento.setAttribute("class", "contenedor_medicamento");
            cont_elemento.setAttribute(
              "style",
              "background:#e2e3e5; border:  solid 1px #ccc; text-align: center; padding: 10px;"
            );
            document
              .getElementById("multiples_medicamentos_update")
              .appendChild(cont_elemento);
      
            //td que almacena los nombres de las especies
            var td_medicamentos = document.createElement("td");
            td_medicamentos.setAttribute("id", id_medicamento);
            td_medicamentos.setAttribute("class", "ente");
            td_medicamentos.setAttribute(
              "style",
              "border: solid 1px #ccc; text-align: center; padding: 10px;"
            );
            cont_elemento.appendChild(td_medicamentos);
      
            //td que almacena que almacena las presentaciones de las especies
            var td_presentacion = document.createElement("td");
            td_presentacion.setAttribute("id", id_presentacion);
            td_presentacion.setAttribute("class", "cuenta_movimiento");
            td_presentacion.setAttribute(
              "style",
              "border: solid 1px #ccc; text-align: center; padding: 10px;"
            );
            cont_elemento.appendChild(td_presentacion);


            //td obersevacion
            var td_observacion = document.createElement("td");
            td_observacion.setAttribute("id", id_observacion);
            td_observacion.setAttribute("class", "estatus");
            td_observacion.setAttribute(
              "style",
              "border: solid 1px #ccc; text-align: center; padding: 10px;"
            );
            cont_elemento.appendChild(td_observacion);
            
      
            //td estatus
            var td_estatus = document.createElement("td");
            td_estatus.setAttribute("id", id_estatus);
            td_estatus.setAttribute("class", "estatus");
            td_estatus.setAttribute(
              "style",
              "border: solid 1px #ccc; text-align: center; padding: 10px;"
            );
            cont_elemento.appendChild(td_estatus);
      
            //Columna que almacena el boton borrar
            var td_accion_borrar = document.createElement("td");
            td_accion_borrar.setAttribute("id", id_boton_borrar);
            td_accion_borrar.setAttribute("class", "acciones");
            td_accion_borrar.setAttribute(
              "style",
              "border: solid 1px #ccc; text-align: center; padding: 10px;"
            );
            cont_elemento.appendChild(td_accion_borrar);
      
      
            // //Boton Modificar
            // var btn_update = document.createElement("button");
            // btn_update.setAttribute("class", "btn btn-warning btn-sm");
            // btn_update.setAttribute("title", "Modificar");
            // btn_update.setAttribute("type", "button");
            // btn_update.setAttribute(
            //   "onclick",
            //   "ModificarRecetaMedica(" + medicamento.id_recipe_medicamento + ")"
            // );
            // btn_update.setAttribute(
            //   "style",
            //   "background:#ffc107; color: #FFF; margin-left: 10px;"
            // );
            // td_accion_borrar.appendChild(btn_update);
      
            //Boton suspender
            var btn_suspender = document.createElement("button");
            btn_suspender.setAttribute("class", "btn btn-danger btn-sm");
            btn_suspender.setAttribute("title", "Suspender tratamiento");
            if (medicamento.estatus == 0) {
              btn_suspender.setAttribute("disabled", "true");
            }
            btn_suspender.setAttribute("type", "button");
            btn_suspender.setAttribute(
              "onclick",
              "activarSuspension(" + medicamento.id_recipe_medicamento + ")"
            );
            btn_suspender.setAttribute(
              "style",
              "background: #bb2d3b; color: #FFF; margin-left: 10px;"
            );
            td_accion_borrar.appendChild(btn_suspender);
            
      
            // //Icono del boton modificar
            // var icono_btn_update = document.createElement("i");
            // icono_btn_update.setAttribute("class", "fas fa-edit");
            // icono_btn_update.setAttribute("data-id", "");
            // btn_update.appendChild(icono_btn_update);
      
            //Icono del boton suspender
            var icono_btn_suspender = document.createElement("i");
            icono_btn_suspender.setAttribute("class", "fas fa-ban");
            icono_btn_suspender.setAttribute("data-id", "");
            btn_suspender.appendChild(icono_btn_suspender);
      
            if(medicamento.dosis > 1 & medicamento.frecuencia > 1) {
              document.getElementById(id_medicamento).innerHTML  = medicamento.nombre_medicamento+' '+medicamento.presentacion;
              document.getElementById(id_presentacion).innerHTML = medicamento.dosis+' '+medicamento.unidad_medida+'s cada '+medicamento.frecuencia+'  horas por '+medicamento.duracion;
              if(medicamento.estatus == 0){
                document.getElementById(id_estatus).innerHTML = '<span class="badge bg-danger" style="color: white;">Suspendido</span>';
                document.getElementById(id_observacion).innerHTML = medicamento.observacion_suspension;
              }else{
                document.getElementById(id_estatus).innerHTML = '<span class="badge bg-success" style="color: white;">habilitado</span>';
                document.getElementById(id_observacion).innerHTML = "No hay observación";
              }
            } else if (medicamento.dosis > 1 & medicamento.frecuencia == 1) {
              document.getElementById(id_medicamento).innerHTML  = medicamento.nombre_medicamento+' '+medicamento.presentacion;
              document.getElementById(id_presentacion).innerHTML = medicamento.dosis+' '+medicamento.unidad_medida+'s cada '+medicamento.frecuencia+'  hora por '+medicamento.duracion;  
              if(medicamento.estatus == 0){
                document.getElementById(id_estatus).innerHTML = '<span class="badge bg-danger" style="color: white;">Suspendido</span>';
                document.getElementById(id_observacion).innerHTML = medicamento.observacion_suspension;
              }else{
                document.getElementById(id_estatus).innerHTML = '<span class="badge bg-success" style="color: white;">habilitado</span>';
                document.getElementById(id_observacion).innerHTML = "No hay observación";
              }    
            } else if (medicamento.dosis == 1 & medicamento.frecuencia > 1) {
              document.getElementById(id_medicamento).innerHTML  = medicamento.nombre_medicamento+' '+medicamento.presentacion;
              document.getElementById(id_presentacion).innerHTML = medicamento.dosis+' '+medicamento.unidad_medida+' cada '+medicamento.frecuencia+'  horas por '+medicamento.duracion; 
              if(medicamento.estatus == 0){
                document.getElementById(id_estatus).innerHTML = '<span class="badge bg-danger" style="color: white;">Suspendido</span>';
                document.getElementById(id_observacion).innerHTML = medicamento.observacion_suspension;
              }else{
                document.getElementById(id_estatus).innerHTML = '<span class="badge bg-success" style="color: white;">habilitado</span>';
                document.getElementById(id_observacion).innerHTML = "No hay observación";
              }           
            } else {
              document.getElementById(id_medicamento).innerHTML  = medicamento.nombre_medicamento+' '+medicamento.presentacion;
              document.getElementById(id_presentacion).innerHTML = medicamento.dosis+' '+medicamento.unidad_medida+' cada '+medicamento.frecuencia+'  hora por '+medicamento.duracion;
              if(medicamento.estatus == 0){
                document.getElementById(id_estatus).innerHTML = '<span class="badge bg-danger" style="color: white;">Suspendido</span>';
                document.getElementById(id_observacion).innerHTML = medicamento.observacion_suspension;
              }else{
                document.getElementById(id_estatus).innerHTML = '<span class="badge bg-success" style="color: white;">habilitado</span>';
                document.getElementById(id_observacion).innerHTML = "No hay observación";
              }       
            }
           
        
            document
              .getElementById("contenedor_datos_medicamentos_update")
              .removeAttribute("style");
          });
      
        }

      
    
    } else {
      Swal.fire({ icon: "error", title: response.data.message, confirmButtonColor: "#3085d6", text: response.data.info });
    }
  })   .fail(function () {
    console.log("error");
  });
  
}


/* -------------- Obtener datos para actualizar receta médica ------------------ */
function ModificarRecetaMedica(id) {
  let id_receta = id;

document.getElementById("cont-loader").removeAttribute("style");
document.getElementById("contenedor-actualizar-receta").removeAttribute("style");

  //resetear los elementos tr
  const filas = document.querySelectorAll(".contenedor_medicamento");

  filas.forEach((fila) => {
    fila.style.backgroundColor = "#e2e3e5";
  });

  //Fin resetear los elementos tr

  let contenedor;

  contenedor = "contenedor" + "_" + id_receta;

  document.getElementById(contenedor).style.backgroundColor = "#fff3cd";
  document.getElementById("receta-medica").value = id_receta;
  $.ajax({
    url: "index.php?page=obtenerDatosReceta",
    type: "post",
    dataType: "json",
    data: {
      id_receta: id_receta,
    },
  })
    .done(function (response) {
      if (response.data.success == true) {
        document.getElementById("medicamento_update").value =
          response.data.id_presentacion_medicamento;
        document.getElementById("dosis_update").value =
          response.data.dosis;
        document.getElementById("unidad_medida_update").value =
          response.data.unidad_medida;
        document.getElementById("frecuencia_update").value =
          response.data.frecuencia;
        document.getElementById("cantidad_update").value =
          response.data.cantidad;
        document.getElementById("intervalo_update").value =
          response.data.intervalo;
        
        

          document.getElementById("cont-loader").setAttribute("style", "display:none;");


        $("#modalActualizarConsultas").modal("show");
      } else {
      }
    })
    .fail(function () {
      console.log("error");
    });
}



/* Actualizar receta medica */

  function modificarReceta() {

    document.getElementById("cont-loader").removeAttribute("style");

    let id_receta_update            = document.getElementById("receta-medica").value;
    let medicamento_update          = document.getElementById("medicamento_update").value;
    let dosis_update                = document.getElementById("dosis_update").value;
    let unidad_medida_update        = document.getElementById("unidad_medida_update").value;
    let frecuencia_update           = document.getElementById("frecuencia_update").value;
    let cantidad_update             = document.getElementById("cantidad_update").value;
    let intervalo_update            = document.getElementById("intervalo_update").value;
    let id_consulta_update          = document.getElementById("id_consulta_update").value;
    console.log(intervalo_update);
    /* comprobar campos vacios */
    if (
      medicamento_update == "" ||
      frecuencia_update == "" ||
      cantidad_update == "" ||
      intervalo_update == "" ||
      dosis_update == ""

    ) {
  
      Swal.fire({
        icon: "error",
        title: "Campos vacios",
        text: "Todos los campos son obligatorios",
        confirmButtonColor: "#3085d6",
      });

    }


    $.ajax({
      url: "index.php?page=modificarReceta",
      type: "post",
      dataType: "json",
      data: {
        id_receta_update:       id_receta_update,
        medicamento_update:     medicamento_update,
        dosis_update:           dosis_update,
        unidad_medida_update:   unidad_medida_update,
        frecuencia_update:      frecuencia_update,
        cantidad_update:        cantidad_update,
        intervalo_update:       intervalo_update,
        id_consulta_update:     id_consulta_update
      },
    })

      .done(function (response) {
        if (response.data.success == true) {
          document
            .getElementById("cont-loader")
            .setAttribute("style", "display:none;");

          Swal.fire({
            icon: "success",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });

          document.getElementById("multiples_medicamentos_update").innerHTML = "";

          document.getElementById("multiples_medicamentos_update").innerHTML =
            "<tr><th>Medicamento</th><th>Tratamiento</th><th>Acciones</th></tr>";

            response.data.recetas.forEach(function (medicamento, index) {
              contador = contador + 1;
    
              //7document.getElementById("total_beneficiarios_view").innerHTML = contador;
    
              let class_contenedor = "row contenedor_" + medicamento.id_recipe_medicamento;
              let id_contenedor = "contenedor_" + medicamento.id_recipe_medicamento;
    
              let id_medicamento = "id_medicamento_" + medicamento.id_recipe_medicamento;
              let id_presentacion = "id_presentacion_" + medicamento.id_recipe_medicamento;
              let id_boton_borrar = "id_boton_borrar_" + medicamento.id_recipe_medicamento;
              
              //Contenedor de los detalles agregados
              var cont_elemento = document.createElement("tr");
              cont_elemento.setAttribute("id", id_contenedor);
              cont_elemento.setAttribute("class", "contenedor_medicamento");
              cont_elemento.setAttribute(
                "style",
                "background:#e2e3e5; border:  solid 1px #ccc; text-align: center; padding: 10px;"
              );
              document
                .getElementById("multiples_medicamentos_update")
                .appendChild(cont_elemento);
    
              //td que almacena los nombres de las especies
              var td_medicamentos = document.createElement("td");
              td_medicamentos.setAttribute("id", id_medicamento);
              td_medicamentos.setAttribute("class", "ente");
              td_medicamentos.setAttribute(
                "style",
                "border: solid 1px #ccc; text-align: center; padding: 10px;"
              );
              cont_elemento.appendChild(td_medicamentos);
    
              //td que almacena que almacena las presentaciones de las especies
              var td_presentacion = document.createElement("td");
              td_presentacion.setAttribute("id", id_presentacion);
              td_presentacion.setAttribute("class", "cuenta_movimiento");
              td_presentacion.setAttribute(
                "style",
                "border: solid 1px #ccc; text-align: center; padding: 10px;"
              );
              cont_elemento.appendChild(td_presentacion);
    
              //Columna que almacena el boton borrar
              var td_accion_borrar = document.createElement("td");
              td_accion_borrar.setAttribute("id", id_boton_borrar);
              td_accion_borrar.setAttribute("class", "acciones");
              td_accion_borrar.setAttribute(
                "style",
                "border: solid 1px #ccc; text-align: center; padding: 10px;"
              );
              cont_elemento.appendChild(td_accion_borrar);
    
              //Boton borrar
              var btn_delete = document.createElement("button");
              btn_delete.setAttribute("class", "btn btn-danger btn-sm");
              btn_delete.setAttribute("title", "Remover");
              btn_delete.setAttribute("type", "button");
              btn_delete.setAttribute(
                "onclick",
                "eliminarEspecieUpdate(" + medicamento.id_recipe_medicamento + ")"
              );
              btn_delete.setAttribute("style", "background:#dc3545; color: #FFF;");
              td_accion_borrar.appendChild(btn_delete);
    
              //Boton Modificar
              var btn_update = document.createElement("button");
              btn_update.setAttribute("class", "btn btn-warning btn-sm");
              btn_update.setAttribute("title", "Modificar");
              btn_update.setAttribute("type", "button");
              btn_update.setAttribute(
                "onclick",
                "ModificarRecetaMedica(" + medicamento.id_recipe_medicamento + ")"
              );
              btn_update.setAttribute(
                "style",
                "background:#ffc107; color: #FFF; margin-left: 10px;"
              );
              td_accion_borrar.appendChild(btn_update);
    
              //Icono del boton borrar
              var icono_btn_delete = document.createElement("i");
              icono_btn_delete.setAttribute("class", "fas fa-trash");
              icono_btn_delete.setAttribute("data-id", "");
              btn_delete.appendChild(icono_btn_delete);
    
              //Icono del boton modificar
              var icono_btn_update = document.createElement("i");
              icono_btn_update.setAttribute("class", "fas fa-edit");
              icono_btn_update.setAttribute("data-id", "");
              btn_update.appendChild(icono_btn_update);
    
              if(medicamento.dosis > 1 & medicamento.frecuencia > 1) {
                document.getElementById(id_medicamento).innerHTML  = medicamento.nombre_medicamento+' '+medicamento.presentacion;
                document.getElementById(id_presentacion).innerHTML = medicamento.dosis+' '+medicamento.unidad_medida+'s cada '+medicamento.frecuencia+'  horas por '+medicamento.duracion;          
              } else if (medicamento.dosis > 1 & medicamento.frecuencia == 1) {
                document.getElementById(id_medicamento).innerHTML  = medicamento.nombre_medicamento+' '+medicamento.presentacion;
                document.getElementById(id_presentacion).innerHTML = medicamento.dosis+' '+medicamento.unidad_medida+'s cada '+medicamento.frecuencia+'  hora por '+medicamento.duracion;            
              } else if (medicamento.dosis == 1 & medicamento.frecuencia > 1) {
                document.getElementById(id_medicamento).innerHTML  = medicamento.nombre_medicamento+' '+medicamento.presentacion;
                document.getElementById(id_presentacion).innerHTML = medicamento.dosis+' '+medicamento.unidad_medida+' cada '+medicamento.frecuencia+'  horas por '+medicamento.duracion;            
              } else {
                document.getElementById(id_medicamento).innerHTML  = medicamento.nombre_medicamento+' '+medicamento.presentacion;
                document.getElementById(id_presentacion).innerHTML = medicamento.dosis+' '+medicamento.unidad_medida+' cada '+medicamento.frecuencia+'  hora por '+medicamento.duracion;          
              }
              
              document
                .getElementById("contenedor_datos_medicamentos_update")
                .removeAttribute("style");
            });
            
          /* Fin mostrar las especies de pescado para la actualizacion */
        } else {
          document
            .getElementById("cont-loader")
            .setAttribute("style", "display:none;");

          Swal.fire({
            icon: "error",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });
        }
      })
      .fail(function () {
        document
          .getElementById("cont-loader")
          .setAttribute("style", "display:none;");

        console.log("error");
      });
  }

  
  let modificar_consulta; 
  if ( modificar_consulta = document.getElementById('modificar_consulta')) {
    modificar_consulta.addEventListener('click', modificarConsulta)
    function modificarConsulta() {
    
      let id_consulta_update                 = document.getElementById("id_consulta_update").value;         
      let update_tipo_consulta               = document.getElementById("update_tipo_consulta").value;
      let update_peso                        = document.getElementById("update_peso").value;
      let update_altura                      = document.getElementById("update_altura").value;
      let update_presion_arterial            = document.getElementById("update_presion_arterial").value;
      let update_diagnostico                 = document.getElementById("update_diagnostico").value;
  
      /* comprobar campos vacios */
      if (
        id_consulta_update == "" ||
        update_tipo_consulta == "" ||
        update_peso == "" ||
        update_altura == "" ||
        update_presion_arterial == "" ||
        update_diagnostico == ""
  
      ) {
    
        Swal.fire({
          icon: "error",
          title: "Campos vacios",
          text: "Todos los campos son obligatorios",
          confirmButtonColor: "#3085d6",
        });
  
      }
  
      $.ajax({
        url: "index.php?page=modificarConsulta",
        type: "post",
        dataType: "json",
        data: {
          id_consulta_update:       id_consulta_update,
          update_tipo_consulta:     update_tipo_consulta,
          update_peso:              update_peso,
          update_altura:            update_altura,
          update_presion_arterial:  update_presion_arterial,
          update_diagnostico:       update_diagnostico
        },
      })
  
        .done(function (response) {
  
          if (response.data.success == true) {

            document.getElementById("formActualizarConsultas").reset();
  
            Swal.fire({
              icon: "success",
              confirmButtonColor: "#3085d6",
              title: response.data.message,
              text: response.data.info,
            });
              
            $("#modalActualizarConsultas").modal("hide")

          $("#tbl_consultas").DataTable().ajax.reload();
          } else {

            Swal.fire({
              icon: "error",
              confirmButtonColor: "#3085d6",
              title: response.data.message,
              text: response.data.info,
            });
          }
        })
        .fail(function () {
        
          console.log("error");
        });
    }
  
  }

  
 

  function cancelarRecetaUpdate() {
  
     //document.getElementById('contenedor-actualizar-receta').setAttribute('style', "display:none;");
     document.getElementById('form_update_receta').reset();


     

  }



  /* -------------- finalizar Cita ------------------ */
function finalizarCita(id) {
  var id_cita = id;

  Swal.fire({
    title: "¿Está seguro de finalizar la cita?",
    text: "¡No podra deshacer los cambios!.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "index.php?page=finalizarCita",
        type: "post",
        dataType: "json",
        data: {
          id_cita: id_cita,
        },
      })
        .done(function (response) {
          if (response.data.success == true) {

            Swal.fire({
              icon: "success",
              confirmButtonColor: "#3085d6",
              title: response.data.message,
              text: response.data.info,
            });

            $("#tabla_citas").DataTable().ajax.reload();
          } else {

            Swal.fire({
              icon: "success",
              title: response.data.message,
              confirmButtonColor: "#0d6efd",
              text: response.data.info,
            });

          }
        })
        .fail(function () {
          console.log("error");
        });
    }
  });
}



/* -------------- Listar datos para actualizar motivo ------------------ */

function listarActualizacionMotivo(id) {
  let id_motivo = id;

  $.ajax({
    url: "index.php?page=listarActualizacionMotivo",
    type: "post",
    dataType: "json",
    data: {
      id_motivo: id_motivo,
    },
  })
    .done(function (response) {
      if (response.data.success == true) {
        document.getElementById("id_motivo").value =
          response.data.id_motivo;
        document.getElementById("update_motivo").value =
          response.data.motivo;
        document.getElementById("update_especialidad_motivo").value =
          response.data.id_especialidad;
        $("#modalActualizarMotivos").modal("show");
      } else {
      }
    })
    .fail(function () {
      console.log("error");
    });
}



/* -------------- Modificar motivo ------------------ */
var modificar_motivo;
if (
  (modificar_motivo = document.getElementById("modificar_motivo"))
) {
  modificar_motivo.addEventListener(
    "click",
    modificarMotivo,
    false
  );

  function modificarMotivo() {
    let id_motivo = document.getElementById("id_motivo").value;
    let update_motivo = document.getElementById(
      "update_motivo"
    ).value;
    let update_id_especialidad = document.getElementById(
      "update_especialidad_motivo"
    ).value;
    $.ajax({
      url: "index.php?page=modificarMotivo",
      type: "post",
      dataType: "json",
      data: {
        id_motivo: id_motivo,
        update_motivo: update_motivo,
        update_id_especialidad: update_id_especialidad
        
      },
    })
      .done(function (response) {
        if (response.data.success == true) {
          document.getElementById("formActualizarMotivos").reset();

          $("#modalActualizarMotivos").modal("hide");

          Swal.fire({
            icon: "success",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });

          $("#tbl_motivos").DataTable().ajax.reload();
        } else {
          Swal.fire({
            icon: "danger",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });
        }
      })
      .fail(function () {
        console.log("error");
      });
  }
}




/* -------------- Ver Motivo ------------------ */
function verMotivo(id) {
  let id_motivo = id;

  $.ajax({
    url: "index.php?page=listarActualizacionMotivo",
    type: "post",
    dataType: "json",
    data: {
      id_motivo: id_motivo,
    },
  })
    .done(function (response) {
      if (response.data.success == true) {
        document.getElementById("nombre_motivo").innerHTML = `<strong>Nombre</strong>: `+ response.data.motivo;
        document.getElementById("ver_especialidad_motivo").innerHTML =  `<strong>Especialidad</strong>: `+ response.data.nombre_especialidad;

        $("#modalVisualizarMotivo").modal("show");
      } else {
      }
    })
    .fail(function () {
      console.log("error");
    });
}

// new DataTable('#example');


$(document).ready(function () {
  $("#example").DataTable({
    pageLength: 3,
    dom: "Bfrtip",
    language: {
      decimal: "",
      emptyTable: "No hay información",
      info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
      infoFiltered: "(Filtrado de _MAX_ total entradas)",
      infoPostFix: "",
      thousands: ",",
      lengthMenu: "Mostrar _MENU_ Entradas",
      loadingRecords: "Cargando...",
      processing: "Procesando...",
      search: "Buscar:",
      zeroRecords: "Sin resultados encontrados",
      paginate: {
        first: "Primero",
        last: "Ultimo",
        next: "Siguiente",
        previous: "Anterior",
      },
    },
  });
});




/* -------------- Ver Motivo ------------------ */
function verEspecialidad(id) {
  let id_especialidad = id;

  $.ajax({
    url: "index.php?page=listarActualizacionEspecialidad",
    type: "post",
    dataType: "json",
    data: {
      id_especialidad: id_especialidad,
    },
  })
    .done(function (response) {
      if (response.data.success == true) {
        document.getElementById("nombre_especialidad").innerHTML = `<strong>Nombre</strong>: `+ response.data.especialidad;
        document.getElementById("ver_modalidad").innerHTML =  `<strong>Modalidad</strong>: `+ response.data.modalidad;
        document.getElementById("ver_tm_porcita").innerHTML = response.data.tm_porcita !== 'N/A' ?  `<strong>Tiempo por cita</strong>: `+ response.data.tm_porcita+' Min' : `<strong>Tiempo por cita</strong>: `+ response.data.tm_porcita;


        $("#modalVisualizarEspecialidad").modal("show");
      } else {
      }
    })
    .fail(function () {
      console.log("error");
    });
}

// new DataTable('#example');


$(document).ready(function () {
  $("#example").DataTable({
    pageLength: 3,
    dom: "Bfrtip",
    language: {
      decimal: "",
      emptyTable: "No hay información",
      info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
      infoFiltered: "(Filtrado de _MAX_ total entradas)",
      infoPostFix: "",
      thousands: ",",
      lengthMenu: "Mostrar _MENU_ Entradas",
      loadingRecords: "Cargando...",
      processing: "Procesando...",
      search: "Buscar:",
      zeroRecords: "Sin resultados encontrados",
      paginate: {
        first: "Primero",
        last: "Ultimo",
        next: "Siguiente",
        previous: "Anterior",
      },
    },
  });
});




/* -------------- Listar datos para actualizar motivo ------------------ */

function listarActualizacionMedicamentos(id) {
  let id_medicamento = id;
  $.ajax({
    url: "index.php?page=listarActualizacionMedicamento",
    type: "post",
    dataType: "json",
    data: {
      id_medicamento: id_medicamento,
    },
  })
    .done(function (response) {
      if (response.data.success == true) {
        document.getElementById("id_medicamento_update").value =
          response.data.id_medicamento;
        document.getElementById("id_pm_update").value =
          response.data.id_presentacion_medicamento;
        document.getElementById("nombre_medicamento_update").value =
          response.data.nombre_medicamento;
        document.getElementById("categoria_update").value =
          response.data.categoria;
        document.getElementById("presentacion_update").value =
          response.data.presentacion;
        $("#modalActualizarMedicamentos").modal("show");
      } else {
      }
    })
    .fail(function () {
      console.log("error");
    });
}


/* -------------- Modificar motivo ------------------ */
var modificar_medicamento;
if (
  (modificar_medicamento = document.getElementById("modificar_medicamento"))
) {
  modificar_medicamento.addEventListener(
    "click",
    modificarMedicamentos,
    false
  );

  function modificarMedicamentos() {
    let id_medicamento = document.getElementById("id_medicamento_update").value;
    let id_pm = document.getElementById("id_pm_update").value;
    let nombre_medicamento_update = document.getElementById(
      "nombre_medicamento_update"
    ).value;
    let categoria_update = document.getElementById(
      "categoria_update"
    ).value;
    let presentacion_update = document.getElementById(
      "presentacion_update"
    ).value;
    $.ajax({
      url: "index.php?page=modificarMedicamento",
      type: "post",
      dataType: "json",
      data: {
        id_medicamento: id_medicamento,
        id_pm: id_pm,
        nombre_medicamento_update: nombre_medicamento_update,
        categoria_update: categoria_update,
        presentacion_update: presentacion_update,
    
        
      },
    })
      .done(function (response) {
        if (response.data.success == true) {
          document.getElementById("formActualizarMedicamento").reset();

          $("#modalActualizarMedicamentos").modal("hide");

          Swal.fire({
            icon: "success",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });
          
          $("#tbl_medicamentos").DataTable().ajax.reload();
        } else {
          Swal.fire({
            icon: "danger",
            confirmButtonColor: "#3085d6",
            title: response.data.message,
            text: response.data.info,
          });
        }
      })
      .fail(function () {
        console.log("error");
      });
  }
}
