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
        <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome/font-awesome.min.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/css/sb-admin-2.css'); ?>" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Sistema Vaccinare - Login</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post" action="login">
                                <fieldset>
                                    <?php
                                    if (isset($_SESSION['locked_user'])) {
                                        echo "<label>Número de tentativas excedido, favor tentar novamente em $_SESSION[locked_user] minutos.</label>";
                                        session_destroy();
                                    } else if (isset($_SESSION['invalid_user'])) {
                                        echo '<label>Usuário ou senha incorretos.</label>';
                                        session_destroy();
                                    } else if (isset($_SESSION['session_expired'])) {
                                        echo '<label>Desculpe, mas sua sessão expirou. Por favor, efetue o login no sistema novamente.</label>';
                                        session_destroy();
                                    }
                                    ?>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <input name="login" class="form-control" placeholder="Usuário" autofocus required>
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                        <input name="senha" class="form-control" placeholder="Senha" type="password" required>
                                    </div>
                                    <button type="submit" class="btn btn-outline btn-primary">Entrar</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
