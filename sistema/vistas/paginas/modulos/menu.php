<aside class="main-sidebar sidebar-light-primary elevation-4">

  <!--=====================================
  LOGO
  ======================================-->
  <a href="inicio" class="brand-link">

    <!-- <i class="fa fa-book fa-3x"></i> -->
  
    <img src="vistas/img/plantilla/traducciones.png" width="200px" height="80px" style="opacity: .8">

  <!--   <span class="brand-text font-weight-light">Inlocam</span> -->

  </a>

  <!--=====================================
  MENÚ
  ======================================-->

  <div class="sidebar">

    <nav class="mt-2">
      
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <!-- botón Ver sitio -->

        <li class="nav-item">
          
          <a href="<?php echo $ruta; ?>" class="nav-link " target="_blank">
            <!-- <a href="http://localhost/diccionario_guarani/inicio" class="nav-link " target="_blank"> -->
            
            <i class="nav-icon fas fa-globe"></i>
            
            <p>Sitio de Traducciones</p>

          </a>

        </li>

        <!-- Botón página inicio -->

        <li class="nav-item">

          <a href="inicio" class="nav-link">

            <i class="nav-icon fas fa-home"></i>

            <p>Inicio</p>

          </a>

        </li>

        <?php if ($admin["nombre_perfil"] == "ADMINISTRADOR"): ?>

        <!-- Botón página usuarios -->
          
          <li class="nav-item">

            <a href="usuarios" class="nav-link">

              <i class="nav-icon fas fa-users-cog"></i>

              <p>Administrar Usuarios</p>

            </a>

          </li>

        <?php endif ?>

        <!-- Botón página perfiles -->

        <li class="nav-item">
          
          <a href="perfiles" class="nav-link">
            
            <i class="nav-icon fa fa-users"></i>
            
            <p>Administrar Perfiles</p>
          
          </a>

        </li>

      
        <!-- Botón página ciudades -->

        <li class="nav-item">
          
          <a href="ciudades" class="nav-link">
            
            <i class="nav-icon fa fa-map"></i>
            
            <p>Administrar Ciudades</p>
          
          </a>

        </li>
       

        <!-- Botón página Diccionario -->

        <li class="nav-item">
          
          <a href="diccionario" class="nav-link">
            
            <i class="nav-icon fa fa-book fa-3x"></i>
            
            <p>Administrar Diccionario</p>
          
          </a>

        </li>

    </ul>

    </nav>
  
  </div>

</aside>