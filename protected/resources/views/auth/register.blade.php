<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <meta name="description" content="">
   <meta name="keywords" content="">
   <title>WhatsLine</title>
   <!-- =============== VENDOR STYLES ===============-->
   <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
   <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css">
   <link rel="stylesheet" href="app/css/app.css" id="maincss">
   <link rel="stylesheet" href="{{ URL::to('vendor/jnotify/jNotify.jquery.css') }}">
   <!-- ANIMATE.CSS-->
   <link rel="stylesheet" href="vendor/animate.css/animate.min.css">
   <!-- WHIRL (spinners)-->
   <link rel="stylesheet" href="vendor/whirl/dist/whirl.css">
   <!-- URL BASE -->
   <div id="j_urlBase" url-base="{{ URL::to('/') }}/"></div>
   <link rel="shortcut icon" href="{{ URL::to('app/img/favicon.png') }}">
</head>

<body>
   <div class="wrapper">
      <div class="block-center mt-xl wd-xl">
         <!-- START panel-->
         <div class="panel panel-dark panel-flat">
            <div class="panel-heading text-center">
               <a href="#">
                  <img src="app/img/logo.png" alt="Cunha Advocacia e Consultoria" class="block-center img-rounded">
               </a>
            </div>
            <div id="j_painel" class="panel-body">
               <div id="debug"></div>
               <p class="text-center pv">INSCRIÇÃO PARA OBTER O ACESSO IMEDIATO.</p>
               <form id="j_registrar" role="form" data-parsley-validate="" novalidate="" class="mb-lg">
                  <div class="form-group has-feedback">
                     <label for="signupInputCPF" class="text-muted">Nome</label>
                     <input name="name" id="signupInputCPF" type="text" placeholder="Primeiro Nome" autocomplete="off" required class="form-control">
                  </div>
                  <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                  <div class="form-group has-feedback">
                     <label for="signupInputCPF" class="text-muted">Sobrenome</label>
                     <input name="last_name" id="signupInputCPF" type="text" placeholder="Seu Sobrenome" autocomplete="off" required class="form-control">
                  </div>                  
                  <div class="form-group has-feedback">
                     <label for="signupInputEmail1" class="text-muted">E-mail</label>
                     <input name="email" id="signupInputEmail1" type="email" placeholder="Seu E-mail" autocomplete="off" required class="form-control">
                     <span class="fa fa-envelope form-control-feedback text-muted"></span>
                  </div>
                  <div class="form-group has-feedback">
                     <label for="signupInputPassword1" class="text-muted">Senha</label>
                     <input name="rg_senha" id="signupInputPassword1" type="password" placeholder="Sua Senha" autocomplete="off" required class="form-control">
                     <span class="fa fa-lock form-control-feedback text-muted"></span>
                  </div>
                  <div class="form-group has-feedback">
                     <label for="signupInputRePassword1" class="text-muted">Repita Senha</label>
                     <input name="rg_rep_senha" id="signupInputRePassword1" type="password" placeholder="Repita Senha" autocomplete="off" required data-parsley-equalto="#signupInputPassword1" class="form-control">
                     <span class="fa fa-lock form-control-feedback text-muted"></span>
                  </div>
                  <div class="clearfix">
                     <div class="checkbox c-checkbox pull-left mt0">
                        <label>
                           <input name="rg_concordo" type="checkbox" value="aceito" required name="agreed">
                           <span class="fa fa-check"></span>Eu concordo com os <a href="#">termos</a>
                        </label>
                     </div>
                  </div>
                  <button type="submit" class="btn btn-block btn-primary mt-lg">Criar nova Conta</button>
               </form>
               <p class="pt-lg text-center">Você já tem uma conta?</p>
               <a href="{{ URL::to('login') }}" class="btn btn-block btn-default">Logar</a>
            </div>
         </div>
         <!-- END panel-->
         <div class="p-lg text-center">
            <span>&copy;</span>
            <span>{{ date('Y') }}</span>
            <span>-</span>
            <span>Whatsline </span>
            <span></span>
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
   <!-- PARSLEY-->
   <script src="vendor/parsleyjs/dist/parsley.min.js"></script>
   <!-- =============== PAGE VENDOR SCRIPTS ===============-->

   <script src="{{ URL::to('vendor/jnotify/jNotify.jquery.min.js') }}"></script>
   <script src="{{ URL::to('vendor/jnotify/jNotify.functions.js') }}"></script>
   
   <!-- TAGS INPUT-->
   <script src="vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
   <!-- CHOSEN-->
   <script src="vendor/chosen_v1.2.0/chosen.jquery.min.js"></script>
   <!-- SLIDER CTRL-->
   <script src="vendor/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js"></script>
   <!-- INPUT MASK-->
   <script src="vendor/jquery.inputmask/dist/jquery.inputmask.bundle.min.js"></script>
   
   <!-- =============== APP SCRIPTS ===============-->
   <script src="app/js/app.js"></script>
   <script src="app/js/functions.js"></script>
   <script src="app/js/ajax/login.js"></script>
</body>

</html>