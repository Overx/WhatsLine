# vLINE CMS
<small> Sistema <strong>CMS</strong> de site, com módulos administráveis para diversas funcionalidades.</small>

<h3>Modulos</h3>
<ul>
 	<li>Gerenciador CMS</li>
 	<li>Gerenciador de BLOG</li>
	<li>Gestão de usuário CMS</li>
</ul>
 
<h3>Contéudo</h3>
<ul>
	<li><strong>Web site</strong><a href=""></a> </li>
	<li><strong>Tutorial</strong><a href=""></a> </li>
	<li><strong>API Docs</strong><a href=""></a> </li>
	<li><strong>Demo</strong><a href=""></a> </li>
	<li><strong>Vídeos</strong><a href=""></a> </li>
</ul>

##<h3>Tutorial</h3>

###<h4>Configurando .env</h4>
<p>
APP_ENV=local
APP_DEBUG=true
APP_KEY=mevBVBnglq5UsmxXzIAhwmRNTUwR1lfJ

DB_HOST=localhost
DB_DATABASE=bancodedados
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

// Pusher
PUSHER_KEY=
PUSHER_SECRET=
PUSHER_APP_ID=

//Configuração do email
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_FROM=
MAIL_NAME= 
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
</p>

###<h4>Segurança Rotas, por Nível de usuário</h4>
<p>Criei um Middleware bem simples e básico com controle de nível, os níveis do CMS é bem simples, possui 5 valores padrão, sendo:</p>
<ul>
	<li><strong>0 – </strong>Para usuário aguardando ativação</li>
	<li><strong>1 – </strong>Para usuário simples</li>
	<li><strong>2 – </strong>Para moderadores</li>
	<li><strong>3 – </strong>Para administradores</li>
	<li><strong>4 – </strong>Super administradores</li>
</ul> 
<p>Esses níveis você define nas rotas usando group, podendo passar vários valores como array, exemplo:</p>
```
Route::group( ['middleware' => ['auth', 'nivelUser:1|2|3|4'], 'prefix' => 'admin'], function(){
	include_once('Routes/painel.php');
});
```



<h3>Tecnologias</h3>
<ul>
	<li>Laravel 5.1</li>
	<li>jQuery</li>
	<li>JavaScript</li>
	<li>Bootstrap 3</li>
</ul>
 
<h3>Criadores</h3>
<ul>
	<li>Victor Mariano</li>
</ul>