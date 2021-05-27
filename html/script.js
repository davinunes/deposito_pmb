function moeda(){
        var myAudio = new Audio('moeda.mp3');
		myAudio.play();
}

$(document).ready(function(){
	
	$('.sidenav').sidenav();
	$('.dropdown-trigger').dropdown({
		inDuration: 300,
		alignment: 'right',
		hover: true,
		coverTrigger: false
		
	});
	
	$('.menu').click(function() {
		args = $(this).attr("args");
		if(typeof args != "undefined"){
			pagina = $(this).attr("id")+".php"+"?"+args;
		}else{
			pagina = $(this).attr("id")+".php";
		}
		console.log(pagina);
		
		$.post(pagina, "", function(retorna){
			$("#conteudo").html(retorna);
			// $('select').formSelect();
			$('.modal').modal();
		});
		
		
	});

	$('.validate').keyup(function() {
		console.log("Mudou");
		if($("#nome").val() != "" && $("#idt").val() != ""){
			Salvar.disabled = false;
		}else{
			Salvar.disabled = true;
		}
    });

	$('#cpf').keyup(function() {
		$(this).val(this.value.replace(/\D/g, ''));
    });

});

$(document).on('click', '.filtro', function(event){
	dados={
		dti:$("#dti").val(),
		dtf:$("#dtf").val()
	}
	pagina = $(this).attr("url")+"?dti="+dados.dti+"&dtf="+dados.dtf;
	console.log("--"+pagina);
	
	$.post(pagina, dados, function(retorna){
		console.log("-|-");
		$("#conteudo").html(retorna);
		$('.modal').modal();
	});

});

$(document).on('click', '#filtraDeposito', function(event){
	dados={
		deposito:$("#seldep").val()
	}
	pagina = $(this).attr("url")+"?deposito="+dados.deposito;
	console.log("--"+pagina);
	
	$.post(pagina, dados, function(retorna){
		console.log("-|-");
		$("#conteudo").html(retorna);
		$('.modal').modal();
	});

});

$(document).on('click', '#newsec', function(event){
	sec = $("#selsec").val();
	console.log(sec);
	dados = {
		metodo : "setsec",
		newsec : sec
	}
	
	$.post("database.php", dados, function(retorna){
		console.log(retorna);
		if (retorna === "ok"){
			M.toast({html: 'Alterado com Sucesso', classes: 'rounded'});
			$("#conf").click();
			moeda();
		}
	});
});

$(document).on('click', '.setmaterial', function(event){
	codigo = $(this).attr("idmaterial");
	desc = $(this).attr("nomemat");
	origem = $(this).attr("origem");
	$("#codmat").val(codigo);
	$("#descmat").val(desc);
	$("#codori").val(origem);
	console.log(codigo);
	$("#search1").val("");
	$(".resultado").html("");


});

$(document).on('click', '.setpnr', function(event){
	idPnr = $(this).attr("id_pnr");
	endereco = $(this).attr("endereco");
	$("#endpnr").val(endereco);
	$("#idpnr").val(idPnr);
	console.log(idpnr);
	$("#search2").val("");
	$(".resultado").html("");


});

$(document).on('click', '#btn_s_mat', function(event){
	$("#search1").focus();

});

$(document).on('click', '#btn_s_pnr', function(event){
	$("#search2").focus();

});

$(document).on('keyup', '.pesquisa', function(event){

	//Recuperar o valor do campo
	var pesquisa = $(this).val();
	var metodo = $(this).attr("metodo");
	var criterio = $(this).attr("criterio");
	//Verificar se tem algo digitado
	if(pesquisa.length > 2){
		var dados = {
			palavra : pesquisa,
			metodo : metodo,
			criterio : criterio
			}
		$.post('database.php', dados, function(retorna){
			//Mostra dentro da div os resultado obtidos 
			$(".resultado").html(retorna);
			console.log(retorna);
		});
	}
});

$(document).on('click', '.editResponsavel', function(event){

	$("#nome_responsavel").val($(this).attr("nome"));
	$("#id_responsavel").val($(this).attr("id_responsavel_retirada"));
	$("#btn_r_send").text("Atualizar");

});

$(document).on('click', '.editLocal', function(event){

	$("#nome_local").val($(this).attr("local"));
	$("#id_local").val($(this).attr("id_estoque"));
	$("#btn_e_send").text("Atualizar");

});

$(document).on('click', '#btn_r_send', function(event){
	dados = {
		nome : $("#nome_responsavel").val(),
		id : $("#id_responsavel").val(),
		metodo : "updateResp"
	}
	
	if($(this).text() == "Atualizar"){
		$.post("database.php", dados, function(retorna){
			console.log(retorna);
			if (retorna === "ok"){
				M.toast({html: 'Alterado com Sucesso', classes: 'rounded'});
				moeda();
				$("#responsavel").click();
			}
		});
	}else{
		dados.metodo = "insertResp";
		if(dados.nome == ""){
			
		}else{
			$.post("database.php", dados, function(retorna){
				console.log(retorna);
				if (retorna === "ok"){
					M.toast({html: 'Alterado com Sucesso', classes: 'rounded'});
					moeda();
					$("#responsavel").click();
				}
			});
		}
	}


});

$(document).on('click', '#enviar_entrada', function(event){
	dados = {
		metodo : "insere_entrada",
		idOrigem : $("#codori").val(),
		idPnr : $("#idpnr").val(),
		local : $("#selsec").val(),
		qdeEntMat : $("#qdeEntMat").val(),
		obs : $("#obsEntradaMaterial").val(),
		secao : $("#secaoAtual").attr("sec")
	}
	console.log(dados);
	
	if(dados.idOrigem == "" || dados.qdeEntMat == "" || dados.obs == ""){
		M.toast({html: 'Necessário definir: Material, Quantidade e Observação', classes: 'rounded'});
	}else{
		$.post("database.php", dados, function(retorna){
			console.log(retorna);
			if (retorna === "ok"){
				M.toast({html: 'Material Inserido com Sucesso!', classes: 'rounded red darken-2'});
				moeda();
				$("#codmat, #descmat, #codori, #idpnr, #endpnr, #idpnr, #selsec, #qdeEntMat, #obsEntradaMaterial").val("");

			}
		});
	}

});

$(document).on('click', '#enviar_saida', function(event){
	dados = {
		metodo : "insere_saida",
		idOrigem : $("#codori").val(),
		idPnr : $("#idpnr").val(),
		local : $("#selsec").val(),
		qdeSaidaMat : $("#qdeSaidaMat").val(),
		obs : $("#obsSaidaMaterial").val(),
		responsavel : $("#selresp").val(),
		secao : $("#secaoAtual").attr("sec")
	}
	console.log(dados);
	
	if(dados.idOrigem == "" || dados.qdeSaidaMat == "" || dados.obs == "" || dados.responsavel == "0"){
		M.toast({html: 'Necessário definir: Material, Quantidade, Responsavel e Observação', classes: 'rounded'});
	}else{
		$.post("database.php", dados, function(retorna){
			console.log(retorna);
			if (retorna === "ok"){
				M.toast({html: 'Saida Inserida com Sucesso!', classes: 'rounded red darken-2'});
				moeda();
				$("#saidas").click();

			}
		});
	}

});

$(document).on('click', '#btn_e_send', function(event){
	dados = {
		local : $("#nome_local").val(),
		id : $("#id_local").val(),
		metodo : "updateLocal"
	}
	
	if($(this).text() == "Atualizar"){
		$.post("database.php", dados, function(retorna){
			console.log(retorna);
			if (retorna === "ok"){
				M.toast({html: 'Alterado com Sucesso', classes: 'rounded'});
				moeda();
				$("#depositos").click();
			}
		});
	}else{
		dados.metodo = "insertLocal";
		if(dados.local == ""){
			
		}else{
			$.post("database.php", dados, function(retorna){
				console.log(retorna);
				if (retorna === "ok"){
					M.toast({html: 'Alterado com Sucesso', classes: 'rounded'});
					moeda();
					$("#depositos").click();
				}
			});
		}
	}


});

$(document).on('focusout', '#cadcodmat', function(event){
	
	dados = {
		codmat : $("#cadcodmat").val(),
		metodo : "checkMaterial"
	}
	
	$.post("database.php", dados, function(retorna){
		console.log(retorna);
		if (retorna === "0"){
			
		}else{
			M.toast({html: 'Este Material já existe, a origem será somente relacionada', classes: 'orange rounded'});
			moeda();
			var material = JSON.parse(retorna);
			$("#cadcodmat").attr("disabled",true);
			$("#descmat").attr("disabled",true);
			$("#descmat").val(material.descricao);
			$("#sinal").text("find_replace");
			$("#idMat").val(material.id_siscofis_material);
			$("#addMat").attr("jaexiste","1");
			
		}
	});

});

$(document).on('focusout', '#codori', function(event){
	
	dados = {
		key : $("#codori").val(),
		metodo : "checkOrigem"
	}
	
	$.post("database.php", dados, function(retorna){
		console.log(retorna);
		if (retorna === "0"){
			
		}else{
			M.toast({html: 'Hey, já temos essa Origem. O que está fazendo?', classes: 'red rounded'});
			moeda();
			$("#material").click();
			
		}
	});

});

$(document).on('click', '#addMat', function(event){

	dados = {
		idMat : $("#idMat").val(),
		cadcodmat : $("#cadcodmat").val(),
		descmat : $("#descmat").val(),
		codori : $("#codori").val(),
		vunitario : $("#vunitario").val(),
		update : $("#addMat").attr("jaexiste"),
		metodo : "addMaterial"
	}
	console.log(dados);
	
	if(dados.cadcodmat == "" || dados.codori == ""){
		M.toast({html: 'Falta dados!', classes: 'teal rounded'});
	}else{
			$.post("database.php", dados, function(retorna){
				console.log(retorna);
				if(retorna == "1"){
					M.toast({html: 'Cadastro realizado com sucesso', classes: 'blue rounded'});
					moeda();
					$("#material").click();
				}

			});
	}
	


});