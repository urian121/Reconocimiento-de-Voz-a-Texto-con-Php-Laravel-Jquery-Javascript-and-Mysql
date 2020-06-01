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
    .zmdi{
      font-size: 40px;
    }
    .zmdi:hover{
        cursor: pointer;
        color: crimson;
       transition: 0.3s;
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

 <div class="row">
   <div class="col-12">

<center>
  <div class="badge text-center">
  <i class="zmdi zmdi-mic zmdi-hc-lg" onclick="record()"></i>
</div>
</center>
<br><br>

   </div>
  </div>


  <div class="row">
   <div class="col-12">

    <form id="form-data" method="post" data-route="{{ route('palabra') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

            <div class="input-group">
              <input type="text" class="form-control" name="speechToText" id="speechToText" placeholder="Presione el Boton para Hablar  58*10*54">
            </div>

      </form>

  <hr id="hrs">

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



  <div id="resultado" style="width: 90%; border: 1px solid red;">



      </div>
    </div>
</div>









<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript">

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});


function record() {
    var recognition = new webkitSpeechRecognition();
    recognition.lang = "es-US";  //español colombia es-CO --es-MX,es-VE y es-US = español

    recognition.onresult = function(event) {
      //console.log(event);
    var resultadovoz = document.getElementById('speechToText').value = event.results[0][0].transcript;
    if (resultadovoz !="") {

    var route =$('#form-data').data('route');
    //$('#resultado').html('<div class="loading"><img src="images/loader.gif" alt="loading" /><br/>Un momento, por favor...</div>');

      $.ajax({
            type:'POST',
            url:route,
            dataType: 'json', //Tipo de Respuesta opcional
            data: $("#form-data").serialize(),
            beforeSend: function () {
             // $('#resultado').append('<img style="position:absolute;margin:auto;top:0;left:0;right:0;bottom:0;" src="/imgs/loading.gif"/>');
              $("#resultado").html("Procesando, espere por favor...");
              //$("#respuesta").html('Buscando empleado...');
            },
            success:function(Response){
              console.log(Response);
               var valor = ''
              Response.forEach(variable => {
                valor += "<tr>"+
                 "<td>" + variable.id + "</td>"+
                 "<td>" + variable.speechToText + "</td>"+
                 "<td>" + variable.created_at + "</td>"+
                 "<tr>";
              })
             $("#datos").html(valor);


              /***Nota Importante: **/
              /*esto cunsulta aun route donde el mismo debe devolverle una respuesta pero en formato json
              luego la repuesta  se itera toda la consulta con each mostrando cada registro*/

              /* public function mostrarData()
                  {
                      $nombrePalabras = NombrePaises::orderBy('id', 'DESC')->get();
                      return response()->json($nombrePalabras);
                  }
              */
              var tablaDatos = $("#datos");
              $.get("{{ route('midata') }}", function(res){
                  $(res).each(function(key, value) {
                   var t =  tablaDatos.append("<tr><td>"+ value.id +"</td></tr>");
                });
              });


            }
        });

        }
  }
    recognition.start();
}
</script>

</body>
</html>
