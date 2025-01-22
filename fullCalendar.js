$(document).ready(function() {  
   $('#DIVcalendar').fullCalendar({
    initialView: 'dayGridMonth',
    selectable: true,
    selectHelper: true,
    select: function(info) {
      $(info.start).css('background-color', 'lightblue');
      let id_especialidad_cita = document.getElementById("especialidad").value;
      let id_doctor_cita = document.getElementById("doctor").value;
      // Obtener el valor del input
      const diaLaboral = document.getElementById("diaLaboral").value;

      // Dividir el string en un arreglo y normalizar los elementos
      const dataArray = diaLaboral.split(",").map(item => item.trim());

      console.log(diaLaboral);

      // Objeto de mapeo para los días de la semana
      const diaMap = {
          'lunes': 1,
          'martes': 2,
          'miercoles': 3,
          'jueves': 4,
          'viernes': 5,
          'sabado': 6,
          'domingo': 0
      };

      // Usar forEach para recorrer el arreglo y asignar los valores correspondientes
      dataArray.forEach((item, index) => {
          // Asignar el valor correspondiente usando el objeto de mapeo
          dataArray[index] = diaMap[item.toLowerCase()] !== undefined ? diaMap[item.toLowerCase()] : 0; // Asigna 0 si no se encuentra el día
      });

      // Mostrar el resultado
      //console.log('Días Laborales:', dataArray); // Muestra el arreglo en la consola
      //alert("Días Laborales: " + dataArray.join(", ")); // Muestra el arreglo en un alert

      if (id_especialidad_cita && id_doctor_cita) {
        //alert(id_especialidad_cita + ' ' + id_doctor_cita);
        var nuevaFecha = moment(info).format('YYYY-MM-DD');
        var hoy = moment(info.start).format('YYYY-MM-DD');
        var f = moment(info).day();

        dataArray.forEach((value, index) => {
          if (value != f) {
              console.log(`El día ${value} en la posición ${index} no labora este doctor/a.`);
              Swal.fire({
                  icon: "error",
                  confirmButtonColor: "#3085d6",
                  title: 'Error',
                  text: 'Estos dias no labora este doctor/a.',
                });
          } else {
              //console.log(`El día en la posición ${index} es válido y tiene el valor: ${value}`);
              if (nuevaFecha < hoy) {
                Swal.fire({
                  icon: "warning",
                  confirmButtonColor: "#3085d6",
                  title: 'Cuidado',
                  text: 'No es posible asignar una cita para esta fecha.',
                });
              }else if(nuevaFecha == hoy){
                Swal.fire({
                  icon: "warning",
                  confirmButtonColor: "#3085d6",
                  title: 'Cuidado',
                  text: 'Para el dia de hoy no es posible asignar una cita.',
                });
              }else if(f === 0 || f === 6){
                Swal.fire({
                  icon: "error",
                  confirmButtonColor: "#3085d6",
                  title: 'Error',
                  text: 'Estos dias no son laborables.',
                });
              }else{
                $.ajax({
                  url: "index.php?page=consultarEspeDoct",
                  type: "post",
                  dataType: "json",
                  data: {
                    especialidad: id_especialidad_cita,
                    doctor: id_doctor_cita,
                  },
                })
                .done(function (response) {
                   console.log(response);
                     if (response.data.success == true) {
                      $('#fecha_cita').val(nuevaFecha);
                      $("#txt-especialidad").val(response.data.nombre_especialidad);
                      $("#txt-doctor").val(response.data.nombre_doctor);
                      $("#modalAgregarCitas").modal('show');
                     }
                  })
                .fail(function (e) {
                  console.log(e);
                });
              } 
          }
        });       
      }else{
        Swal.fire({
          icon: "warning",
          confirmButtonColor: "#3085d6",
          title: 'Oops',
          text: 'Debe seleccionar una especialidad y un doctor.',
        });
      }
    },
    //cabecera
    header:{
      left: 'month',
      center: '',
      rigth:'prev, today, next'
    },
    //propiedades de botones
    buttonText:{
      today: 'hoy',
      month: 'mes',
      week: 'semana',
      day: 'dia'

    },
    //pie de calendario
    footer:{
      center: 'title'
    },
    events: [],
    //color de fondo celda
    /*dayRender: function(date, cell){
      var nuevaFecha = $.fullCalendar.formatDate(date, 'DD-MM-YYYY');
      const diaLaboral = document.getElementById("diaLaboral").value;
      
      if(nuevaFecha == '19-11-2024'){
        cell.css('background', 'red');
      }
    }*/
    dayRender: function(date, cell) {
        var nuevaFecha = $.fullCalendar.formatDate(date, 'DD-MM-YYYY');
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

        // Convertir los días laborales a números
        const diasLaboralesNumeros = dataArray.map(item => diaMap[item.toLowerCase()] !== undefined ? diaMap[item.toLowerCase()] : null).filter(item => item !== null);
        var f = date.day(); // Obtener el día de la semana del objeto date

        console.log('dias laborales aqui: ', diaLaboral);
        // Cambiar el color de fondo si el día es laboral
        if (diasLaboralesNumeros.includes(f)) {
            cell.css('background', 'yellow'); // Cambiar a un color que desees
        }

        // Llamar a la función para recargar los eventos en otro lugar, por ejemplo, al cambiar el mes
        //$('#DIVcalendar').fullCalendar('refetchEvents');
    }
   });
});

calendar.render();

// Función para actualizar los días laborales desde el servidor
function actualizarDiasLaborales(nuevosDias) {
  // Actualiza el valor del elemento que contiene los días laborales
  document.getElementById("diaLaboral").value = nuevosDias.join(", ");

  // Vuelve a renderizar el calendario para aplicar los nuevos días laborales
  calendar.render(); // Esto volverá a llamar a dayRender para cada celda
}

// Simulación de recibir datos del servidor
setInterval(function() {
  // Aquí deberías hacer la llamada a tu servidor para obtener los nuevos días laborales
  // Por simplicidad, vamos a simularlo con un arreglo de días
  var nuevosDias = ['lunes', 'miércoles']; // Simulación de respuesta del servidor
  actualizarDiasLaborales(nuevosDias);
}, 10000); // Cada 10 segundos
