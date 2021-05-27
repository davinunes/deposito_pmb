<?php

include "database.php";

$atual = secatual($sql);

$idSecAtual = $atual[id_secao];
$nomeSecAtual = nomesec($atual);
// var_dump($nomeSecAtual);
echo "<div class='container'>";

?>

<div class="row">

    <form class="">
	
		<div class="input-field col s12">
          <h4 id="secaoAtual" sec="<?php echo $atual ?>"><?php echo $nomeSecAtual ?></h4>
        </div>
	<div class="row">
        <div class="input-field col s2">
          <input placeholder="" id="id_local" type="text" disabled>
          <label for="first_name" class="active">ID</label>
        </div>

        <div class="input-field col s8">
          <input id="nome_local" type="text" >
          <label class="active" for="last_name">Nome do local</label>
        </div>
        <div class="input-field col s1">
			<a id="btn_e_send" class="blue darken-3 waves-effect waves-light btn">Adicionar<i class="material-icons">send</i></a>
        </div>
	</div>
	
		
    </form>
	

 </div>
 <div id="listaResponsaveis" class="row">
 
	<?php echo listalocais(); ?>
 
 </div>