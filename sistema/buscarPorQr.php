<?php 
  include_once('./funciones/controlAcceso.php');
  $dni = base64_decode($_GET['q']);
  $nav_item_home = "";
  $nav_item_interesado = "";
  $nav_item_usuario = "";
  $nav_item_escanear = "active";
?>

<!doctype html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SiAcreAc - Sistema Acreditacion Academica</title>
   <?php include_once('mod_css.html'); ?>
   <link rel="stylesheet" href="./css/custom.css">
   <?php include("mod_jquery.html"); ?>
  <style>
    .input-group > .select2-container--bootstrap {
      border-color: #EAEDED !important;
	width: auto;
	flex: 1 1 auto;
}

.input-group > .select2-container--bootstrap .select2-selection--single {
	height: 100%;
	line-height: inherit;
	padding: 0.5rem 1rem;
}

.disabledbutton {
          pointer-events: none;
          opacity: 0.5;
      }


  </style>
  
      
</head>
<body>
  <!-- NAVBAR -->
 <header>
    <?php include("mod_navbar.php"); ?>
  </header>

  <article>
    <div id="breadcrumb">
      <nav aria-label="breadcrumb" role="navigation">
          <ol class="breadcrumb">
              <li class="breadcrumb-item" aria-current="page"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Interesados</li>
          </ol>
      </nav>
    </div>
  </article>

  <article class="container">
    <div id="titulo" style="background-color: #C1E0F5;"></div>
  </article>

  <article class="container">
       <section>
          <div class="jumbotron jumbotron-fluid">
              <div class="container">
                  <h1 class="display-4">Datos del Interesado</h1>
                  <hr>
                  <p class="lead">Estos datos son totalmente confidenciales.</p>
                  <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-9" id="resultado">
                           
                          
                           

                      </div>
                  </div>
              </div>
          </div>
        </section>
  </article>

<!-- FOOTER -->
<?php include("mod_footer.html"); ?>


<!-- JAVASCRIPT CUSTOM -->

<script>
  $(function () {
    let url = "funciones/interesadoObtenerPorDni.php";
    let dni = '<?=$dni?>';
    let parametros = {'dni':dni};
    let html = "";
    $.post(url,parametros,function(response){
      if (response.codigo==100) {
          console.info(response.datos[0]);

          html = `<div class="container" >
                    <img class="img-thumbnail img-fluid " src="../fotos/`+response.datos[0].foto+`" alt="" width="120"> 
                  </div>
                  <hr>
                  <p><strong>Apellido: <span class="badge badge-primary">`+response.datos[0].apellido+`, `+response.datos[0].nombres+ `</span></strong>
                  <p><strong>DNI: <span class="badge badge-primary">`+response.datos[0].dni+`</span></strong>
                  <p><strong>Direccion:</strong> `+response.datos[0].direccion+`
                  <p><strong>Celular: <span class="badge badge-primary"> (`+response.datos[0].telefono_caracteristica+`) `+response.datos[0].telefono_numero+` </span></strong>
                  <p><strong>Localidad: </strong> `+response.datos[0].localidad_nombre+`, `+response.datos[0].provincia_nombre+`
                  <p><strong>Email: <span class="badge badge-primary">`+response.datos[0].email+`</span></strong>
                  <p><strong>Abon??: <span class="badge badge-warning">`+response.datos[0].pago+`</span></strong>
                  <hr>
                  <p><button class="btn btn-primary btn-block" onclick="confirmarAsistencia(`+response.datos[0].id+`)">Confirmar</button>`;
          $("#resultado").html(html);

      } else {
         
      }
    },"json")
  });

   function confirmarAsistencia(id) {
      //alert(id);
      let url = "./funciones/interesadoConfirmarAsistencia.php";
      let parametros = {"interesado_id":id};
      if (confirm("Desea Confirmar Asistencia?")) {
        if (id) {
          //location.href = './itemEscanearQr.php';
          $.post(url,parametros, function(data){
             if (data.codigo==100) {
                alert('Atenci??n: Se confirm?? la asistencia CORRECTAMENTE.');
                location.href = './itemEscanearQr.php';
             } else {
                alert('Atenci??n: Hubo un Error en el Servidor.');
                location.href = './itemEscanearQr.php';
             };
          },"json")
        } else {
            alert('Atenci??n: Hubo un Error con el ID del Interesado.');
            location.href = './itemEscanearQr.php';
        }
    } else {
        alert('Atenci??n: Usted Eligi?? NO confirmar la asistencia.');
        location.href = './itemEscanearQr.php';
    } 
   }
   
</script>


</body>
</html>