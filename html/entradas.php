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
          <h4 id="secaoAtual" sec="<?php echo $atual ?>"><?php echo $nomeSecAtual ?> - Entrada de Material</h4>
        </div>
	<div class="row">
        <div class="input-field col s2">
          <input placeholder="" id="codmat" type="text" disabled>
          <label for="first_name" class="active">Material</label>
        </div>
        <div class="input-field col s2">
          <input placeholder="" id="codori" type="text" disabled>
          <label for="first_name" class="active">Origem</label>
        </div>
        <div class="input-field col s6">
          <input id="descmat" type="text" disabled>
          <label class="active" for="last_name">Descrição</label>
        </div>
        <div class="input-field col s1">
			<a id="btn_s_mat" class="waves-effect waves-light btn modal-trigger" href="#modal1"><i class="material-icons">search</i></a>
        </div>
	</div>
	<div class="row">
		<div class="input-field col s2">
			<a id="btn_s_pnr" class="waves-effect waves-light btn modal-trigger" href="#modal2"><i class="material-icons">search</i></a>
        </div>
		<div class="input-field col s8">
          <input id="endpnr" type="text" disabled>
          <label class="active" for="endpnr">Endereço PNR</label>
        </div>
		<div class="input-field col s2">
          <input placeholder="" id="idpnr" type="text" disabled>
          <label for="first_name" class="active">PNR</label>
        </div>
		
	</div>
	
	<div class="row">
		<div class="input-field col s8">
			<label for="selsec" class="active">Selecione Qual Depósito</label>
			<select id='selsec' class='input-field browser-default'>
				<?php echo $locais; ?>
			</select>
		</div>
		<div class="input-field col s4">
          <input placeholder="" id="qdeEntMat" type="number">
          <label for="first_name" class="active">Qde</label>
        </div>
		
	</div>
		
		<div class="input-field col s12">
          <input id="obsEntradaMaterial" type="text">
          <label class="active" for="obsEntradaMaterial">Observações acerca da entrada do material</label>
        </div>
		
    </form>
	
	<a id="enviar_entrada" class="right orange waves-effect waves-light btn-large"><i class="material-icons right">send</i> Enviar dados</a>
	

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