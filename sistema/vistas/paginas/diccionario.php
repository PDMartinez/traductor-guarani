<div class="content-wrapper" style="min-height: 717px;">

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>Diccionario de Palabras</h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Diccionario</li>

          </ol>

        </div>

      </div>

    </div><!-- /.container-fluid -->

  </section>

  <!-- Main content -->
  <section class="content">

    <div class="container-fluid">

      <div class="row">

        <div class="col-12">

          <!-- Default box -->
          <div class="card card-info card-outline">

            <div class="card-header">

              <button class="btn btn-primary btn-sm btnNuevo" id="btnNuevo" data-toggle="modal" data-target="#modalDiccionarios">Registrar nueva palabra</button> 
            </div>
            <!-- /.card-header -->

            <div class="card-body">
              
              <table class="table table-bordered table-striped dt-responsive tablaDiccionarios" width="100%">
                
                <thead>

                  <tr>

                    <th style="width:10px">#</th>
                    <th>Palabra en Guarani</th>
                    <th>Palabra en Español</th>
                    <th>Oración</th>
                    <th>Foto</th>
                    <th>Fecha</th>
                    <th>estado</th>
                    <th style="width:100px">Acciones</th>          
                  </tr>   

                </thead>

                <tbody>
               

                </tbody>

              </table>

            </div>
            <!-- /.card-body -->

          </div>
          <!-- /.card -->

        </div>

      </div>

    </div>

  </section>
  <!-- /.content -->

</div>

<!--=====================================
MODAL AGREGAR
======================================-->

<div class="modal fade" id="modalDiccionarios" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">


      <form method="post" name="formDiccionario" id="formDiccionario" onsubmit="return guardarFormulario()">

        <input type="hidden" class="form-control" name="idUsuario" id="idUsuario" value="<?php echo $admin["id_u"] ?>"> 
        <input type="hidden" class="form-control" name="idDiccionario" id="idDiccionario" value="">  
        
        <!-- Modal Header -->
        <div class="modal-header bg-info">

          <h4 class="modal-title" id="titulo">Nueva Palabra</h4>

          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>

        <!-- Modal body -->
        <div class="modal-body" id="modalBody" style="display: block;">

          
          <!-- =============================================================== -->

          <div class="row">

            <!-- TITULO DEL MENU -->
            <div class="col-lg-6">
             
              <h6>PALABRA EN GUARANI:<span style="color: red;">*</span></h6>

              <div class="input-group mb-3">

                <input type="text" class="form-control" name="txtGuarani" id="txtGuarani" placeholder="Ingrese una palabra en Guarani" required> 

              </div>

            </div>

            <!-- SUB TITULO DEL MENU -->
            <div class="col-lg-6">
                
                <h6>SIGNIFICADO EN ESPAÑOL<span style="color: red;">*</span></h6>

                <div class="input-group mb-3">

                  <input type="text" class="form-control" name="txtEspanyol" id="txtEspanyol" placeholder="Ingresa el significado en Español" required> 

                </div>

            </div>

          </div>

          <!-- ======================================================================== -->

          <!-- PORTADA DE FORMA RESUMIDA -->

          <div class="form-group">

            <div class="form-group my-2">

              <input type="hidden" class="inputNuevaGaleria">
              <input type="hidden" class="inputGaleria">
              <input type="hidden" class="inputAntiguaGaleria">
              <input type="hidden" class="inputAntiguaGaleriaEstatica">

              <div class="btn btn-default btn-file">

                  <i class="fas fa-paperclip"></i> Adjuntar imagen representativa de la palabra 

                  <input type="file" name="galeria" id="galeria">
                 
              </div>

            </div>

            <img class="vistaGaleria img-thumbnail" width="250px">

            <p class="help-block small">Dimensiones: 480px * 382px | Peso Max. 2MB | Formato: JPG o PNG</p>


          </div>

          <!-- AGREGAR RESUMEN -->
          <h6>Escriba una oración formulada con la palabra</h6>

          <div id="oracionPrincipal">

            <div class="form-group" id="oracion"> 

              <textarea class="form-control txtOracion" rows="5" id="txtOracion" name="txtOracion" style="width: 100%" required></textarea>

            </div>

          </div>

          <hr>
      
        </div>

        <!-- Mensaje de Cargando... -->

        <div class="padre">

          <img id="mostrar_loading" class="intro-img img-fluid mb-3 mb-lg-0 rounded imagen" src="vistas/img/extras/cargando73.gif" alt="..." style="display:none;" />

        </div>

        <!-- Modal footer -->
        <div class="modal-footer d-flex justify-content-between">

          <div>
            <button type="button" class="btn btn-danger" id="btnCerrar" data-dismiss="modal" style="display: block;">Cerrar</button>
          </div>

          <div>
            <button type="submit" class="btn btn-primary btnGuardar" id="btnGuardar" style="display: block;">Guardar</button>
          </div>

        </div>

    
      </form>


    </div>

  </div>

</div>


<script src="vistas/js/diccionarios.js"></script>


 <!-- =================Referencias necesarias para agregar mapa========================== -->

  <!-- <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

  <script src="https://maps.googleapis.com/maps/api/js?API_KEY=AIzaSyD0T4zxlfd4NmkfkR-Rh_fYpUboru-rArE&callback=iniciarMapa"></script>; -->
   
  <!-- =================================================================================== -->


<style type="text/css">
    .padre{
        position:relative;
        width:100%;
    }   

    .imagen{
        margin:auto;
        display:block;
    }
</style>
