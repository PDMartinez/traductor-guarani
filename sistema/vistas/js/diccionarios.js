/*=============================================
Tabla Diccionarios
=============================================*/

var tablaDiccionarios = $(".tablaDiccionarios").DataTable({
  "ajax":"ajax/tablaDiccionarios.ajax.php",
  "deferRender": true,
  "retrieve": true,
  "processing": true,
  "language": {

    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_",
    "sInfoEmpty":      "Mostrando registros del 0 al 0",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
      "sFirst":    "Primero",
      "sLast":     "Último",
      "sNext":     "Siguiente",
      "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }

   }

});


var mensajeFinal = 0;


/*==========================================================
    GUARDAR DICCIONARIO
============================================================*/

function guardarFormulario(){

  var txtGuarani = $("#txtGuarani").val();
  var txtEspanyol = $("#txtEspanyol").val();
  var txtOracion = myEditorOracion.getData();
  var idDiccionario = $("#idDiccionario").val();
  var txtUsuario = $("#idUsuario").val();

  var galeria = $(".inputGaleria").val();
  var galeriaAntigua = $(".inputAntiguaGaleria").val();
  var galeriaAntiguaEstatica = $(".inputAntiguaGaleriaEstatica").val();

  mostrarLoading();

  // alert(archivosTemporales360.length + " " + archivosTemporales.length);
  // console.log("txtGuarani: " + txtGuarani + " txtSubtitulo: "+ txtEspanyol + " txtOracion: " + txtOracion + " idDiccionario: "+ idDiccionario + " txtUsuario: "+ txtUsuario + " galeria: " + galeria);
  // return;

  var datos = new FormData();

      datos.append("txtGuarani", txtGuarani);
      datos.append("txtEspanyol", txtEspanyol);
      datos.append("txtOracion", txtOracion);
      datos.append("idDiccionario", idDiccionario);
      datos.append("txtUsuario", txtUsuario);

      $.ajax({
      url: "ajax/diccionarios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,

      success: function(respuesta) {

        var objData = JSON.parse(respuesta);

        if(archivosTemporales.length > 0){

            mensajeFinal = "temporal";

        }else{

          mensajeFinal = "ninguno";

        }

        if (objData.status) {

          if(parseInt(objData.COD_DICCIONARIO) > 0){

            agregarImagen(archivosTemporales, objData.COD_DICCIONARIO, galeria, galeriaAntigua, galeriaAntiguaEstatica);

          }

          if(parseInt(objData.COD_DICCIONARIO) <= 0){

            agregarImagen(archivosTemporales, idDiccionario, galeria, galeriaAntigua, galeriaAntiguaEstatica);

          }

          LimpiarText();

          if(mensajeFinal == "ninguno"){

            cerrarLoading();


            swal("¡CORRECTO!", objData.msg, "success");

              tablaDiccionarios.ajax.reload(function() {

                LimpiarText();

            });

          }


        } else {

          cerrarLoading();

          swal("Error", objData.msg, "error");

        }

      }

    })
  
  return (false);

}

/*=============================================
  NUEVO
=============================================*/

$(document).on("click", ".btnNuevo", function() {

  LimpiarText();

  limpiarCKEDITORNuevo();

  $("#titulo").html("Nuevo Registro");
  $("#btnGuardar").html("Guardar");

})


/*=============================================
  Editar Guias
=============================================*/

$(document).on("click", ".editarDiccionario", function(){

  LimpiarText();

  limpiarCKEDITOREditar();

  $("#titulo").html("Editar Registro");
  $("#btnGuardar").html("Actualizar");

  var idDiccionario = $(this).attr("idDiccionario");
  var galeria = $(this).attr("galeria");

  // alert(idDiccionario);

  var datos = new FormData();

  datos.append("idDiccionario", idDiccionario);
  datos.append("galeria", galeria);

  $.ajax({

    url:"ajax/diccionarios.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success:function(respuesta){

      // console.log(respuesta);
      
      $("#idDiccionario").val(respuesta["id_diccionario"]);

      $("#txtGuarani").val(respuesta["guarani"]);

      $("#txtEspanyol").val(respuesta["espanyol"]);

      $("#txtOracion").val(respuesta["oracion"]);

      $(".ck-content").remove();

      ClassicEditor.create(document.querySelector('#txtOracion'), {

          toolbar: [ 'heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', '|', 'undo', 'redo']

        }).then(function (editor) {
                    
          $(".ck-content").css({"height":"200px"})

          myEditorOracion =  editor;

        }).catch(function (error) {

          console.log("error", error);

      })


      $(".inputAntiguaGaleriaEstatica").val((respuesta["foto"]));
      
      // COLOCAR LAS IMAGENES

      if (respuesta["foto"] != '[""]' && respuesta["foto"] != null && respuesta["foto"] != '') {

        multiplesArchivosAntiguos(respuesta["foto"]);
       
      }
        
   
    }

  })  

})

/*=============================================
  Eliminar Guias
=============================================*/

$(document).on("click", ".eliminarDiccionario", function(){

  var idDiccionario = $(this).attr("idDiccionario");
  var galeria = $(this).attr("galeria");

  // alert(idDiccionario + "  " + galeria);
  // return;
 
  swal({
    title: '¿Está seguro de eliminar?',
    text: "¡Si no lo está puede cancelar la acción!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, eliminar Guía!'
  }).then(function(result){

    if(result.value){
       
        var datos = new FormData();

        datos.append("idEliminar", idDiccionario);
        datos.append("galeria", galeria);

        $.ajax({

          url:"ajax/diccionarios.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success:function(respuesta){

            var objData = JSON.parse(respuesta);

            if (objData.status) {

              swal("¡CORRECTO!", objData.msg, "success");

              LimpiarText();
                
              tablaDiccionarios.ajax.reload(function() {

                  

              });


            }


          }

        })

      }

    })

})

/*=============================================
ACTIVAR GUIAS
=============================================*/

$(".tablaDiccionarios").on("click", ".btnActivar", function(){

  var idDiccionario = $(this).attr("idDiccionario");
  var estadoDiccionario = $(this).attr("estadoDiccionario");

  // alert(idDiccionario + " " + estadoDiccionario);
  // return;

  var datos = new FormData();
  datos.append("activarId", idDiccionario);
  datos.append("activarDiccionario", estadoDiccionario);

    $.ajax({

      url:"ajax/diccionarios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){

        var objData = JSON.parse(respuesta);

            if (objData.status) {

              swal("¡CORRECTO!", objData.msg, "success");
                
              tablaDiccionarios.ajax.reload(function() {

                  LimpiarText();

              });


            }

      }

    })

    if(estadoDiccionario == 0){

      $(this).removeClass('btn-success');
      $(this).addClass('btn-danger');
      $(this).html('Desactivado');
      $(this).attr('estadoGuias',1);

    }else{

      $(this).addClass('btn-success');
      $(this).removeClass('btn-danger');
      $(this).html('Activado');
      $(this).attr('estadoGuias',0);

    }

})


/*=============================================
Plugin ckEditor
=============================================*/

var myEditorOracion;

ClassicEditor.create(document.querySelector('#txtOracion'), {

      toolbar: [ 'heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', '|', 'undo', 'redo']

    }).then(function (editor) {
                
      $(".ck-content").css({"height":"200px"})

      myEditorOracion = editor;

    }).catch(function (error) {

      console.log("error", error);

    })

/*=============================================
Limpiar ckEditor
=============================================*/

function limpiarCKEDITOREditar(){

  $("#oracion").remove();

  $("#oracionPrincipal").append(

      '<div class="form-group" id="oracion">'+

            '<textarea class="form-control txtOracion" rows="5" id="txtOracion" name="txtOracion" style="width: 100%"></textarea>'+

      '</div>'

    );

}

/*=============================================
Limpiar ckEditor
=============================================*/

function limpiarCKEDITORNuevo(){

  $("#oracion").remove();

  $("#oracionPrincipal").append(

      '<div class="form-group" id="oracion">'+

            '<textarea class="form-control txtOracion" rows="5" id="txtOracion" name="txtOracion" style="width: 100%"></textarea>'+

      '</div>'

    );

  ClassicEditor.create(document.querySelector('#txtOracion'), {

      toolbar: [ 'heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', '|', 'undo', 'redo']

    }).then(function (editor) {
                
      $(".ck-content").css({"height":"200px"})

      myEditorOracion =  editor;

    }).catch(function (error) {

      console.log("error", error);

    })  

}

/*=============================================
AGREGAR IMAGEN PORTADA
=============================================*/

var imagenPermitidoNuevo = [];
var imagenPermitidoAntiguo = [];
var ubicacion=[];
var archivosTemporales = [];

$("#galeria").change(function() {

  // alert("change");

  imagenPermitidoNuevo = [];
  imagenPermitidoAntiguo = [];

  var archivos = this.files;
  multiplesArchivos(archivos);

})

/*=============================================
AGREGAR IMAGEN EN LA GALERÍA
=============================================*/
function multiplesArchivos(archivos) {

  for (var i = 0; i < archivos.length; i++) {

   if ((imagenPermitidoNuevo.length+i+imagenPermitidoAntiguo.length) < 1) {

      var imagen = archivos[i];

      if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {

        swal({
          title: "Error al subir la imagen",
          text: "¡La imagen debe estar en formato JPG o PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

        return;

      }  else if (imagen["size"] > 15000000) {

        swal({
          title: "Error al subir la imagen",
          text: "¡La imagen no debe pesar más de 15MB!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

        return;

      } else {

        var datosImagen = new FileReader;
        datosImagen.readAsDataURL(imagen);

        $(datosImagen).on("load", function(event) {

          var rutaImagen = event.target.result;

          $(".vistaGaleria").attr("src",rutaImagen);

          if(archivosTemporales.length != 0){

            archivosTemporales = JSON.parse($(".inputNuevaGaleria").val());
            ubicacion= JSON.parse($(".inputGaleria").val());
            imagenPermitidoNuevo=archivosTemporales;
          }

          archivosTemporales.push(rutaImagen);
          ubicacion.push(imagen["name"] );

          imagenPermitidoNuevo=archivosTemporales;

         
          $(".inputNuevaGaleria").val(JSON.stringify(archivosTemporales));
          $(".inputGaleria").val(JSON.stringify(ubicacion));
          

        })

      }

   }else {
      swal({
        title: "Error al subir la imagen",
        text: "¡Está permitido como máximo 1 imagen!",
        type: "error",
        confirmButtonText: "¡Cerrar!"
      });
    
      return;
    
   }

  } // termina el for

}

/*=============================================
AGREGAR EN LA BASE DE DATOS LA IMAGEN
=============================================*/

function agregarImagen(imagen,token,ruta,rutavieja,rutacompleta){
 
 /*=============================================
  PREGUNTAMOS SI LOS CAMPOS OBLIGATORIOS ESTÁN LLENOS
  =============================================*/
   
  if(imagen != ""){

    // alert(imagen);
    // return;
  
    /*=============================================
      PREGUNTAMOS SI VIENEN IMÁGENES PARA MULTIMEDIA
    =============================================*/

    if(imagen.length > 0 || rutavieja.length > 0){

      datosMultimedia = new FormData();
       
      for(var i = 0; i < imagen.length; i++){

        document.getElementById('galeria').files[i]=imagen[i];
        var img= document.getElementById('galeria').files[i];

        
          datosMultimedia.append("tabla", "diccionario");
          datosMultimedia.append("token", token);
          datosMultimedia.append("token_columna", "id_diccionario");
          datosMultimedia.append("rutavieja", rutavieja);
          datosMultimedia.append("rutacompleta", rutacompleta);
          datosMultimedia.append("foto_columna", "foto");
          datosMultimedia.append("file", img);
          datosMultimedia.append("carpeta", "diccionarios");
          datosMultimedia.append("ruta", ruta);

          $.ajax({
        
            type: "POST",
            url:"ajax/multimedia.ajax.php",
            dataType:"json",
            contentType: false,
            processData: false,
            cache: false,
            data: datosMultimedia,

            xhr: function(){
            
              var xhr = $.ajaxSettings.xhr();

              xhr.onprogress = function(evt){ 

              var porcentaje = Math.floor((evt.loaded/evt.total*100));

            };

            return xhr;
              
            },
            beforeSend: () =>{

                $("#btnGuardar").prop('disabled', true);
                document.getElementById("mostrar_loading").style.display="block";
                document.getElementById("mostrar_loading").innerHTML="<img  width='150' heigth='150' data-src='loading.gif' class='lazyload' src='data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=='><noscript><img src='loading.gif' width='150' heigth='150'></noscript>";

            }         

            }).done(res=>{

              if(res.status===200){
                
                if(mensajeFinal == "temporal"){

                  cerrarLoading();

                  swal("¡CORRECTO!", res.msg, "success");

                    tablaDiccionarios.ajax.reload(function() {

                      LimpiarText();

                  });

                }

              }else{

                alert(res.msg);

              }

            }).fail(err=>{

              cerrarLoading();

              swal("Error", objData.msg, "error");

            })

      }

    }

  }

}

/*=============================================
AGREGAR IMAGENES ANTIGUOS
=============================================*/

archivosTemporalesAntiguo = [];

function multiplesArchivosAntiguos(archivos) {
  var longitud = JSON.parse(archivos);
  //console.log(longitud.length);
  for (var i = 0; i < longitud.length; i++) {
    var imagen = longitud[i];


    //   $(imagen).on("load", function(event){

    var rutaImagen = imagen;

    $(".vistaGaleria").attr("src",rutaImagen);

    archivosTemporalesAntiguo.push(rutaImagen.split(','));
    imagenPermitidoAntiguo = archivosTemporalesAntiguo;
   
    $(".inputAntiguaGaleria").val(archivosTemporalesAntiguo);

    //  })


  } // termina el for

}

/*=============================================
LIMPIAR CAMPOS
=============================================*/

function LimpiarText() {

  formDiccionario.reset();

  $("#idDiccionario").val("");

  $("#txtGuarani").val("");

  $("#txtEspanyol").val("");

  $("#txtOracion").val("");

  // -------CAMPOS DE IMAGENES-------

  $(".inputNuevaGaleria").val("");

  $(".inputGaleria").val("");

  $(".inputAntiguaGaleria").val("");

  $(".inputAntiguaGaleriaEstatica").val("");

  $(".vistaGaleria").val("");

  $(".vistaGaleria").removeAttr("src");

  archivosTemporales = [];

  archivosTemporalesAntiguo = [];
  
}

/*=============================================
VALIDAR TITULO REPETIDO
=============================================*/

// $('#txtTitulo').change(function() {

//   var titulo = $(this).val();


//   var datos = new FormData();
//   datos.append("validarTitulo", titulo);

//   $.ajax({

//     url: "ajax/guias.ajax.php",
//     method: "POST",
//     data: datos,
//     cache: false,
//     contentType: false,
//     processData: false,
//     dataType: "json",
//     success: function(respuesta) {

//       if (respuesta) {

//         $('#txtTitulo').val("");

//         $("#validarTitulo").remove();

//         $('#txtTitulo').after(`

//         <div class="alert alert-warning" id="validarTitulo">
//           <strong>ERROR:</strong>
//           El título ya está registrado, por favor ingrese otro diferente
//         </div>

//         `);

//       return;

//       }else{

//         $("#validarTitulo").remove();

//       }

//     }

//   })

// })

/*=============================================
  MOSTRAR LOADING
=============================================*/

function mostrarLoading(){

  document.getElementById("mostrar_loading").style.display="block";
  document.getElementById("modalBody").style.display="none";

  $("#titulo").html("Guardando...");

  $('#btnGuardar').hide();
  $('#btnCerrar').hide();

}

/*=============================================
  CERRAR LOADING
=============================================*/

function cerrarLoading(){

  document.getElementById("mostrar_loading").style.display="none";
  document.getElementById("modalBody").style.display="block";

  $("#btnGuardar").prop('disabled', false);
  $("#btnCerrar").prop('disabled', false);

  $('#btnGuardar').show();
  $('#btnCerrar').show();

  $('#formDiccionario').trigger("reset");

  $('#modalDiccionarios').modal('hide');

}


