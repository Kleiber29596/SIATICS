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
        { "type": "png", "label": "PNG" },
        { "label": "PRINT", "type": "print" },
        { "type": "pdf", "label": "PDF" }
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
        { "type": "png", "label": "PNG" },
        { "label": "PRINT", "type": "print" },
        { "type": "pdf", "label": "PDF" }
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
        { "type": "png", "label": "PNG" },
        { "label": "PRINT", "type": "print" },
        { "type": "pdf", "label": "PDF" }
      ]
    }
  ]
}); // end am4core.ready()


//Funcion javascript que permite crear una grafica a traves de un filtro por fecha y tipo de consulta
function filtrarGraficaFechaDesdeHasta() {
  // Obtener los elementos del formulario
  const fechaDesde = document.getElementById("fechaDesde").value;
  const fechaHasta = document.getElementById("fechaHasta").value;
  const tipoConsulta = document.getElementById("tipoConsulta").value;

  // Crear la URL con los parámetros GET
  const url =
    "?page=inicio&fechaDesde=" + fechaDesde + "&fechaHasta=" + fechaHasta + "&tipoConsulta=" + tipoConsulta;

  // Redirigir a la URL
  window.location.href = url;
}


//TODOS LOS TIPOS DE CONSULTAS Y EL NÚMERO DE CONSULTAS

/* Chart code */
// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

let iconPath = "M53.5,476c0,14,6.833,21,20.5,21s20.5-7,20.5-21V287h21v189c0,14,6.834,21,20.5,21 c13.667,0,20.5-7,20.5-21V154h10v116c0,7.334,2.5,12.667,7.5,16s10.167,3.333,15.5,0s8-8.667,8-16V145c0-13.334-4.5-23.667-13.5-31 s-21.5-11-37.5-11h-82c-15.333,0-27.833,3.333-37.5,10s-14.5,17-14.5,31v133c0,6,2.667,10.333,8,13s10.5,2.667,15.5,0s7.5-7,7.5-13 V154h10V476 M61.5,42.5c0,11.667,4.167,21.667,12.5,30S92.333,85,104,85s21.667-4.167,30-12.5S146.5,54,146.5,42 c0-11.335-4.167-21.168-12.5-29.5C125.667,4.167,115.667,0,104,0S82.333,4.167,74,12.5S61.5,30.833,61.5,42.5z"



let chart = am4core.create("grafica_tipos_consultas", am4charts.SlicedChart);
chart.hiddenState.properties.opacity = 0; // this makes initial fade in effect

// chart.data = [{
//   "name": "The first",
//   "value": 354
// }, {
//   "name": "The second",
//   "value": 245
// }, {
//   "name": "The third",
//   "value": 187
// }, {
//   "name": "The fourth",
//   "value": 123
// }, {
//   "name": "The fifth",
//   "value": 87
// }, {
//   "name": "The sixth",
//   "value": 45
// }, {
//   "name": "The seventh",
//   "value": 23
// }];

// Add data
  
let url = 'http://localhost/SIATICS/index.php?page=todosTiposConsulta';
fetch(url)
  .then(response => response.json())
  .then(datos => mostrar(datos))
  .catch(e => console.log(e))

const mostrar = (articulos) => {
  articulos.forEach(element => {
    chart.data.push(element.numero_consultas)
  });
  chart.data = articulos
  console.log(chart.data)

}

let series = chart.series.push(new am4charts.PictorialStackedSeries());
series.dataFields.value = "numero_consultas";
series.dataFields.category = "motivo";
series.alignLabels = true;

series.maskSprite.path = iconPath;
series.ticks.template.locationX = 1;
series.ticks.template.locationY = 0.5;

series.labelsContainer.width = 200;

chart.legend = new am4charts.Legend();
chart.legend.position = "left";
chart.legend.valign = "bottom";
