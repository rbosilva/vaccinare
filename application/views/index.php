<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Sistema Vaccinare">
        <meta name="author" content="Rodrigo Barbosa">
        <title>Vaccinare</title>
        <link rel="icon" href="<?php echo base_url('assets/images/crianca.png'); ?>" type="image/png" />
        <!-- CSSs -->
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap/bootstrap.min.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/css/datepicker/bootstrap-datepicker3.min.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome/font-awesome.min.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/css/uniform/uniform-default.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/css/select2/select2.min.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/css/select2/select2-bootstrap.min.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/css/datatables/datatables.min.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/css/clockpicker/bootstrap-clockpicker.min.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/css/sb-admin-2.css'); ?>" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0;">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand vaccinare" href="">Vaccinare</a>
                </div>
                <!-- /.navbar-header -->
                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>
                            <?php echo $_SESSION['user_info']['nome']; ?>
                            <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li>
                                <a href="logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->
                <div class="navbar-header sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li class="active">
                                <a href=""><i class="fa fa-home fa-fw"></i> Início</a>
                            </li>
                            <li>
                                <a href="#" data-object="crianca"><i class="fa fa-child fa-fw"></i> Crianças</a>
                            </li>
                            <li>
                                <a href="#" data-object="vacina"><i class="fa fa-medkit fa-fw"></i> Vacinas</a>
                            </li>
                            <li>
                                <a href="#" data-object="controle"><i class="fa fa-calendar fa-fw"></i> Controle de Vacinas</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Início</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Acesso rápido
                            </div>
                            <div class="panel-body">
                                <div class="quick-actions">
                                    <button data-object="crianca" class="btn btn-outline btn-primary"><i class="fa fa-child"></i> Crianças</button>
                                    <button data-object="vacina" class="btn btn-outline btn-primary"><i class="fa fa-medkit"></i> Vacinas</button>
                                    <button data-object="controle" class="btn btn-outline btn-primary"><i class="fa fa-calendar"></i> Controle de Vacinas</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
        <!-- scripts -->
        <!-- jquery -->
        <script src="<?php echo base_url('assets/js/libs/jquery/jquery.min.js'); ?>"></script>
        <!-- uniform -->
        <script src="<?php echo base_url('assets/js/libs/uniform/jquery.uniform.bundled.js'); ?>"></script>
        <!-- bootstrap -->
        <script src="<?php echo base_url('assets/js/libs/bootstrap/bootstrap.min.js'); ?>"></script>
        <!-- select2 -->
        <script src="<?php echo base_url('assets/js/libs/select2/select2.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/libs/select2/select2.pt-BR.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/libs/select2/defaults.js'); ?>"></script>
        <!-- datatables -->
        <script src="<?php echo base_url('assets/js/libs/datatables/datatables.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/libs/datatables/defaults.js'); ?>"></script>
        <!-- datepicker -->
        <script src="<?php echo base_url('assets/js/libs/datepicker/bootstrap-datepicker.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/libs/datepicker/bootstrap-datepicker.pt-BR.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/libs/datepicker/defaults.js'); ?>"></script>
        <!-- mask -->
        <script src="<?php echo base_url('assets/js/libs/mask/jquery.mask.min.js'); ?>"></script>
        <!-- requirejs -->
        <script src="<?php echo base_url('assets/js/libs/requirejs/require.min.js'); ?>"></script>
        <!-- validation -->
        <script src="<?php echo base_url('assets/js/libs/validation/jquery.validation.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/libs/validation/methods_pt.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/libs/validation/messages_pt_BR.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/libs/validation/defaults.js'); ?>"></script>
        <!-- clockpicker -->
        <script src="<?php echo base_url('assets/js/libs/clockpicker/bootstrap-clockpicker.min.js'); ?>"></script>
        <!-- other -->
        <script src="<?php echo base_url('assets/js/functions.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/objects/System.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/extensions.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/sb-admin-2.js'); ?>"></script>
        
    </body>
</html>
