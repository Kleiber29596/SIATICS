am4core.ready(function () {

  // Themes begin
  am4core.useTheme(am4themes_animated);
  // Create chart instance
  var chart = am4core.create("grafica", am4charts.PieChart);

  // Add data

  let url = 'http://localhost/SIATICS/index.php?page=grafica';
  fetch(url)
    .then(response => response.json())
    .then(datos => mostrar(datos))
    .catch(e => console.log(e))

  const mostrar = (articulos) => {
    articulos.forEach(element => {
      chart.data.push(element.nombre_especialidad)
    });
    chart.data = articulos
    console.log(chart.data)

  }

  // Add and configure Series
  var pieSeries = chart.series.push(new am4charts.PieSeries());
  pieSeries.dataFields.value = "total_consulta_especialidad";
  pieSeries.dataFields.category = "nombre_especialidad";

  // This creates initial animation
  pieSeries.hiddenState.properties.opacity = 1;
  pieSeries.hiddenState.properties.endAngle = -90;
  pieSeries.hiddenState.properties.startAngle = -90;

  // Let's cut a hole in our Pie chart the size of 40% the radius
  chart.innerRadius = am4core.percent(40);

  // Put a thick white border around each Slice
  pieSeries.slices.template.stroke = am4core.color("#4a2abb");
  pieSeries.slices.template.strokeWidth = 2;
  pieSeries.slices.template.strokeOpacity = 1;


  // Add a legend
  chart.legend = new am4charts.Legend();
  // Enable export
  chart.exporting.menu = new am4core.ExportMenu();
  chart.exporting.menu = new am4core.ExportMenu();
  chart.exporting.menu.align = "left";
  chart.exporting.menu.verticalAlign = "top";

  /*let boton1=document.getElementById('boton1');
  
  boton1.addEventListener('click',function(){
      
    chart.exporting.menu.items = [
      {
        "label": "Reporte",
        "menu": [
          { "type": "png", "label": "PNG" },
          { "label": "PRINT", "type": "print" },
          { "type": "pdf", "label": "PDF" }
        ]
      }
    ];
      
      //Swal.fire('presionaste el boton 1');
  });         */
  chart.exporting.menu.items = [
    {
      "label": "<i class='fas fa-print'><i>",
      "menu": [
        
        { "label": "PRINT", "type": "print" },
        { "type": "pdf", "label": "PDF" },
        { "type": "xlsx", "label": "EXC"}
      ]
    }
  ];

}); // end am4core.ready()



//grafica sexo-------------------------->
am4core.ready(function () {

  // Themes begin
  am4core.useTheme(am4themes_animated);
  // Create chart instance
  var chart = am4core.create("sexo_chart", am4charts.PieChart);

  // Add data

  let url = 'http://localhost/SIATICS/index.php?page=sexo';
  fetch(url)
    .then(response => response.json())
    .then(datos => mostrar(datos))
    .catch(e => console.log(e))

  const mostrar = (articulos) => {
    articulos.forEach(element => {
      chart.data.push(element.sexo)
    });
    chart.data = articulos
    console.log(chart.data)

  }

  // Add and configure Series
  var pieSeries = chart.series.push(new am4charts.PieSeries());
  pieSeries.dataFields.value = "total_sexo";
  pieSeries.dataFields.category = "sexo";

  // This creates initial animation
  pieSeries.hiddenState.properties.opacity = 1;
  pieSeries.hiddenState.properties.endAngle = -90;
  pieSeries.hiddenState.properties.startAngle = -90;

  // Let's cut a hole in our Pie chart the size of 40% the radius
  chart.innerRadius = am4core.percent(40);

  // Put a thick white border around each Slice
  pieSeries.slices.template.stroke = am4core.color("#4a2abb");
  pieSeries.slices.template.strokeWidth = 2;
  pieSeries.slices.template.strokeOpacity = 1;


  // Add a legend
  chart.legend = new am4charts.Legend();
  // Enable export
  chart.exporting.menu = new am4core.ExportMenu();
  chart.exporting.menu = new am4core.ExportMenu();
  chart.exporting.menu.align = "left";
  chart.exporting.menu.verticalAlign = "top";
  chart.exporting.menu.items = [
    {
      "label": "<i class='fas fa-print'><i>",
      "menu": [
        
        { "label": "PRINT", "type": "print" },
        { "type": "pdf", "label": "PDF" },
        { "type": "xlsx", "label": "EXC"}
      ]
    }
  ]

}); // end am4core.ready()


//grafica edad---------------------------------------------->
am4core.ready(function () {

  // Themes begin
  am4core.useTheme(am4themes_animated);
  // Create chart instance
  var chart = am4core.create("edad_chart", am4charts.PieChart);

  // Add data

  let url = 'http://localhost/SIATICS/index.php?page=edad';
  fetch(url)
    .then(response => response.json())
    .then(datos => mostrar(datos))
    .catch(e => console.log(e))

  const mostrar = (articulos) => {
    articulos.forEach(element => {
      chart.data.push(element.edad)
    });
    chart.data = articulos
    console.log(chart.data)

  }

  // Add and configure Series
  var pieSeries = chart.series.push(new am4charts.PieSeries());
  pieSeries.dataFields.value = "cantidad";
  pieSeries.dataFields.category = "categoria";

  // This creates initial animation
  pieSeries.hiddenState.properties.opacity = 1;
  pieSeries.hiddenState.properties.endAngle = -90;
  pieSeries.hiddenState.properties.startAngle = -90;

  // Let's cut a hole in our Pie chart the size of 40% the radius
  chart.innerRadius = am4core.percent(40);

  // Put a thick white border around each Slice
  pieSeries.slices.template.stroke = am4core.color("#4a2abb");
  pieSeries.slices.template.strokeWidth = 2;
  pieSeries.slices.template.strokeOpacity = 1;


  // Add a legend
  chart.legend = new am4charts.Legend();
  // Enable export
  chart.exporting.menu = new am4core.ExportMenu();
  chart.exporting.menu = new am4core.ExportMenu();
  chart.exporting.menu.align = "left";
  chart.exporting.menu.verticalAlign = "top";
  chart.exporting.menu.items = [
    {
      "label": "<i class='fas fa-print'><i>",
      "menu": [
        
        { "label": "PRINT", "type": "print" },
        { "type": "pdf", "label": "PDF" },
        { "type": "xlsx", "label": "EXC"}
      ]
    }
  ]
}); // end am4core.ready()

/* Citas por edad */

am4core.ready(function () {

  // Themes begin
  am4core.useTheme(am4themes_animated);
  // Create chart instance
  var chart = am4core.create("chart_citas_por_edad", am4charts.PieChart);

  // Add data

  let url = 'http://localhost/SIATICS/index.php?page=chartCitasEdad';
  fetch(url)
    .then(response => response.json())
    .then(datos => mostrar(datos))
    .catch(e => console.log(e))

  const mostrar = (articulos) => {
    articulos.forEach(element => {
      chart.data.push(element.edad)
    });
    chart.data = articulos
    console.log(chart.data)

  }

  // Add and configure Series
  var pieSeries = chart.series.push(new am4charts.PieSeries());
  pieSeries.dataFields.value = "cantidad";
  pieSeries.dataFields.category = "categoria";

  // This creates initial animation
  pieSeries.hiddenState.properties.opacity = 1;
  pieSeries.hiddenState.properties.endAngle = -90;
  pieSeries.hiddenState.properties.startAngle = -90;

  // Let's cut a hole in our Pie chart the size of 40% the radius
  chart.innerRadius = am4core.percent(40);

  // Put a thick white border around each Slice
  pieSeries.slices.template.stroke = am4core.color("#4a2abb");
  pieSeries.slices.template.strokeWidth = 2;
  pieSeries.slices.template.strokeOpacity = 1;


  // Add a legend
  chart.legend = new am4charts.Legend();
  // Enable export
  chart.exporting.menu = new am4core.ExportMenu();
  chart.exporting.menu = new am4core.ExportMenu();
  chart.exporting.menu.align = "left";
  chart.exporting.menu.verticalAlign = "top";
  chart.exporting.menu.items = [
    {
      "label": "<i class='fas fa-print'><i>",
      "menu": [
        
        { "label": "PRINT", "type": "print" },
        { "type": "pdf", "label": "PDF" },
        { "type": "xlsx", "label": "EXC"}
      ]
    }
  ]
}); // end am4core.ready()

/* Citas por edad */

am4core.ready(function () {

  // Themes begin
  am4core.useTheme(am4themes_animated);
  // Create chart instance
  var chart = am4core.create("chart_citas_sexo", am4charts.PieChart);

  // Add data

  let url = 'http://localhost/SIATICS/index.php?page=chartCitasSexo';
  fetch(url)
    .then(response => response.json())
    .then(datos => mostrar(datos))
    .catch(e => console.log(e))

  const mostrar = (articulos) => {
    articulos.forEach(element => {
      chart.data.push(element.edad)
    });
    chart.data = articulos
    console.log(chart.data)

  }

  // Add and configure Series
  var pieSeries = chart.series.push(new am4charts.PieSeries());
  pieSeries.dataFields.value = "total_sexo";
  pieSeries.dataFields.category = "sexo";

  // This creates initial animation
  pieSeries.hiddenState.properties.opacity = 1;
  pieSeries.hiddenState.properties.endAngle = -90;
  pieSeries.hiddenState.properties.startAngle = -90;

  // Let's cut a hole in our Pie chart the size of 40% the radius
  chart.innerRadius = am4core.percent(40);

  // Put a thick white border around each Slice
  pieSeries.slices.template.stroke = am4core.color("#4a2abb");
  pieSeries.slices.template.strokeWidth = 2;
  pieSeries.slices.template.strokeOpacity = 1;


  // Add a legend
  chart.legend = new am4charts.Legend();
  // Enable export
  chart.exporting.menu = new am4core.ExportMenu();
  chart.exporting.menu = new am4core.ExportMenu();
  chart.exporting.menu.align = "left";
  chart.exporting.menu.verticalAlign = "top";
  chart.exporting.menu.items = [
    {
      "label": "<i class='fas fa-print'><i>",
      "menu": [
        
        { "label": "PRINT", "type": "print" },
        { "type": "pdf", "label": "PDF" },
        { "type": "xlsx", "label": "EXC"}
      ]
    }
  ]
}); // end am4core.ready()



//Funcion javascript que permite crear una grafica a traves de un filtro por fecha y tipo de consulta
function filtrarGraficaFechaDesdeHasta() {
  // Obtener los elementos del formulario
  const fechaDesde = document.getElementById("fechaDesde").value;
  const fechaHasta = document.getElementById("fechaHasta").value;
  // const tipoConsulta = document.getElementById("tipoConsulta").value;

  // Crear la URL con los parámetros GET
  const url =
    "?page=inicio&fechaDesde=" + fechaDesde + "&fechaHasta=" + fechaHasta;

  // Redirigir a la URL
  window.location.href = url;
}

//Función que permite filtrar datos en el dashboard a traves de una fecha inicio y fecha fin
function filtrarDatosDashboard() {

  const fechaDesde = document.getElementById("fechaDesdeDash").value;
  const fechaHasta = document.getElementById("fechaHastaDash").value;

  // Crear la URL con los parámetros GET
  const url =
    "?page=inicio&fechaDesdeDash=" + fechaDesde + "&fechaHastaDash=" + fechaHasta;

  // Redirigir a la URL
  window.location.href = url;
}



