<?php

include "database.php";

$secs = secs($sql);
$atual = secatual($sql);
$nomeSecAtual = nomesec($atual);

echo "<div class='container'>";
echo "<p>Selecione a ADM de quadra correspodente e clique em Alterar, este processo só precisa ser feito uma vez.</p>";
echo "<label>Selecione a Quadra Atual</label>";
echo "<select id='selsec' class='input-field browser-default'>";
 
foreach($secs as $v){
	// var_dump($v);
	$ativo = $v['id_secao'] == $atual ? "selected" : "";
	echo "<option value='$v[id_secao]' $ativo>$v[secao]</option>";
	
}

echo "</select>";
echo '<a id="newsec" class="waves-effect waves-light btn">Alterar Seção Atual</a>';

echo "<p>Clique para baixar um backup do banco de dados. É recomendado realizar pelo menos um backup por semana, e guardar em outro local (não neste computador)</p>";
echo "<a id='bkp' href='database.php?bkp=1&quadra=$nomeSecAtual' class='purple waves-effect waves-light btn'>backup do banco de dados</a>";

echo "</div class='container'>";



?>