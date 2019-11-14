<!doctype html>
<!-- identifica o tipo de pagina-->
<html>
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="bootstrap-3-3-7/css/bootstrap.min.css">
		<link rel="stylesheet" href="estilos.css">
			<script src="jquery-3.2.1.min.js"></script>
			<script src="bootstrap-3-3-7/js/bootstrap.min.js"></script>

</head>
<body>
	<!--inicio do menu-->
	<!-- navbar-header para fazer o cabeçalho do menu, 
	button navbar collapsed para esconder e colocar o botao dehamburguer do menu
	-->
	<header>
		<!--indica o inicio do cabeçalho--> 
<nav class="navbar navbar-default">
	<div class="container">
		<div class="navbar-header">	
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
		data-target="#collapse-navbar" aria-expanded="false">
		<!-- por padrao o menu fica fechado false , os leitores de tela localizam isso,
			ou seja define o estado atual do elemento, se esta colapsado ou não  --> 

		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
	<a class="navbar-brand" href="#">TopCasaFina Arquitetura</a>
</div>
<!--fim do navbar-header-->
		<div class="collapse navbar-collapse" id="collapse-navbar">
	<ul class="nav navbar-nav">
		<li><a href="#sobre-nos">Sobre Nós</a></li>
		<li><a href="#nossos-projetos">Nossos Projetos</a></li>
		<li><a href="#depoimentos">Depoimentos</a></li>
		<li><a href="#video">Video Institucional</a></li>
		<li><a href="#contato">Contato</a></li>

	</ul>
</div>
</div>
</nav>
<div class="container">
<div class="topCasaFina-banner">
	<h1>		TopCasaFina Arquitetura </h1>
	<p>Projetando a casa dos sonhos desde 2009</p>
	<button  class="btn btn-primary btn-lg">Contate-nos</button>
	</div>
</div>
</header>
    	<section id="sobre-nos" class="container">
		<h2>Sobre Nós</h2>	
		<div class="row">	
			<img class="img-responsive col-sm-6" src="img/empresa.jpg" alt="Imagem da empresa">
<!--O titulo é o cabecalho do painel e e panel body é o body --> 
			<div class="panel-group " id="paineis-sobre">
				<div class="panel panel-default">
					<div class="panel-heading" data-toggle="collapse" data-target="#primeiro-paragrafo" data-parent="#paineis-sobre">
						<h3 class="panel-title">Desde 1935</h3>
					</div>

					<div class="collapse in" id="primeiro-paragrafo">
						<div class="panel-body">
							A TopCasaFinaArquitetura desde 1935 vem trazendo casas, mansões e prédios lindos para o mundo
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading" data-toggle="collapse" data-target="#segundo-paragrafo" data-parent="#paineis-sobre">
						<h3 class="panel-title">Alegria em colaborar para um mundo mais bonito</h3>
					</div>

					<div id="segundo-paragrafo" class="collapse">
						<div class="panel-body">
							Trazendo alegria para a vida das pessoas que tem dinheiro para gastar.
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading" data-toggle="collapse" data-target="#terceiro-paragrafo" data-parent="#paineis-sobre">
						<h3 class="panel-title">Mais de 300 prêmios em design e em conforto.</h3>
					</div>

					<div id="terceiro-paragrafo" class="collapse">
						<div class="panel-body">
							Mais de 5 milhões de clientes satisfeitos em todo o mundo.
						</div>
					</div>
				
			</div>
			<!--panel -->
		</div>
		<!-- panel-group-->
</div>
	</section>
	<!--sobre nós-->

<div class="jumbotron">
    <div class="container">
        <h3>Mais de 300 prêmios em design e em conforto.</h3>
        <p>Mais de 5 milhões de clientes satisfeitos em todo o mundo.</p>
    </div>
</div>

<section id="nossos-projetos" class="container">

<h2>Nossos Projetos </h2>
<div class="row">
	<div class="col-sm-6 col-md-4 col-lg-3">
		<!-- para evitar conflitos de padings entre o thumbnail e o col-sm, para evitar isso, envolvemos numa div --> 
<figure class="thumbnail ">
      <img src="img/projetos/casa-castelo.png" alt="Foto da casa Castelo">
      <figcaption class="caption">
        <h3>Casa Castelo</h3>
       <p>A casa Castelo é o último lançamento do TopCasaArquitetura, feita para um monge europeu.</p>
  </figcaption>
</figure>
</div>
<div class="col-sm-6 col-md-4 col-lg-3">
<figure class="thumbnail">
      <img src="img/projetos/residencia-ludi.png" alt="Foto da Residencia Ludi">
      <figcaption class="caption">
        <h3>Residência Ludi</h3>
       <p>Residência Ludi é uma das residências mais lindas da região cercada de um lindo lago .</p>
    </figcaption>
</figure>
</div>

<div class="col-sm-6 col-md-4 col-lg-3">
<figure class="thumbnail">
      <img src="img/projetos/casa-lago.png" alt="Foto da casa Lago">
      <figcaption class="caption">
        <h3>Casa Lago</h3>
       <p>A casa Lago é um lindo projeto elaborado por nossos arquitetos.</p> 
         </figcaption>
</figure>
</div>
</div>
<div class="container">
<div class="col-sm-6 col-md-4 col-lg-3">
<figure class="thumbnail">
      <img src="img/projetos/palacio-dionisio.png" alt="Foto do Palácio Dionísio">
      <figcaption class="caption">
        <h3>Foto do Palácio</h3>
       <p>Projeto elaborado por arquitetos europeus, é considerado um dos mais lindios projetos já elaborados no país.</p>        
      </figcaption>
</figure>
</div>
<div class="col-sm-6 col-md-4 col-lg-3">
<figure class="thumbnail">
      <img src="img/projetos/mercado-marapira.png" alt="Foto do Mercado Narapira">
      <figcaption class="caption">
        <h3>Mercado Narapira</h3>
       <p>O mercado Narapira é um exemplo de projeto comercial perfeito. Um projeto diferente de tudo que você já viu. </p>
       </figcaption>
</figure>
</div>
</div>

</section>
<!--section nossos projetos --> 

<section id="depoimentos" class="container">

		<h2 class="container titulo-depoimentos">Depoimentos de Clientes</h2>

		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
				<li data-target="#carousel-example-generic" data-slide-to="1"></li>
				<li data-target="#carousel-example-generic" data-slide-to="2"></li>
				<!-- Se tivessem mais imagens deveriamos adicionar outros itens na lista incluindo o
				data-slide e incluir abaixo outros otens referentes à quantidade de fotos -->
			</ol>

			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<figure class="item active">
					<img src="img/depoimentos/depoimento1.png" alt="Depoimento 1">
					<figcaption class="carousel-caption">
						<h3>Yuri Padilha</h3>
						<p>Gostei muito e achei rápido o serviço.</p>
					</figcaption>
				</figure>
				<figure class="item">
					<img src="img/depoimentos/depoimento2.png" alt="Depoimento 2">
					<figcaption class="carousel-caption">
						<h3>Fernando Stafaneni</h3>
						<p>Excelente trabalho.</p>
					</figcaption>
				</figure>
				<figure class="item">
					<img src="img/depoimentos/depoimento3.png" alt="Depoimento 3">
					<figcaption class="carousel-caption">
						<h3>Caio Sauzas</h3>
						<p>Gostei, competência em primeiro lugar.</p>
					</figcaption>
				</figure>
			</div>

			<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</section>
	<!-- Para deixar video e contato um ao lado do outropara tamanhos de 768 px vamos usar op col sm
	primeiro, vamos envolver a section em uma div --> 
		<div class="container">
			<div class="row">
				<!-- para informar onde começa e onde termina o sistema de grid do bootstrap colocamos o row-->
			<section id="video">
				<div class="col-sm-6">
		
	<h2>Video Institucional</h2>
	<div class="embed-responsive embed-responsive-16by9">
	<iframe width="560" height="315" src="https://www.youtube.com/embed/T882jhftuwE" 
	frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
	</div>
	</section>
	<!--section video-->

	<!--section id="contato" class="container" Substituimos a classe container prela classe col-sm-->
	<section id="contato" class="col-sm-6">
	<h2>Contato</h2>
	<p>Entre em contato conosco</p>
	<form>
		<div class="form-group">
		<label for="contato-name">None: </label>
		<input class="form-control" id="contato-name" type="text" placeholder="Seu nome">
	</div>
	<div class="form-group">
		<label for="contato-email"> E-mail</label>
		<div class="input-group">
		<div class="input-group-addon">@</div>
		<input type="email" class="form-control" id="contato-email"  placeholder="Digite seu email">
	</div>
	</div>
	<div class="grupo-radio">
		<div class="radio">
		<label>
		<input type="radio" name="tipo-pessoa" checked>
		Pessoa Física
		</label>
	</div>
	<div class="radio">
		<label>
		<input type="radio" name=tipo-pessoa>
		Pessoa Jurídica
		</label>
		</div>
	</div>
	<!--


	--><select class="contato-select form-control">
		<option disabled selected>Tipo de Situação</option>
		<option >Casa</option>
		<option >Apartamento</option>
		<option >Mansão</option>
		
	</select>

	<button class="btn btn-primary" type="submit">Enviar</button>
	</form>
	</section>
	<!-- section contato-->
	</div>
	</div>
<footer>
<address>
	<strong>TopCasaFina Arquitetura</strong><br>
	Rua Vergueiro, 3185, Vila Mariana<br>
	São Paulo <br>
	tel(11)5571-3684
</address>
<address>
contato: contato@topcasaarquitetura.com.br		
</address>
</footer>

<script src="bootstrap-3-3-7/js/navbar-animation-fix.js">
	</script>

    </body>
    
   
   
</html>
