<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <meta name="description" content="">
   <meta name="keywords" content="">
   <title>Cunha Advocacia e Consultoria</title>
   <!-- =============== VENDOR STYLES ===============-->
   <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
   <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css">
   <link rel="stylesheet" href="app/css/app.css" id="maincss">
   <!-- ANIMATE.CSS-->
   <link rel="stylesheet" href="vendor/animate.css/animate.min.css">
   <!-- WHIRL (spinners)-->
   <link rel="stylesheet" href="vendor/whirl/dist/whirl.css">
   <!-- URL BASE -->
   <div id="j_urlBase" url-base="{{ URL::to('/') }}/"></div>
</head>

<body>
   <div class="wrapper">
      <div class="block-center mt-xl wd-xl">
         <!-- START panel-->
         <div class="panel panel-dark panel-flat">
            <div class="panel-heading text-center">
               <a href="#">
                  <img src="app/img/logo.png" alt="Image" class="block-center img-rounded">
               </a>
            </div>
            <div class="panel-body">
               <p class="text-center pv">RESETANDO SUA SENHA</p>
               <form role="form">
                  <p class="text-center">
                     Preencha com seu <strong>CPF</strong> para receber instruções sobre como redefinir sua senha.
                  </p>
                  <hr>
                  <div class="form-group has-feedback">
                     <label for="resetInputEmail1" class="text-muted">NUMERO DO CPF</label>
                     <input id="resetInputEmail1" type="email" placeholder="Digite o numero do seu CPF" autocomplete="off" class="form-control">
                     <span class="fa fa-envelope form-control-feedback text-muted"></span>
                  </div>
                  <button type="submit" class="btn btn-danger btn-block">Resetar</button>
               </form>
               <p class="pt-lg text-center">Você lembrou seus dados?</p>
               <a href="{{ URL::to('login') }}" class="btn btn-block btn-default">Logar</a>
            </div>
         </div>
         <!-- END panel-->
         <div class="p-lg text-center">
            <span>&copy;</span>
            <span>{{ date('Y') }}</span>
            <span>-</span>
            <span>vLine - </span>
            <span>Cunha Advocacia e Consultoria</span>
         </div>
      </div>
   </div>
   <!-- =============== VENDOR SCRIPTS ===============-->
   <!-- MODERNIZR-->
   <script src="vendor/modernizr/modernizr.js"></script>
   <!-- JQUERY-->
   <script src="vendor/jquery/dist/jquery.js"></script>
   <!-- JQUERY FORM-->
   <script src="vendor/jquery-form/jquery.form.min.js"></script>
   <!-- BOOTSTRAP-->
   <script src="vendor/bootstrap/dist/js/bootstrap.js"></script>
   <!-- STORAGE API-->
   <script src="vendor/jQuery-Storage-API/jquery.storageapi.js"></script>
   <!-- INPUT MASK-->
   <script src="vendor/jquery.inputmask/dist/jquery.inputmask.bundle.min.js"></script>
   <!-- PARSLEY-->
   <script src="vendor/parsleyjs/dist/parsley.min.js"></script>
   <!-- =============== APP SCRIPTS ===============-->
   <script src="app/js/app.js"></script>
   <script src="app/js/functions.js"></script>
   <script src="app/js/ajax/login.js"></script>
</body>

</html>