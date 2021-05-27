<?php

include "database.php";
$atual = secatual($sql);

$nomeSecAtual = nomesec($atual);

$deposito = $_GET[deposito];

$estoques = estoques();

foreach($estoques as $v){
	$ativo = $v['id_estoque'] == $deposito ? "selected" : "";
	$locais .= "<option value='$v[id_estoque]' $ativo>$v[local]</option>";
}
$ativo = "0" == $deposito ? "selected" : "";
$locais  .= "<option value=0 $ativo>Todos</option>";

echo "<div class='container'>";


	$sql  =" SELECT e.*, m.descricao, m.codigo as nee, o.codigo as origem, o.preco_unitario as unitario, l.local FROM `siscofis_secao_estoque` e ";
	$sql .=" left join estoque l on e.id_estoque = l.id_estoque ";
	$sql .=" left join siscofis_material_origem o on e.id_siscofis_material_origem = o.id_siscofis_material_origem ";
	$sql .=" left join siscofis_material m on m.id_siscofis_material =  o.id_siscofis_material";
	$sql .=" where ";
	$sql .=" e.id_secao = '$atual' ";
	if($deposito){
		$sql .=" AND e.id_estoque = '$deposito' ";
	}


	
	$result	= DBExecute($sql);
	if(!mysqli_num_rows($result)){

	}else{
		while($retorno = mysqli_fetch_assoc($result)){
			$dados[] = $retorno;
		}
	}
	
	
	
	if($_GET[excel]){
		$dataHora	= date("d-m-Y H:i:s");
		$nome_arquivo = "Relatório de Estoque - $nomeSecAtual - $dataHora";
		header("Content-type: application/vnd.ms-excel");
		header("Content-type: application/force-download");
		header("Content-Disposition: attachment; filename=$nome_arquivo.xls");
		header("Pragma: no-cache");
	}else{

		echo "
			<div class='row'>
				<div class='input-field col s6'>
					<label for='seldep' class='active'>Selecione Qual Depósito</label>
					<select id='seldep' class='input-field browser-default'>";
		echo $locais;
		echo "		</select>
				</div>
				<div class='input-field col s3'>
					<a id='filtraDeposito' url=$_SERVER[PHP_SELF] class='right btn teal' >
						Filtrar Depósito
					</a>
				</div>
				<div class='input-field col s3'>
					<a class='btn right teal' href=$_SERVER[REQUEST_URI]&excel=1>
						Baixar Planilha
					</a>
				</div>
			</div>
			";
	}
	
	
	
	// var_dump($dados);
	echo "<table class='highlight'>";
		echo "<thead>";
			echo "	<tr><th colspan='7' class='center'>PREFEITURA MILITAR DE BRASÍLIA</th></tr>
					<tr><td colspan='7' class='center'>RELATÓRIO DE ESTOQUE DE MATERIAL - $nomeSecAtual</td></tr>
			";
			echo "	<tr>
						<th>NEE/Proposta</th>
						<th>Origem</th> 
						<th>Descrição</th> 
						<th>Unitário</th> 
						<th>Qde</th> 
						<th>Total</th> 
						<th>Depósito</th> 
					</tr>\n";
		echo "</thead>";
	foreach($dados as $linha){
		$total = $linha[quantidade] * $linha[unitario];
		$unitario = str_replace(".",",",$linha[unitario]);
		$quantidade = str_replace(".",",",$linha[quantidade]);
		$total = str_replace(".",",",$total);
		// var_dump($linha);
		echo "<tbody>";
		echo "<tr class=''>
				<td>$linha[nee]</td>
				<td>$linha[origem]</td>
				<td>$linha[descricao]</td> 
				<td>$unitario</td> 
				<td>$quantidade</td> 
				<td>$total</td> 
				<td>$linha[local]</td> 
			</tr>\n";
		echo "</tbody>";
	}
	echo "</table>";
	

?>