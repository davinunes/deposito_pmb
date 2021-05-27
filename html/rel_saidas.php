<?php

include "database.php";
$atual = secatual($sql);

$dti = $_GET[dti];
$dtf = $_GET[dtf];
$nomeSecAtual = nomesec($atual);

echo "<div class='container'>";


	$sql  =" SELECT s.*, m.descricao, r.nome as responsavel, p.endereco as pnr, m.codigo as nee, o.codigo as origem, o.preco_unitario as unitario, l.local FROM `saidas` s ";
	$sql .=" left join estoque l on s.id_estoque = l.id_estoque ";
	$sql .=" left join siscofis_material_origem o on s.id_siscofis_material_origem = o.id_siscofis_material_origem ";
	$sql .=" left join siscofis_material m on m.id_siscofis_material =  o.id_siscofis_material";
	$sql .=" left join pnr p on p.id_pnr =  s.id_pnr";
	$sql .=" left join responsavel_retirada r on r.id_responsavel_retirada =  s.id_responsavel_retirada";
	$sql .=" where ";
	$sql .=" s.id_secao = '$atual' ";


	
	$result	= DBExecute($sql);
	if(!mysqli_num_rows($result)){

	}else{
		while($retorno = mysqli_fetch_assoc($result)){
			$dados[] = $retorno;
		}
	}
	
	if($_GET[excel]){
		$dataHora	= date("d-m-Y H:i:s");
		$nome_arquivo = "Relatório de Entradas - $nomeSecAtual - $dataHora";
		header("Content-type: application/vnd.ms-excel");
		header("Content-type: application/force-download");
		header("Content-Disposition: attachment; filename=$nome_arquivo.xls");
		header("Pragma: no-cache");
	}else{

		echo "
			<div class='row'>
				<div class='input-field col s3'>
					<input id='dti' type='date' value='$dti'>
					<label for='first_name' class='active'>Filtrar data inicio</label>
				</div>
				<div class='input-field col s3'>
					<input id='dtf' type='date' value='$dtf'>
					<label for='first_name' class='active'>Filtrar data fim</label>
				</div>
				<div class='input-field col s3'>
					<a url=$_SERVER[PHP_SELF] class='right btn teal filtro' >
						Filtrar Datas
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
			echo "	<tr><th colspan='12' class='center'>PREFEITURA MILITAR DE BRASÍLIA</th></tr>
					<tr><td colspan='12' class='center'>RELATÓRIO DE SAÍDA DE MATERIAL - $nomeSecAtual</td></tr>
			";
			echo "	<tr>
						<th>Data</th>
						<th>NEE/Proposta</th>
						<th>Origem</th> 
						<th>Descrição</th>
						<th>Depósito</th>
						<th>PNR</th>
						<th>Responsável</th>
						<th>Unitário</th>
						<th>Qde</th> 
						<th>Total</th> 
						
					</tr>\n";
		echo "</thead>";
	foreach($dados as $linha){
		$total = $linha[quantidade] * $linha[unitario];
		$unitario = str_replace(".",",",$linha[unitario]);
		$quantidade = str_replace(".",",",$linha[quantidade]);
		$total = str_replace(".",",",$total);
		$data = date( "d/m/Y", strtotime( $linha[data_hora_cadastro] ) );
		// var_dump($linha);
		echo "<tbody>";
		echo "<tr class=''>
				<td>$data</td>
				<td>$linha[nee]</td>
				<td>$linha[origem]</td>
				<td>$linha[descricao]</td>
				<td>$linha[local]</td>
				<td>$linha[pnr]</td>
				<td>$linha[responsavel]</td>
				<td>$unitario</td> 
				<td>$quantidade</td> 
				<td>$total</td> 
				 
			</tr>\n";
		echo "</tbody>";
	}
	echo "</table>";
	

	
	
	
	

?>