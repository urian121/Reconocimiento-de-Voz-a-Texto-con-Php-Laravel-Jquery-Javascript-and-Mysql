<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Busquedad con Reconocimiento de Voz - Developer Urian Viera</title>
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
    .zmdi:hover{
        cursor: pointer;
        color: crimson;
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

  <div class="row">
   <div class="col-12">

<form id="form-data" method="post" data-route="{{ route('vozData') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

        <div class="input-group">
          <input type="text" class="form-control" name="speechToText" id="speechToText" placeholder="Presione el Boton para Hablar  58*10*54">
          <div class="input-group-append">
            <span class="input-group-text">
                <i class="zmdi zmdi-mic zmdi-hc-lg" onclick="record()"></i>
            </span>
          </div>
        </div>

        <button class="btn btn-success waves-effect" type="submit" id="btnEnviar">Guardar Registro</button>
  </form>

  <hr id="hrs">
  <div id="resultado"> </div>

    </div>
</div>

<a href="{{ route('ruta') }}" class="text-center" title=""> link</a>



<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});

function record() {
    var route =$('#form-data').data('route');
    var form_data = $(this);

    var recognition = new webkitSpeechRecognition();
    recognition.lang = "es-US";  //español colombia es-CO --es-MX,es-VE y es-US = español

    recognition.onresult = function(event) {
        // console.log(event);
      var resultadovoz = document.getElementById('speechToText').value = event.results[0][0].transcript;
        alert(resultadovoz);

        /**Mi ajax para enviar el resultado de la voz***/
    $.ajax({
        type:'POST',
        url:route,
        data:form_data.serialize(),
        //dataType: 'html',

      success: function(datos){
      $("#resultado").html(datos);
      $("#resultado").append(Response.mensaje);
      $('#resultado').html(datos.mensaje);
      console.log(datos);
    }
  });

  }
    recognition.start();
}
</script>

</body>
</html>
