<!DOCTYPE html>
<?php
		// Define primeiro e ultimo dia deste mês
		$dti = date("Y-m-01");
		$dtf = date("Y-m-t");
?>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Controle de Estoque</title>
  <link rel="stylesheet" href="materialize.min.css">
  <link href="icones.css" rel="stylesheet">
</head>


<body>
<header>
<nav class="orange darken-4">
<a href="#" data-target="sidenav-left" class="sidenav-trigger left"><i class="material-icons">menu</i></a>
<a class="brand-logo center"><img class="" src="logo.png"></a>
</nav>
</header>
<div class="row">
<ul id="sidenav-left" class="green lighten-2  sidenav sidenav-fixed" style="width: 175px;">
  <li><span class="brand-logo">&#160;&#160;&#160;&eth;</span></li>
  <li><a class="menu sidenav-close" id="entradas">Entradas</a></li>
  <li><a class="menu sidenav-close" id="saidas">Saidas</a></li>
  <li><a class="menu sidenav-close" id="depositos">Depósito</a></li>
  <li><a class="menu sidenav-close" id="material">Material</a></li>
  <li><a class="menu sidenav-close" id="responsavel">Responsável</a></li>
  <li><a class="menu sidenav-close" id="conf">Configurações</a></li>
  <li><div class="divider"></div></li>
  <li><a class="subheader">Relatórios</a></li>
	  <ul id='rels' class=' green lighten-3'>
			<li><a class="menu sidenav-close" id="rel_estoque" args="deposito=0">Estoque</a></li>
			<li><a class="menu sidenav-close" id="rel_entradas" <?php  echo "args='dti=$dti&dtf=$dtf'";  ?> >Entradas</a></li>
			<li><a class="menu sidenav-close" id="rel_saidas" <?php  echo "args='dti=$dti&dtf=$dtf'";  ?> >Saidas</a></li>
		</ul>
</ul>

<ul id='rels' class='dropdown-content green lighten-3'>
    <li><a class="menu sidenav-close" id="rel_estoque" >Estoque</a></li>
	<li><a class="menu sidenav-close" id="rel_entradas">Entradas</a></li>
	<li><a class="menu sidenav-close" id="rel_saidas" >Saidas</a></li>

</ul>

<div class="">

	<div id="conteudo" class="hoverable card-panel white">
		<div class="container">
			<div  >Clique em algum Menu a esquerda</div>

		</div>
	</div>

  </div>


</div>










	<script src="jquery-3.4.1.min.js"></script>
	<script src="materialize.min.js"></script>
	<script src="script.js?<?php echo time(); ?>"></script>
</body>

</html>