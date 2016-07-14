<?php
/**
 *
 * Laravel 5.1
 *
 * @category LineXTI
 * @package  Core
 * @author   Victor M. Salatiel <ceo@linexti.com.br>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://www.linexti.com.br/
 *
 */
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="">
        <meta name="keywords" content="">     
        <meta name="author" content="">
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!-- Site title -->
        <title>WhatsLine</title>

        <!-- Favicons AND TOUCH ICONS   -->
        <link rel="icon" href="{{ layoutBase('images/favicon.ico') }}">
        <link rel="apple-touch-icon" href="{{ layoutBase('images/apple-touch-icon.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ layoutBase('images/apple-touch-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ layoutBase('images/apple-touch-icon-114x114.png') }}">

        <!-- Font-awesome and Custom Google Web Font -->
        <link href="{{ layoutBase('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ layoutBase('css/et-line.css') }}" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Roboto:100,300,400' rel='stylesheet' type='text/css'>

        <!-- CSS --> 
        <link href="{{ layoutBase('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ layoutBase('css/animate.min.css') }}" rel="stylesheet">
        <link href="{{ layoutBase('css/allinone_carousel.css') }}" rel="stylesheet" type="text/css">
        <!-- social share -->
        <link rel="stylesheet" type="text/css" href="{{ layoutBase('css/jssocials.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ layoutBase('css/jssocials-theme-plain.css') }}" />
        <!-- theme style -->
        <link href="{{ layoutBase('css/style.css') }}" rel="stylesheet">

        <!--[if lt IE 9]>
                                <script src="{{ layoutBase('js/html5shiv.js') }}"></script>
                                <script src="{{ layoutBase('js/respond.min.js') }}"></script>
        <![endif]-->
        <script src="{{ layoutBase('js/modernizr.custom.min.js') }}"></script>

        <!-- Style Switch -->
        <link rel="stylesheet" type="text/css" href="{{ layoutBase('css/colors/green.css') }}" title="green" media="screen" />
    </head>
    <body  id="page-top" data-spy="scroll" data-target=".navbar-custom">
        <!-- preloader -->
        <div class="preloader">
            <div class="status">
                <img src="{{ layoutBase('images/logo.png') }}" alt="Carregando..."/>
            </div>
        </div>


        @yield('content')


        <!-- contact -->
        <section id="contact" class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="titleSection">
                            <h2>Fale <span class="bold">Conosco</span></h2>
                            <div class="coloredLine"></div>
                        </div><!-- titleSection end -->
                    </div><!-- col-md-12 end -->
                </div><!-- row end -->

                <div class="row">
                    <!-- contact form -->
                    <form id="contactForm">
                        <div class="col-md-6 col-md-offset-3">
                            <input  id="name" type="text" class="form-control"  name="name" placeholder="Seu Nome">
                            <input  id="email" type="email" class="form-control"  name="email" placeholder="Seu E-mail" >
                            <textarea class="form-control" id="message"  rows="5" placeholder="Mensagem"></textarea>

                            <button class="btn-new" type="submit" id="submit" name="submit">Enviar Mensagem</button>
                        </div>
                    </form>
                </div><!-- row end -->
            </div><!-- container end -->
        </section><!-- contact end -->

        <footer>
            <div class="container">
                <div class="col-md-12">
                    <a href="#page-top" class="page-scroll"><img src="{{ layoutBase('images/footer-logo.png') }}" alt="WhatsLine"/></a>
                    <div class="space50"></div>
                    <ul  class="clearlist socialList">
                        <li><a href="#"><i class="fa fa-facebook"></i><span class="hidden-xs"> Facebook </span></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i><span class="hidden-xs">Twitter</span></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i><span class="hidden-xs">Linkedin</span></a></li>
                        <li><a href="#"><i class="fa fa-dribbble"></i><span class="hidden-xs">dribbble</span></a></li>
                        <li><a href="#"><i class="fa fa-github"></i><span class="hidden-xs">github</span></a></li>
                    </ul>
                    <hr>
                    <p>&copy; {{ date("Y") }}  <a target="_blank" title="WhatsLine" href="">WhatsLine</a></p>
                </div><!-- col-md-12 end -->
            </div><!-- container end -->
        </footer>

        <!-- javascript Placed at the end of the document so the pages load faster -->
        <script type="text/javascript" src="{{ layoutBase('js/jquery-1.11.3.min.js') }}"></script>
        <script src="{{ layoutBase('js/bootstrap.min.js') }}"></script>
        <script src="{{ layoutBase('js/jquery.easing.min.js') }}"></script>
        <script src="{{ layoutBase('js/jquery.appear.js') }}"></script>
        <script src="{{ layoutBase('js/jquery.inview.js') }}"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
        <script src="{{ layoutBase('js/jquery.ui.touch-punch.min.js') }}" type="text/javascript"></script>
        <script src="{{ layoutBase('js/allinone_carousel.js') }}" type="text/javascript"></script>
        <script src="{{ layoutBase('js/wow.min.js') }}"></script>
        <script src="{{ layoutBase('js/pace.min.js') }}" type="text/javascript"></script>
        <script src="{{ layoutBase('js/jquery.placeholder.min.js') }}" type="text/javascript"></script>
        <script src="{{ layoutBase('js/jquery.ajaxchimp.min.js') }}"></script>
        <script src="{{ layoutBase('js/jssocials.min.js') }}"></script>
        <script src="{{ layoutBase('js/script.js') }}"></script>

        {!! (!empty($script) ? $script : '') !!}

        @yield('post-script')

        <script type="text/javascript" src="http://www.followgram.com.br/chat/php/app.php?widget-init.js"></script>

    </body>
</html>