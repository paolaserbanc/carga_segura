<!DOCTYPE html>
<html lang="en">

<head>
  <title>Carga Segura Serbanc</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- Material Kit CSS -->
  <link href="<?=base_url('assets/css/material-dashboard.css?v=2.1.0');?>" rel="stylesheet" />
 <script src="<?=base_url('assets/js/jquery.min.js');?>"></script>
</head>

<body>
  <div class="wrapper ">
    <div class="sidebar" data-color="orange" data-background-color="black" ">
      <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"
data-image="<?= base_url('assets/img/sidebar-2.jpg')?>
      Tip 2: you can also add an image using data-image tag
  -->
      <div class="logo">
        <a href="#" class="simple-text logo-mini">
          CS
        </a>
        <a href="#" class="simple-text logo-normal">
          Carga Segura  
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <?php    
           $controlador = $this->controlador;
           $action = $this->action;
           foreach ($this->menu_lista as $grupo => $men) {  
            if ($controlador == $men[0]['controlador']) {
                $class = 'active';
                $collapse = 'show';
            }else{
                $class = '';
                $collapse = '';
            }       
              $i = 0;                   
              if(!empty($grupo)){                
                if($i == 0){  ?>
                    <li class="nav-item <?= $class?> ">
                        <a class="nav-link" data-toggle="collapse" href="#tables<?=$grupo?>">
                          <i class="material-icons"><?= $men[0]['icono'] ?></i>
                          <p> <?= $grupo ?>
                            <b class="caret"></b>
                          </p>
                        </a>
                        <div class="collapse <?= $collapse?>" id="tables<?=$grupo?>">
                          <ul class="nav">
                          <?php } foreach ($this->menu_lista[$grupo] as $m2){ 
                            if ($action == $m2['funcion']) {
                            $classli = 'active';                            
                            }else{
                                $classli = '';
                                if($this->url == $controlador.'/'.$m2['funcion']){
                                $classli = 'active';
                            }
                            }?>
                            <li class="nav-item <?= $classli?> ">
                              <a class="nav-link" href="<?=base_url()?>index.php/<?php echo $m2['controlador'].'/'.$m2['funcion']?>">
                                <span class="sidebar-mini"> <?=$m2['iniciales']?> </span>
                                <span class="sidebar-normal"> <?= $m2['modulo']?>  </span>
                              </a>
                            </li>
                          <?php }  ?>
                          </ul>
                        </div>
                    </li>
                    <?php }
                    else { 
                    foreach ($this->menu_lista[$grupo] as $m2){
                        ?>
                     <li class="nav-item <?= $class?> ">
                        <a class="nav-link" href="#0">
                          <i class="material-icons"><?= $m2['icono']?></i>
                          <p><?= $m2['modulo']?></p>
                        </a>
                      </li>
                    <?php
                    }
                    }
                    $i++;
               // }
                ?>
                 
            <?php
          }
          ?>
     
          
          <!-- your sidebar here -->
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-minimize">
              <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
              </button>
            </div>
            <a class="navbar-brand" href="#pablo">Dashboard</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <form class="navbar-form">
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <button type="submit" class="btn btn-white btn-round btn-just-icon">
                  <i class="material-icons">search</i>
                  <div class="ripple-container"></div>
                </button>
              </div>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="material-icons">dashboard</i>
                  <p class="d-lg-none d-md-block">
                    Stats
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">notifications</i>
                  <span class="notification">5</span>
                  <p class="d-lg-none d-md-block">
                    Some Actions
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Another Notification</a>
                  <a class="dropdown-item" href="#">Another One</a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="#">Profile</a>
                  <a class="dropdown-item" href="#">Settings</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="<?php echo base_url('/index.php/usuarios/logout');?>">Log out</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
     