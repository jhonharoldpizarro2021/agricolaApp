<?php
 session_start();
 ob_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>TIERRA DULCE</title>
    <link rel="icon" type="image/png" href="images/favicon.png" />
    <link rel="stylesheet" type="text/css" media="screen" href="extensions/bootstrap/css/bootstrap.css?n=<?= time() ?>" />
    <link href="extensions/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <!-- <link href="css/timeline.css" rel="stylesheet"> -->
    <link href="css/style.css?n=<?= time() ?>" rel="stylesheet">
<!--     <link href="extensions/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet"> -->    
    <link href="extensions/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link href="extensions/datepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->  
    <!-- jQuery -->
    <script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
    <script type="text/javascript" src="extensions/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="extensions/datepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>    
    <!-- Metis Menu Plugin JavaScript -->
    <script src="extensions/metisMenu/dist/metisMenu.min.js"></script>
    <link rel="stylesheet" href="extensions/metisMenu/dist/animate.css">
    <!-- jAlert JavaScript -->
    <script src="extensions/jAlert/js/jquery.ui.draggable.js"></script>
    <script>
        jQuery.browser = {};
        (function () {
            jQuery.browser.msie = false;
            jQuery.browser.version = 0;
            if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
                jQuery.browser.msie = true;
                jQuery.browser.version = RegExp.$1;
            }
        })();
    </script>
    <script src="extensions/jAlert/js/jquery.alerts.js"></script>
    <link href="extensions/jAlert/css/jquery.alerts.css" rel="stylesheet" media="screen">
    <link href="extensions/xeditable/css/bootstrap-editable.css" rel="stylesheet">
    <script src="extensions/xeditable/js/bootstrap-editable.js"></script>
    <script type="text/javascript" src="extensions/datepicker/js/locales/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
<!-- DataTables JavaScript -->
    <script src="extensions/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="extensions/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    <script src="js/bootstrap-editable.js" type="text/javascript"></script> 
<!-- maskmoney-->
    <script src="extensions/maskmoney/jquery.maskMoney.js" type="text/javascript"></script>
<!-- bootstrap show password -->
    <script src="extensions/bootstrap-show-password/bootstrap-show-password.min.js"></script>
<!-- google maps api -->
    <script  type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6f6NhqQZzhOikkwwKB4cy2ZhysMq9O_A"></script>
 
    
</head>
<body>
<?php
 include "functions.php";
 if( !session_valida() )
 {
   header("Location: cerrar_sesion.php");
 }
?>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;">
            <div class="navbar-header">
                <a class="navbar-brand" href="http://186.147.163.175/home.php">
                    <h1 class="titulo"><img class="logo" src="images/logo.png"></h1>
                </a>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right" id="nav">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 1</strong>
                                        <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 2</strong>
                                        <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 3</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 4</strong>
                                        <span class="pull-right text-muted">80% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Tasks</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="cerrar_sesion.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            <!-- /.navbar-top-links -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search animated fadeInLeft">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Buscar...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li class="animated fadeInLeft">
                            <a href="#" ><i class="fa fa-cogs fa-fw"></i> Par&aacute;metros Basicos<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level " >
                                <li>
                                    <a href="usuarios.php"><i class="fa fa-key fa-fw"></i> Usuarios</a>
                                </li>
                                <li class="animated fadeInLeft">
                                    <a href="unidades-agricolas.php"><i class="fa fa-road fa-fw"></i> Unidades Agricolas</a>
                                </li>
                                <li class="animated fadeInLeft">
                                    <a href="labores.php"><i class="fa fa-calendar fa-fw"></i> Labores</a>
                                </li>
                                <li class="animated fadeInLeft">
                                    <a href="maquinaria-herramienta.php"><i class="fa fa-wrench fa-fw"></i> Maquinaria/Herramienta</a>
                                </li>
                                <li class="animated fadeInLeft">
                                    <a href="insumos.php"><i class="fa fa-plug fa-fw"></i> Insumos</a>
                                </li>
                                <li class="animated fadeInLeft">
                                    <a href="costos-directos.php"><i class="fa fa-calculator fa-fw"></i> Costos Directos</a>
                                </li>
                                <li class="animated fadeInLeft">
                                    <a href="costos-indirectos.php"><i class="fa fa-credit-card fa-fw"></i> Costos Indirectos</a>
                                </li>
                                <li class="animated fadeInLeft">
                                    <a href="#"><i class="fa fa-users fa-fw"></i> Personal</a>
                                    <ul class="nav nav-third-level" >
                                        <li class="animated fadeInLeft">
                                            <a href="personal.php"><i class="fa fa-list-alt fa-fw"></i> Lista de Empleados</a>
                                        </li>
                                        <li class="animated fadeInLeft">
                                            <a href="eps.php"><i class="fa fa-ambulance fa-fw"></i> EPS</a>
                                        </li>
                                        <li class="animated fadeInLeft">
                                            <a href="arl.php"><i class="fa fa-medkit fa-fw"></i> ARL</a>
                                        </li>
                                        <li class="animated fadeInLeft">
                                            <a href="pension.php"><i class="fa fa-wheelchair fa-fw"></i> Pensi&oacute;n</a>
                                        </li>
                                    </ul>
                                </li>                                
                                <li class="animated fadeInLeft">
                                    <a href="proveedores.php"><i class="fa fa-truck fa-fw"></i> Proveedores</a>
                                </li>
                                <li class="animated fadeInLeft">
                                    <a href="medidas.php"><i class="fa fa-exchange fa-fw"></i> Unidades de Medida</a>
                                </li>
                                <li class="animated fadeInLeft">
                                    <a href="tiempo-medida.php"><i class="fa fa-clock-o fa-fw"></i> Unidades de Tiempo Medida</a>
                                </li>
                                <li class="animated fadeInLeft">
                                    <a href="estaciones_pluviometria.php"><i class="fa fa-tint fa-fw"></i> Estaciones Pluviometria</a>
                                </li>
                            </ul>
                        </li>
                        <li class="animated fadeInLeft">
                            <a href="planificacion-cosechas.php"><i class="fa fa-pie-chart fa-fw"></i> Planificaci&oacute;n de Cosechas</a>
                        </li>
                        <li class="animated fadeInLeft">
                            <a href="prontuario.php"><i class="fa fa-binoculars fa-fw"></i> Prontuario</a>
                        </li>
                        <li class="animated fadeInLeft">
                            <a href="registro_pluviometria.php"><i class="fa fa-tint fa-fw"></i> Registro Pluviometría</a>
                        </li>
                        <li class="animated fadeInLeft">
                            <a href="registro_costos_indirectos.php"><i class="fa fa-credit-card fa-fw"></i> Registro de Costos Indirectos</a>
                        </li>
                        <li class="animated fadeInLeft">
                            <a href="seguimiento_labores.php"><i class="fa fa-eye fa-fw"></i> Seguimiento de Labores</a>
                        </li>
                        <li class="animated fadeInLeft">
                            <a href="nomina.php"><i class="fa fa-money fa-fw"></i> N&oacute;mina</a>
                        </li>
                        <li class="animated fadeInLeft">
                            <a href="#"><i class="fa fa-bar-chart fa-fw"></i> Informes <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level" >
                                <li class="animated fadeInLeft">
                                    <a href="consumo_combustible.php"><i class="fa fa-battery-full fa-fw"></i> Consumo de Combustible</a>
                                </li>
                                <li class="animated fadeInLeft">
                                    <a href="informe_pluviometria_anio_mes.php"><i class="fa fa-eyedropper fa-fw"></i> Pluviometría Año -vs- Mes</a>
                                </li>
                                <li class="animated fadeInLeft">
                                    <a href="rendimiento_vs_variedad.php"><i class="fa fa-pie-chart fa-fw"></i> Rendimiento -vs- Variedad</a>
                                </li>
                                <li class="animated fadeInLeft">
                                    <a href="tc_vs_corte.php"><i class="fa fa-archive fa-fw"></i> T.C. -vs- Corte</a>
                                </li>
                                <li class="animated fadeInLeft">
                                    <a href="tchm_vs_corte.php"><i class="fa fa-cubes fa-fw"></i> T.C.H.M. -vs- Corte</a>
                                </li>
                                <li class="animated fadeInLeft">
                                    <a href="tc_vs_variedad.php"><i class="fa fa-industry fa-fw"></i> T.C. -vs- Variedad</a>
                                </li>
                                <li class="animated fadeInLeft">
                                    <a href="tchm_vs_variedad.php"><i class="fa fa-object-group fa-fw"></i> T.C.H.M. -vs- Variedad</a>
                                </li>
                                <li class="animated fadeInLeft">
                                    <a href="informe_costos.php"><i class="fa fa-calculator fa-fw"></i> Costos</a>
                                </li>
                                <li class="animated fadeInLeft">
                                    <a href="#"><i class=""></i> </a>
                                </li>
                                <li class="animated fadeInLeft">
                                    <a href="#"><i class=""></i> </a>
                                </li>  
                                <li class="animated fadeInLeft">
                                    <a href="#"><i class=""></i> </a>
                                </li>
                                <li class="animated fadeInLeft">
                                    <a href="#"><i class=""></i> </a>
                                </li> 
                            </ul>
                        </li>
                        <li class="animated fadeInLeft">
                            <a href="#resultados-produccion.php"><i class="fa fa-file-text fa-fw"></i> Resultados de Producci&oacute;n</a>
                        </li>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
