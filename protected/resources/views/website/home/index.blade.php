@extends('website.layout')
@section('content')

<!-- Header -->
<header>
    <nav class="navbar navbar-custom navbar-top navbar-fixed-top sticky-navigation" >
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <!-- LOGO -->
                <a class="navbar-brand nav-logo page-scroll" href="#page-top">
                    <img src="{{ layoutBase('images/logo.png') }}" alt="WAVA"/>
                </a>
            </div>

            <a href="{{ URL::to('register') }}" class="pull-right btn btn-primary btn-register visible-lg">Registrar</a>
            <a href="{{ URL::to('login') }}" class="pull-right btn btn-primary btn-login visible-lg">Login</a>
            <!-- NAVIGATION LINKS -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a class="page-scroll" href="#page-top">Home</a></li>
                    <li><a class="page-scroll" href="#campanhas">Campanhas</a></li>
                    <li><a class="page-scroll" href="#sobre">Sobre</a></li>
                    <li><a class="page-scroll" href="#features">Porque usar?</a></li>
                    <li><a class="page-scroll" href="#planos">Planos</a></li>
                    <li><a class="page-scroll" href="#contact">Contato</a></li>
                    <li><a class="visible-xs" href="{{ URL::to('register') }}">Login</a></li>
                    <li><a class="visible-xs" href="{{ URL::to('login') }}">Registrar</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->

        </div><!-- /.container -->
    </nav>
</header><!-- Header end -->

<section id="intro" >
    <div class="container">
        <div class="row relative">
            <img src="{{ layoutBase('images/hand.png') }}" alt="wava" class="intro-mobile img-responsive"/>
            <div class="col-md-6 col-md-offset-6">
                <h1>WhatsApp em  <span class="bold"> Massa </span></h1>

                <p class="space40">
                    WhatsLine é uma aplicação web para acesso e gerenciamento de contas no WhatsApp. 
					Diversos recursos estão disponíveis como o envio de mensagens, seja de texto, vídeo, 
					imagem, geolocalizaçao, links, áudio, agendamento de tarefas, entre muitos outros.
                </p>                
                <div class="buttons-group">
                    <a href="#planos" class="btn btn-success btn-lg page-scroll">Assinar Agora</a>
                    <a href="#como-funciona" class="btn btn-primary btn-lg page-scroll">Como funciona</a>

                    <div class="pull-right" style="margin-top: 20px; margin-right: 20px;">
                        <a href="">
                            <img src="{{ URL::to('assets/images/brazil.png') }}" style="width: 32px;">
                        </a>
                        <a href="">
                            <img src="{{ URL::to('assets/images/usa.png') }}" style="width: 32px;">
                        </a>   
                    </div>
                </div>
            </div><!-- col-md-6 end -->
        </div><!-- row end -->
    </div><!-- container end -->
</section><!-- intro end -->

<section id="campanhas" class="text-center">
    <div class="screenshot-image">
        <div class="overlay">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <img alt="wava" src="{{ layoutBase('images/big-logo.png') }}" class="img-responsive space100"/>
                        <h2 class="space40">
                            Campanhas de  <span class="bold"> WhatsApp </span> Marketing
                        </h2>
                        <div class="downloadNumber space10"> 
                            <span class="number">7437</span> Clientes
                        </div>
                    </div><!-- col-md-12 end -->
                </div><!-- row end -->
            </div><!-- container end -->
        </div><!-- overlay end -->
    </div><!-- screenshot-image end -->


    <div class="screenshotSlider relative">
        <div class="gradient"></div>

        <div class="containerd">
            <div class="row">
                <div class="col-xs-12">
                    <div class="slider-3d">   

                        <div id="allinone_carousel_sweet">
                            <div class="myloader"></div>
                            <!-- CONTENT -->
                            <ul class="allinone_carousel_list">

                                <li data-title="" data-bottom-thumb="{{ layoutBase('images/sweet/thumbs/1.jpg') }}">
                                	<img src="{{ layoutBase('images/sweet/1.jpg') }}" alt="" />
                                </li>
                                <li data-title="" data-bottom-thumb="{{ layoutBase('images/sweet/thumbs/2.jpg') }}">
                                	<img src="{{ layoutBase('images/sweet/2.jpg') }}" alt="" />
                                </li>
                                <li data-title="" data-bottom-thumb="{{ layoutBase('images/sweet/thumbs/3.jpg') }}">
                                	<img src="{{ layoutBase('images/sweet/3.jpg') }}" alt="" />
                                </li>
                                <li data-title="" data-bottom-thumb="{{ layoutBase('images/sweet/thumbs/4.jpg') }}">
                                	<img src="{{ layoutBase('images/sweet/4.jpg') }}" alt="" />
                                </li>
                                <li data-title="" data-bottom-thumb="{{ layoutBase('images/sweet/thumbs/5.jpg') }}">
                                	<img src="{{ layoutBase('images/sweet/5.jpg') }}" alt="" />
                                </li>
                                <li data-title="" data-bottom-thumb="{{ layoutBase('images/sweet/thumbs/6.jpg') }}">
                                	<img src="{{ layoutBase('images/sweet/6.jpg') }}" alt="" />
                                </li>
                                <li data-title="" data-bottom-thumb="{{ layoutBase('images/sweet/thumbs/7.jpg') }}">
                                	<img src="{{ layoutBase('images/sweet/7.jpg') }}" alt="" />
                                </li>

                            </ul>    


                        </div>


                    </div><!-- slider-3d end -->
                </div><!-- col-md-12 end -->
            </div><!-- row end -->
        </div><!-- container end -->

    </div><!-- screenshotSlider end -->

</section><!-- screenshots end -->

<!-- overview -->
<section id="como-funciona" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titleSection">
                    <h2>Envie mensagens para milhares de usuários <span class="bold">WhatsApp</span>. </h2>
                    <p>
                        Acessando nosso sistema online poderá criar seu seu público alvo, ter sua própria agenda. 
                    </p>
                    <div class="coloredLine"></div>
                </div><!-- titleSection end -->
            </div><!-- col-md-12 end -->
        </div><!-- row end -->

        <div class="row space50">
            <div class="col-md-12">
                <img src="{{ layoutBase('images/mob-bg.jpg') }}" alt="app" class="img-responsive"/>
            </div><!-- col-md-12 end --> 
        </div><!-- row end -->   

        <div class="row">
            <div class="col-md-4 mg-sm-100" >
                <i class=" icon-target bigIcon"></i>
                <h4 class="bold">Alcance seu alvo!</h4>
                <p>
                    Com mais de 450 milhões de usuários no mundo, atinja diretamente o seu alvo.
                </p>
            </div><!-- col-md-4 end -->

            <div class="col-md-4  mg-sm-100" >
                <i class="icon-upload bigIcon"></i>
                <h4 class="bold">Garantia de envio</h4>
                <p>
                    Relatório de entregas em um sistema online para acompanhar os envios.
                </p>
            </div><!-- col-md-4 end -->

            <div class="col-md-4" >
                <i class="icon-megaphone bigIcon"></i>
                <h4 class="bold">Conquiste +Clientes</h4>
                <p>
                    Envie a sua campanha para quantidade de usuários Whatsapp que você desejar
                </p>
            </div><!-- col-md-4 end -->

        </div><!-- row end -->
    </div><!-- container end -->
</section>  <!-- overview end -->

<!-- features -->
<section id="features" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titleSection">
                    <h2>Porque usar <span class="bold">WhatsApp</span> Marketing </h2>
                    <p>
                        Is amazing, modern and clean landing page for showcase your app anything else. 
                    </p>
                    <div class="coloredLine"></div>
                </div><!-- titleSection end -->
            </div><!-- col-md-12 end -->
        </div><!-- row end -->

        <div class="row">
            <div class="col-md-4 leftFeatures">
                <div class="text-right space100">
                    <i class="icon-profile-male bigIcon"></i>
                    <h4 class="bold">38 milhões de usuários</h4>
                    <p>
                        Whatsapp alcança 600 milhões de usuários ativos (fonte g1.globo.com). São 38 milhões de usuários do WhatsApp no Brasil.
                    </p>
                </div><!-- text-right space100 end -->

                <div class="text-right">
                    <i class="icon-clock bigIcon"></i>
                    <h4 class="bold">24 horas por dia</h4>
                    <p>
                        A maioria dos usuários de celulares mantém seus aparelhos ao alcance das mãos 24 horas por dia.
                    </p>
                </div><!-- text-right end -->

            </div><!-- col-md-4 leftFeatures end -->

            <div class="col-md-4">
                <img src="{{ layoutBase('images/features-mob.png') }}" class="img-responsive wow bounceIn" alt="features"  data-wow-duration="1s" data-wow-offset="50" data-wow-delay="0s" />
            </div><!-- col-md-4 end -->

            <div class="col-md-4 rightFeatures">
                <div class="text-left space100">
                    <i class="icon-megaphone bigIcon"></i>
                    <h4 class="bold">Mídia Digital</h4>
                    <p>
                        A maioria das pessoas passa mais tempo acessando seus dispositivos móveis que mídias impressas como jornais e revistas.
                    </p>
                </div><!-- text-left space40 end -->

                <div class="text-left">
                    <i class="icon-global bigIcon"></i>
                    <h4 class="bold">Aplicativo mais popular</h4>
                    <p>
                        O WhatsApp já é o aplicativo mais utilizado pelos brasileiros: está presente em 89% dos smartphones!
                    </p>
                </div><!-- text-left end -->
            </div><!-- col-md-4 rightFeatures end -->

        </div><!-- row end -->
    </div><!-- container end -->
</section>  <!-- features end -->

<!-- share -->
<section id="planos" class="section">
    <div class="container">
        <div class="row">
            <!-- PRICING PLAN -->
            <div class="col-md-4 col-sm-6 margin-bottom-30" data-sr="enter bottom move 50px">
                <div class="pricing-plan text-center">
                    <p class="offer">
                        <span class="currency">R$</span>
                        <span class="price">59<span>.90</span></span>
                        <span class="renew">/mês</span>
                    </p>

                    <div class="pill margin-20">
                        <p>Plano Padrão</p>
                        <hr>
                    </div>

                    <div class="objects">
                        <ul>
                            <li>200 mensagens por dia</li>
                            <li>200 contatos</li>
                            <li>5 Números</li>
                            <li>Suporte Técnico</li>
                        </ul>

                        <a href="{{ URL::to('shop-cart/P101/' . base64_encode(59)) }}" class="btn btn-rounded btn-block">Comprar agora</a>
                    </div>
                </div>
            </div>

            <!-- PRICING PLAN -->
            <div class="col-md-4 col-sm-6 margin-bottom-30" data-sr="enter bottom move 50px wait 0.3s">
                <div class="pricing-plan highlighten text-center">
                    <p class="offer">
                        <span class="currency">R$</span>
                        <span class="price">99<span>.90</span></span>
                        <span class="renew">/mês</span>
                    </p>

                    <div class="pill margin-20">
                        <p>Plano Econômico</p>
                        <hr>
                    </div>

                    <div class="objects">
                        <ul>
                            <li>500 mensagens por dia</li>
                            <li>500 contatos</li>
                            <li>10 Números</li>
                            <li>Suporte Técnico</li>
                        </ul>

                        <a href="{{ URL::to('shop-cart/P102/' . base64_encode(99)) }}" class="btn btn-rounded btn-block">Comprar agora</a>
                    </div>
                </div>
            </div>

            <!-- PRICING PLAN -->
            <div class="col-md-4 col-sm-6 margin-bottom-30" data-sr="enter bottom move 50px wait 0.6s">
                <div class="pricing-plan text-center">
                    <p class="offer">
                        <span class="currency">R$</span>
                        <span class="price">199<span>.99</span></span>
                        <span class="renew">/mês</span>
                    </p>

                    <div class="pill margin-20">
                        <p>Plano corporativo</p>
                        <hr>
                    </div>

                    <div class="objects">
                        <ul>
                       		<li>Mensagens Ilimitados</li>
                            <li>Contatos Ilimitados</li>
                            <li>Números Ilimitados</li>
                            <li>Suporte Técnico</li>
                        </ul>

                        <a href="{{ URL::to('shop-cart/P103/' . base64_encode(199)) }}" class="btn btn-rounded btn-block">Comprar agora</a>
                    </div>
                </div>
            </div>
            
        </div>  <!-- /.row -->
    </div><!-- container end -->
</section>  <!-- share end -->

@endsection

@section('post-script')
<script type="text/javascript">
(function() {

    function baseUrl()
    {
        return $("#_baseURL").attr("data-url") + "/";
    }

    $(document).on('submit', '#_contato', function(){
        $.ajax({
            url: baseUrl() + 'send/email',
            type: 'get',
            data: $(this).serialize(),
            beforeSend: function(){
                $('#_load').addClass('whirl traditional');
            },
            success: function(e){
                $('#_load').removeClass('whirl traditional');
                window.setTimeout(function () {
                    if(e === 'sucesso'){
                        noty_success('Seu e-mail foi enviado com sucesso... ', true);
                    }
                    //$("#debug").html(e);
                }, 3000);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#_load').removeClass('whirl traditional');
                noty_error("Ocorreu um erro ao enviar a solicitação, fale com administrador");
                console.log(textStatus, errorThrown);
            }
        });
        return false;
    });

}());
</script>
@endsection