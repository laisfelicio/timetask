<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by TEMPLATED
http://templated.co
Released for free under the Creative Commons Attribution License

Name       : Embellished 
Description: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20140207

-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TaskingPlay</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="http://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
<link href="default.css" rel="stylesheet" type="text/css" media="all" />
<link href="fonts.css" rel="stylesheet" type="text/css" media="all" />

<!--[if IE 6]><link href="default_ie6.css" rel="stylesheet" type="text/css" /><![endif]-->

</head>
<body>
<div id="wrapper1">
	<div id="header-wrapper">
		<div id="header" class="container">
            <div id="logo"> <span class="icon icon-time"></span>
                    <h1><a href="#">TaskingPlay</a></h1>
			<div id="menu">
				<ul>
					<li class="current_page_item"><a href="#" accesskey="1" title="">Home</a></li>
                    
                    @auth
                        <li><a href="/projetos" accesskey="2" title="">Voltar para a plataforma</a></li>
                    @else
                        <li><a href="/login" accesskey="2" title="">Login</a></li>
                    @endauth
                </ul>
			</div>
		</div>
	</div>
	<div id="wrapper2">
		<div id="welcome" class="container">
			<div class="title">
				<h2>Bem-vindo a nossa plataforma!</h2>
			</div>
			<p>TaskingPlay é uma plataforma de gerenciamento de tarefas que ajuda você e sua equipe a se organizarem no cotidiano!</p>
		</div>
	</div>
	<div id="wrapper3">
		<div id="portfolio" class="container">
			<div class="title">
				<h2>Com o TaskingPlay você pode:</h2>
				</div>
			<div class="column1">
				<div class="box">
					<span class="icon icon-group"></span>
					<h3>Organizar sua equipe</h3>
					<p>Com o TaskingPlay, você pode ter uma visão clara das responsabilidades de cada usuário e também acompanhar o tempo gasto em cada tarefa!</p>
					</div>
			</div>
			<div class="column2">
				<div class="box">
					<span class="icon icon-file"></span>
					<h3>Acessar relatórios</h3>
					<p>Consulte seus dados em nossos relatórios de forma organizada e com fácil visualização! </p>
					</div>
			</div>
			<div class="column3">
				<div class="box">
					<span class="icon icon-play"></span>
					<h3>Registrar o tempo gasto em suas tarefas</h3>
					<p>Com o TaskingPlay você pode cronometrar de forma fácil o tempo gasto em cada tarefa (e alterar manualmente caso se esqueça!).</p>
					</div>
			</div>
			<div class="column4">
				<div class="box">
					<span class="icon icon-plus"></span>
					<h3>E vários outros benefícios!</h3>
					<p>Como gráficos e quadro Kanban que ajudarão no gerenciamento da sua equipe!</p>
					</div>
			</div>
		</div>
	</div>
</div>
<div id="footer" class="container">

</div>
<div id="copyright" class="container">
	<p>&copy; Untitled. All rights reserved. | Photos by <a href="http://fotogrph.com/">Fotogrph</a> | Design by <a href="http://templated.co" rel="nofollow">TEMPLATED</a>.</p>
</div>
</body>
</html>
