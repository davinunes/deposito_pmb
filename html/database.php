<?php

define('DB_HOSTNAME', 'localhost');
define('DB_DATABASE', 'deposito_pmb');
define('DB_USERNAME', 'deposito');
define('DB_PASSWORD', 'SUA_SENHA');
define('DB_PREFIX', '');
define('DB_CHARSET', 'utf8');

function DBConnect(){ # Abre Conexão com Database
	$link = @mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die(mysqli_connect_error());
	mysqli_set_charset($link, DB_CHARSET) or die(mysqli_error($link));
	return $link;
}

function DBClose($link){ # Fecha Conexão com Database
	@mysqli_close($link) or die(mysqli_error($link));
}

function DBEscape($dados){ # Proteje contra SQL Injection
	$link = DBConnect();
	
	if(!is_array($dados)){
		$dados = mysqli_real_escape_string($link,$dados);
	}else{
		$arr = $dados;
		foreach($arr as $key => $value){
			$key	= mysqli_real_escape_string($link, $key);
			$value	= mysqli_real_escape_string($link, $value);
			
			$dados[$key] = $value;
		}
	}
	DBClose($link);
	return $dados;
}

function DBExecute($query){ # Executa um Comando na Conexão
	$link = DBConnect();
	$result = mysqli_query($link,$query) or die(mysqli_error($link));
	
	DBClose($link);
	return $result;
}

function DBCommit($query1, $query2){ # Executa um Comando na Conexão
	$link = DBConnect();
	$result = mysqli_begin_transaction($link);
	$result = mysqli_query($link,$query1) or die(mysqli_error($link));
	$result = mysqli_query($link,$query2) or die(mysqli_error($link));
	$result = mysqli_commit($link);
	DBClose($link);
	return $result;
}

//https://github.com/tazotodua/useful-php-scripts
function EXPORT_TABLES($tables=false, $backup_name=false ){
    $mysqli = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE); 
	$mysqli->select_db(DB_DATABASE); $mysqli->query("SET NAMES 'utf8'");
    $queryTables = $mysqli->query('SHOW TABLES'); 
	while($row = $queryTables->fetch_row()) { $target_tables[] = $row[0]; }   
	if($tables !== false) { $target_tables = array_intersect( $target_tables, $tables); }
    foreach($target_tables as $table){
        $result = $mysqli->query('SELECT * FROM '.$table);  
		$fields_amount=$result->field_count;  
		$rows_num=$mysqli->affected_rows;     
		$res = $mysqli->query('SHOW CREATE TABLE '.$table); 
		$TableMLine=$res->fetch_row();
        $content = (!isset($content) ?  '' : $content) . "\n\n".$TableMLine[1].";\n\n";
        for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) {
            while($row = $result->fetch_row())  { //when started (and every after 100 command cycle):
                if ($st_counter%100 == 0 || $st_counter == 0 )  {$content .= "\nINSERT INTO ".$table." VALUES";}
                    $content .= "\n(";
                    for($j=0; $j<$fields_amount; $j++)  { 
						$row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); 
						if (isset($row[$j])){$content .= '"'.$row[$j].'"' ; }else {$content .= '""';}     
						if ($j<($fields_amount-1)){$content.= ',';}      }
                    $content .=")";
                //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) {$content .= ";";} else {$content .= ",";} 
				$st_counter=$st_counter+1;
            }
        } $content .="\n\n\n";
    }
    $backup_name = $backup_name ? $backup_name : DB_DATABASE."_(".date('H-i-s')."_".date('d-m-Y').")_".rand(1,11111111).".sql";
    header('Content-Type: application/octet-stream');   
	header("Content-Transfer-Encoding: Binary"); 
	header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
	return $content; 
}

function secs(){
	$sql  ="SELECT id_secao, secao FROM `secao` ";

	$result	= DBExecute($sql);

	if(!mysqli_num_rows($result)){

	}else{
		while($retorno = mysqli_fetch_assoc($result)){
			$dados[] = $retorno;
		}
	}
	return $dados;
}

function estoques(){
	$sql  ="SELECT * FROM `estoque` ";

	$result	= DBExecute($sql);

	if(!mysqli_num_rows($result)){

	}else{
		while($retorno = mysqli_fetch_assoc($result)){
			$dados[] = $retorno;
		}
	}
	return $dados;
}

function listaResponsaveis(){
	$sql  ="SELECT * FROM `responsavel_retirada`";

	$result	= DBExecute($sql);

	if(!mysqli_num_rows($result)){

	}else{
		while($retorno = mysqli_fetch_assoc($result)){
			$dados[] = $retorno;
		}
	}
	
		$retorno = "<table class='highlight'>";
		foreach($dados as $linha){
			$retorno .=  "<tr class=''>
					<td>$linha[id_responsavel_retirada]</td>
					<td>$linha[nome]</td>
					<td><a 
						id_responsavel_retirada='$linha[id_responsavel_retirada]' 
						nome='$linha[nome]' 
						class='btn-floating right editResponsavel'><i 
					<i class='material-icons'>edit</i></a></td>
				</tr>\n";
		}
		$retorno .=  "</table>";
		return $retorno;
}

function listaLocais(){
	$sql  ="SELECT * FROM `estoque`";

	$result	= DBExecute($sql);

	if(!mysqli_num_rows($result)){

	}else{
		while($retorno = mysqli_fetch_assoc($result)){
			$dados[] = $retorno;
		}
	}
	
		$retorno = "<table class='highlight'>";
		foreach($dados as $linha){
			$retorno .=  "<tr class=''>
					<td>$linha[id_estoque]</td>
					<td>$linha[local]</td>
					<td><a 
						id_estoque='$linha[id_estoque]' 
						local='$linha[local]' 
						class='btn-floating right editLocal'><i 
					<i class='material-icons'>edit</i></a></td>
				</tr>\n";
		}
		$retorno .=  "</table>";
		return $retorno;
}

function selectResponsaveis(){
	$sql  ="SELECT * FROM `responsavel_retirada`";

	$result	= DBExecute($sql);

	if(!mysqli_num_rows($result)){

	}else{
		while($retorno = mysqli_fetch_assoc($result)){
			$dados[] = $retorno;
		}
	}
		$selresp = "<option value='0' ></option>";
		foreach($dados as $linha){
			
			$selresp .= "<option value='$linha[id_responsavel_retirada]' >$linha[nome]</option>";
		}
		return $selresp;
}

function checkEstoque($origem){
	$sql  ="SELECT `quantidade` FROM `siscofis_secao_estoque` WHERE `id_siscofis_material_origem` = '$origem'";

	$result	= DBExecute($sql);
	if(!mysqli_num_rows($result)){
		return false;
	}else{
		return true;
	}
}

function secatual(){
	$sql  ="SELECT * FROM `secao_atual` ";

	$result	= DBExecute($sql);

	if(!mysqli_num_rows($result)){

	}else{
		while($retorno = mysqli_fetch_assoc($result)){
			$dados[] = $retorno;
		}
	}
	return $dados[0][id_secao];
}

function nomesec($id){
	$sql  ="SELECT secao FROM `secao` where id_secao = $id";

	$result	= DBExecute($sql);

	if(!mysqli_num_rows($result)){

	}else{
		while($retorno = mysqli_fetch_assoc($result)){
			$dados[] = $retorno;
		}
	}
	return $dados[0][secao];
}

if($_POST['metodo'] == "setsec"){
	$valor = $_POST['newsec'];
	
	$sql  ="update `secao_atual` set `id_secao` = $valor WHERE `id_secao_atual` = 1";
	
	if(DBExecute($sql)){
		echo "ok";
	}else{
		echo "erro";
	}
	
}

if($_POST['metodo'] == "updateResp"){
	$nome = $_POST['nome'];
	$id = $_POST['id'];
	
	$sql  ="UPDATE `responsavel_retirada` SET `nome`='$nome' WHERE `id_responsavel_retirada`='$id'";
	
	if(DBExecute($sql)){
		echo "ok";
	}else{
		echo "erro";
	}
}

if($_POST['metodo'] == "updateLocal"){
	$local = $_POST['local'];
	$id = $_POST['id'];
	
	$sql  ="UPDATE `estoque` SET `local`='$local' WHERE `id_estoque`='$id'";
	
	if(DBExecute($sql)){
		echo "ok";
	}else{
		echo "erro";
	}
}

if($_POST['metodo'] == "insertResp"){
	$nome = $_POST['nome'];
	$id = $_POST['id'];
	
	$sql  = "INSERT INTO `responsavel_retirada` (`bol_ativo`, `nome`) VALUES (1,'$nome')";
	
	if(DBExecute($sql)){
		echo "ok";
	}else{
		echo "erro";
	}
}

if($_POST['metodo'] == "insertLocal"){
	$local = $_POST['local'];
	$id = $_POST['id'];
	
	$sql  = "INSERT INTO `estoque` (`bol_ativo`, `local`) VALUES (1,'$local')";
	
	if(DBExecute($sql)){
		echo "ok";
	}else{
		echo "erro";
	}
}

if($_POST['metodo'] == "pesquisa_material"){
	$palavra = $_POST['palavra'];
	
	$sql  =" select m.*, o.id_siscofis_material_origem, o.id_siscofis_material_origem as cod_origem, o.codigo as origem from siscofis_material m ";
	$sql .=" left join siscofis_material_origem o on o.id_siscofis_material = m.id_siscofis_material";
	$sql .=" where ";
	$sql .=" m.descricao like '%$palavra%'  ";
	$sql .=" OR m.codigo = '$palavra'  ";
	$sql .=" OR o.codigo = '$palavra'  ";
	$sql .=" limit 40  ";
	
	$result	= DBExecute($sql);
	if(!mysqli_num_rows($result)){

	}else{
		while($retorno = mysqli_fetch_assoc($result)){
			$dados[] = $retorno;
		}
	}
	
	echo "<table class='highlight'>";
	echo "	<tr>
				<th>Cod Material</th>
				<th>Cod Origem</th>
				<th>Descrição</th>
				<th>Selecionar</th>
			</tr>";
	foreach($dados as $linha){
		echo "<tr class=''>
				<td>$linha[codigo]</td>
				<td>$linha[origem]</td>
				<td>$linha[descricao]</td> 
				<td><a 
					idmaterial='$linha[id_siscofis_material]' 
					nomemat='$linha[descricao]' 
					codigo='$linha[codigo]' 
					origem='$linha[cod_origem]'
					origem_cod='$linha[origem]'
					class='btn-floating setmaterial modal-close'><i class='material-icons'>check</i></a>
				</td>
			</tr>\n";
	}
	echo "</table>";
	
}

if($_POST['metodo'] == "pesquisa_pnr"){
	$palavra = $_POST['palavra'];
	$secao = $_POST['criterio'];
	
	$sql  =" select * from pnr ";
	$sql .=" where ";
	$sql .=" endereco like '%$palavra%'  ";
	$sql .=" AND id_secao = '$secao'  ";
	
	$result	= DBExecute($sql);
	if(!mysqli_num_rows($result)){

	}else{
		while($retorno = mysqli_fetch_assoc($result)){
			$dados[] = $retorno;
		}
	}
	
	echo "<table class='highlight'>";
	foreach($dados as $linha){
		// var_dump($linha);
		echo "<tr class=''>
				<td>$linha[id_pnr]</td>
				<td>$linha[endereco]</td>
				<td>$linha[pnr_destinacao]</td> 
				<td><a 
					id_pnr='$linha[id_pnr]' 
					endereco='$linha[endereco]' 			
					class='btn-floating setpnr modal-close'><i class='material-icons'>check</i></a></td>
			</tr>\n";
	}
	echo "</table>";
	
}

if($_POST['metodo'] == "insere_entrada"){
	
	$dataHora	= date("Y-m-d H:i:s");

	$idOrigem 	= $_POST['idOrigem'];
	$idPnr 		= $_POST['idPnr'];
	$local 		= $_POST['local'];
	$qdeEntMat 	= $_POST['qdeEntMat'];
	$obs   		= $_POST['obs'];
	$secao 		= $_POST['secao'];
	
	$sql  = " INSERT INTO `entradas` ";
	$sql .= " (`descricao`, `id_usuario_cadastro`, `quantidade`, `id_secao`, `id_siscofis_material_origem`, `id_estoque`, `id_pnr`, `data_hora_cadastro`) ";
	$sql .= " VALUES ";
	$sql .= " ('$obs', '1', '$qdeEntMat', '$secao', '$idOrigem', '$local', ";
	if($idPnr == ""){
		$sql .= "NULL";
	}else{
		$sql .= "'$idPnr'";
	}
	$sql .= ", '$dataHora') ";
	
	if(checkEstoque($idOrigem)){
		$sql2  = " UPDATE `siscofis_secao_estoque` ";
		$sql2 .= " SET ";
		$sql2 .= " `quantidade` = `quantidade` + $qdeEntMat ";
		$sql2 .= " WHERE ";
		$sql2 .= " `id_siscofis_material_origem` = '$idOrigem'";
		
		if(DBExecute($sql2)){
			$inEstoque =  true;
		}else{
			$inEstoque =  false;
		}
	}else{
		$sql2  = " INSERT INTO `siscofis_secao_estoque` ";
		$sql2 .= " (`quantidade`, `id_secao`, `id_siscofis_material_origem`, `id_estoque`) ";
		$sql2 .= " VALUES ";
		$sql2 .= " ('$qdeEntMat','$secao','$idOrigem','$local') ";
		
		if(DBExecute($sql2)){
			$inEstoque =  true;
		}else{
			$inEstoque =  false;
		}
		
	}
	
	
	if(DBExecute($sql)){
		$Entrada =  true;
	}else{
		$Entrada =  false;
	}
	
	if($inEstoque and $Entrada){
		echo "ok";
	}else{
		echo "erro";
	}
	
}

if($_POST['metodo'] == "insere_saida"){
	
	$dataHora		= date("Y-m-d H:i:s");

	$idOrigem 		= $_POST['idOrigem'];
	$idPnr 			= $_POST['idPnr'];
	$local 			= $_POST['local'];
	$qdeSaidaMat 	= $_POST['qdeSaidaMat'];
	$responsavel 	= $_POST['responsavel'];
	$obs   			= $_POST['obs'];
	$secao 			= $_POST['secao'];
	
	$sql  = " INSERT INTO `saidas` ";
	$sql .= " (`data_hora_cadastro`, `descricao`, `idUsuarioCadastro`, `quantidade`, `id_secao`, `id_siscofis_material_origem`, `id_estoque`, `id_responsavel_retirada`, `id_pnr`) ";
	$sql .= " VALUES ";
	$sql .= " ('$dataHora', '$obs', '1', '$qdeSaidaMat', '$secao', '$idOrigem', '$local', '$responsavel', ";
	if($idPnr == ""){
		$sql .= "NULL";
	}else{
		$sql .= "'$idPnr'";
	}
	$sql .= " ) ";
	
	if(checkEstoque($idOrigem)){
		$sql2  = " UPDATE `siscofis_secao_estoque` ";
		$sql2 .= " SET ";
		$sql2 .= " `quantidade` = `quantidade` - $qdeSaidaMat ";
		$sql2 .= " WHERE ";
		$sql2 .= " `id_siscofis_material_origem` = '$idOrigem'";
		
		if(DBExecute($sql2)){
			$inEstoque =  true;
		}else{
			$inEstoque =  false;
		}
	}else{
		$sql2  = " INSERT INTO `siscofis_secao_estoque` ";
		$sql2 .= " (`quantidade`, `id_secao`, `id_siscofis_material_origem`, `id_estoque`) ";
		$sql2 .= " VALUES ";
		$sql2 .= " ('$qdeSaidaMat','$secao','$idOrigem','$local') ";
		
		if(DBExecute($sql2)){
			$inEstoque =  true;
		}else{
			$inEstoque =  false;
		}
		
	}
	
	
	if(DBExecute($sql)){
		$Entrada =  true;
	}else{
		$Entrada =  false;
	}
	
	if($inEstoque and $Entrada){
		echo "ok";
	}else{
		echo "erro";
	}
	
}

if($_GET['bkp'] == "1"){
	$dataHora	= date("d-m-Y--H-i-s");
	$nomeSecAtual = $_GET['quadra'];
	$nome_arquivo = "$nomeSecAtual $dataHora.sql";
	
	echo EXPORT_TABLES($tables=false, $nome_arquivo);
}

if($_POST['metodo'] == "checkMaterial"){
	
	$codmat = $_POST['codmat'];

	$sql  ="SELECT `id_siscofis_material`, `descricao` FROM `siscofis_material` WHERE `codigo` = '$codmat'";

	$result	= DBExecute($sql);
	if(!mysqli_num_rows($result)){
		echo "0";
	}else{
		while($retorno = mysqli_fetch_assoc($result)){
			$dados[] = $retorno;
		}
		echo json_encode($dados[0]);
	}

}

if($_POST['metodo'] == "checkOrigem"){
	
	$key = $_POST['key'];

	$sql  ="SELECT `codigo` FROM `siscofis_material_origem` WHERE `codigo` = '$key'";

	$result	= DBExecute($sql);
	if(!mysqli_num_rows($result)){
		echo "0";
	}else{
		echo "1";
	}

}

if($_POST['metodo'] == "addMaterial"){
	
	$cadcodmat = $_POST['cadcodmat'];
	$idMat = $_POST['idMat'];
	$descmat = $_POST['descmat'];
	$codori = $_POST['codori'];
	$vunitario = $_POST['vunitario'];
	$update = $_POST['update'];
	
	// Se já existe um material
	if($update == "1"){
		$sql  =" INSERT INTO `siscofis_material_origem` ";
		$sql .=" (`id_siscofis_material`, `codigo`, `preco_unitario`) ";
		$sql .=" VALUES ";
		$sql .=" ('$idMat','$codori','$vunitario')";
		
		$result	= DBExecute($sql);
		
	}else{

		$sq1  =" INSERT INTO `siscofis_material` ";
		$sq1 .=" (`codigo`, `descricao`) ";
		$sq1 .=" VALUES ";
		$sq1 .=" ('$cadcodmat','$descmat')";
		
		$sq2  =" INSERT INTO `siscofis_material_origem` ";
		$sq2 .=" (`id_siscofis_material`, `codigo`, `preco_unitario`) ";
		$sq2 .=" VALUES ";
		$sq2 .=" ((select LAST_INSERT_ID()),'$codori','$vunitario')";

		$result	= DBCommit($sq1, $sq2);
		if($result){
			echo "1";
		}else{
			echo "0";
		}
		
	}
}
?>