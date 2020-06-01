<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Busquedad con Reconocimiento de Voz - Developer Urian Viera</title>
    <link rel="shortcut icon" href="{{ asset('imgs/logo-mywebsite-urian-viera.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
     <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.1.2/css/material-design-iconic-font.min.css">
    <!---demo 1-->
    <style type="text/css" media="screen">
     hr{
      margin-bottom:50px;
    }
    #hrs{
        margin-bottom: 10px;
    }
    .col-6{
        border: 1px solid #E6E6E6;
    }
    .zmdi{
      font-size: 40px;
    }
    .zmdi:hover{
        cursor: pointer;
        color: crimson;
       transition: 0.3s;
    }
     #buscar:hover{
      cursor: pointer;
    }

  .badge {
    height: 80px;
    width: 80px;
    display: table-cell;
    text-align: center;
    vertical-align: middle;
    border-radius: 50%;
    background: #ece;
    border: 1px solid #333;
}
    </style>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <span class="navbar-brand">
<img src="{{ asset('imgs/logo-mywebsite-urian-viera.svg')}}" alt="Web Developer Urian Viera" width="120">
  Web Developer Urian Viera</span>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
</nav>

<br><br>
<br><br>
<div class="container text-center">
  <div class="starter-template">
    <p class="lead">
    Busquedad de Registros con Voz a Texto en BD, usando PHP, LARAVEL, JAVASCRIPT, JQUERY Y MYSQL entre otras cosillas.
        <br>
        <!--solo basta ajustarlo a la necesidad del cliente..-->
    </p>
  </div>

<hr>

<div class="container">
  <div class="row justify-content-md-center">
    <div class="col col-lg-4"> </div>
    <div class="col col-lg-2">
    <div class="badge text-center" style="margin: 0px 10px">
        <img id="buscar" src="{{ asset('imgs/micro.png') }}" onclick="AddConAudio()" width="22px;" title="Agregar una Palabra" alt="">
        <img id="buscando" src="{{ asset('imgs/micro.gif') }}" style="width: 40px; margin-left: -18px" title="Buscando" alt="">
    </div>
    </div>

    <div class="col col-lg-2">
      <div class="badge text-center">
        <i class="zmdi zmdi-mic zmdi-hc-lg" onclick="BuscarConAudio()" title="Buscar una Palabra"></i>
      </div>
    </div>

    <div class="col col-lg-4"> </div>
  </div>
</div>
<br>


  <div class="row">
   <div class="col-12">

    <form id="form-data" method="post" data-route="{{ route('palabra') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
            <div class="input-group">
              <input type="text" class="form-control" name="speechToText" id="speechToText" placeholder="Presione un Boton para Agregar o Buscar una Palabra...">
            </div>
      </form>

  <hr id="hrs">

  <div id="resultado">
    <div id="cargando">

    </div>

    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Palabra</th>
          <th scope="col">Fecha</th>
        </tr>
      </thead>
      <tbody id="datos"> </tbody>
    </table>

      </div>
    </div>
</div>









<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript">

$('#buscando').hide(); //ocultar icono

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});


/**Consultar registros con una repuesta en formato json**/
var tablaDatos = $("#datos");
$.get("{{ route('midata') }}", function(res){
    $(res).each(function(key, value) {
      var fecha = value.created_at.substring(0,10);
      var dia = value.created_at.substring(8,10);
      var mes = value.created_at.substring(5,7);
      var ano = value.created_at.substring(0,4);

     tablaDatos.append("<tr>");
     tablaDatos.append("<td>"+ value.id +"</td>");
     tablaDatos.append("<td>"+ value.speechToText +"</td>");
     tablaDatos.append("<td>"+ (dia + '/' + mes + '/' + ano) +"</td>");
     tablaDatos.append("</tr>");
  });
});


/***Funcion para registrar**/
function AddConAudio() {
  $('#buscar').hide(); //ocultar icono
  $('#buscando').show(); //mostrar icono

    var recognition = new webkitSpeechRecognition();
    recognition.lang = "es-US";  //español colombia es-CO --es-MX,es-VE y es-US = español

    recognition.onresult = function(event) {

    var resultadovoz = document.getElementById('speechToText').value = event.results[0][0].transcript;
    if (resultadovoz !="") {

    var route =$('#form-data').data('route');

      $.ajax({
            type:'POST',
            url:route,
            dataType: 'json', //Tipo de Respuesta opcional
            data: $("#form-data").serialize(),
            beforeSend: function () {
              $("#cargando").html("<img style='position:absolute;margin:auto;top:0;left:0;right:0;bottom:0;' src='/imgs/loading.gif'/>");

            },
            success:function(Response){
              $("#cargando").hide(); //ocultar
              $('#buscar').show(); //ocultar icono
              $('#buscando').hide(); //mostrar icono

              //$('#elemento').show();  //Mostar
               var valor = '';
              Response.forEach(variable => {
                var fecha = variable.created_at.substring(0,10);
                var dia   = variable.created_at.substring(8,10);
                var mes   = variable.created_at.substring(5,7);
                var ano   = variable.created_at.substring(0,4);

                valor += "<tr>"+
                 "<td>" + variable.id + "</td>"+
                 "<td>" + variable.speechToText + "</td>"+
                 "<td>" + (dia + '/' + mes + '/' + ano) +"</td>"+
                 "<tr>";
              })
             $("#datos").html(valor);


            }
        });

        }
  }
    recognition.start();
}



/***Funcion para Buscar una Palabra****/
function BuscarConAudio() {
    var recognition = new webkitSpeechRecognition();
    recognition.lang = "es-US";  //español colombia es-CO --es-MX,es-VE y es-US = español

    recognition.onresult = function(event) {

    var resultadovoz = document.getElementById('speechToText').value = event.results[0][0].transcript;
    if (resultadovoz !="") {

      $.ajax({
            type:'GET',
            url:"{{ route('searchData') }}",
            dataType: 'json', //Tipo de Respuesta opcional
            data: $("#form-data").serialize(),
            beforeSend: function () {
              $("#cargando").html("Buscando . . . .");

            },
            success:function(resp){
              $("#cargando").hide(); //ocultar
              console.log(resp);
               var valor = '';
              resp.forEach(variable => {
                valor += "<tr>"+
                 "<td>" + variable.id + "</td>"+
                 "<td>" + variable.speechToText + "</td>"+
                 "<td>" + variable.created_at + "</td>"+
                 "<tr>";
              })
             $("#datos").html(valor);

            }
        });

        }
  }
    recognition.start();
}
</script>

</body>
</html>
