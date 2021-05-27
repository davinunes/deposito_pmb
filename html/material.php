<?php

include "database.php";

$atual = secatual($sql);

$nomeSecAtual = nomesec($atual);
// var_dump($nomeSecAtual);
echo "<div class='container'>";

$estoques = estoques();
foreach($estoques as $v){
	// var_dump($v);
	$locais .= "<option value='$v[id_estoque]' $ativo>$v[local]</option>";
	
}

?>
<div class="row">

    <form class="">
	
		<div class="input-field col s12">
          <h4 id="secaoAtual" sec="<?php echo $atual ?>"><?php echo $nomeSecAtual ?> - Cadastrar novo Material</h4>
        </div>
	<div class="row">
        <div class="input-field col s3">
          <input placeholder="999" id="cadcodmat" type="number" >
          <label for="first_name" class="active">Codigo do material</label>
        </div>

        <div class="input-field col s7">
          <input placeholder="Descrição" id="descmat" type="text" >
          <label class="active" for="last_name">Nome/Descrição do Material</label>
        </div>
		<div class="input-field col s1">
          <input placeholder="99" id="idMat" type="text" disabled>
          <label class="active" for="idMat">ID</label>
        </div>
		<div class="input-field col s1">
          <a><i id="sinal" class="material-icons right">exposure_plus_1</i></a>
        </div>

	</div>
	<div class="row">
        <div class="input-field col s2">
          <input placeholder="999" id="codori" type="number" >
          <label for="first_name" class="active">Codigo de Origem</label>
        </div>
		<div class="input-field col s2">
          <input placeholder="999" id="vunitario" type="number" >
          <label class="active" for="vunitario">Valor Unitário</label>
        </div>
	
	<a jaExiste="0" id="addMat" class="right teal darken-1 waves-effect waves-light btn-large">Cadastrar Material</a>
	</div>
    </form>
	
	
	

 </div>
 <div id="listaentradas" class="row">
 
 
 </div>
<?php

echo "</div class='container'>";


 
?>

<!-- Modal Structure -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <h4>Pesquisa de material</h4>
      <p>Digite nome, codigo ou ficha de algum material</p>
    </div>
	<form>
		<div class="input-field">
		  <input metodo="pesquisa_material" id="search1" type="search" class="pesquisa">
		  <label class="label-icon" for="search1"></label>
		  <i class="material-icons">close</i>
		</div>
	  </form>
    <div class="resultado">
      
    </div>
  </div>
  
  <!-- Modal Structure -->
  <div id="modal2" class="modal">
    <div class="modal-content">
      <h4>Pesquisa de PNR</h4>
      <p>Digite endereço do PNR e clique no botão para selecionar</p>
    </div>
	<form>
		<div class="input-field">
		  <input criterio="<?php echo $atual ?>" metodo="pesquisa_pnr" id="search2" type="search" class="pesquisa">
		  <label class="label-icon" for="search1"></label>
		  <i class="material-icons">close</i>
		</div>
	  </form>
    <div class="resultado">
      
    </div>
  </div>