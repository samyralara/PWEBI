<?php 
	include_once('funcoes.php');
	$msg = "";

	if(!estaLogado()){
		header("Location:index.php", "refresh");
	}

	if(isset($_GET['codigo'])){
		$id = $_GET['codigo'];
		$cd = getCDs($bd, $id);
		if(count($cd) == 0){
			header("Location:erro.php?erro=1", "refresh");
		}
		$cd = $cd->fetch();

	}

	

	if(isset($_POST['removeid'])){
		if(removercd($bd, $_POST['removeid'])){
			header("Location:removercd.php?info=alterado", "refresh");
		}else{
			$msg = "Erro: CD não encontrado.";
		}

	}



	// if(isset($_POST['titulo']) && isset($_POST['data_lancamento']) && isset($_POST['cantor']) && isset($_FILES['capa'])){
	// 	$titulo = $_POST['titulo'];
	// 	$data_lancamento = $_POST['data_lancamento'];
	// 	$cantor = $_POST['cantor'];
	// 	$capa = $_FILES['capa'];

	// 	if($capa['error'] == 0){
	// 		if(validarcapa($capa) === true){
	// 			if($titulo != "" && $data_lancamento != "" && $cantor != ""){
	// 				adicionarCD($bd, $_POST, $capa);
	// 				header("Location:cadastrarcd.php?info=cadastrado", "refresh");
	// 			}else{
	// 				$msg = "Erro: O servidor não recebeu o formulario completo!";
	// 			}
				
	// 		}else{
	// 			$msg = validarcapa($capa);
	// 		}
	// 	}

	// }
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<title>Gravadora WEB</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/script.js"></script>
</head>
<body>
	<div id="tudo">
		<div id="cabecalho">
			<div id="title">
				<h1><a href="index.php">Gravadora WEB</a></h1>
			</div>
		</div>
		<div id="conteudo">
			<div id="main_col">
				<div id="loginbox">
					
					<!-- SESSION -->
					<?php if(estaLogado()): ?>
					
						<h4>Olá, <?php echo $dados_usuario['nome']; ?></h4>
						<h5><a href="sair.php">Sair</a></h5>
					
					<?php else: ?>
					
						<h4>Olá, visitante!</h4>
						<h5>Faça <a href="entrar.php">login</a> ou <a href="cadastrarusuario.php">cadastre-se!</a></h5>
					
					<?php endif; ?>
					
				</div>
				<div id="menu">
					<h4>Menu</h4>
					<ul>
						<li><a href="index.php">Início</a></li>
						<li>Cadastrar
							<ul>
								<li><a href="cadastrarcd.php">CD</a></li>
								<li><a href="cadastrarcantor.php">Cantor</a></li>
								<li><a href="cadastrarusuario.php">Usuário</a></li>
							</ul>
						</li>
						<li><a href="download.php">Backup CDs</a></li>
					</ul>
				</div>
			</div>
			<div id="direita_col">
				<?php if($msg != ""):?> 
					<p class="erro"><?php echo $msg; ?></p> 
				<?php elseif(isset($_GET['info'])): ?>
					<p class="sucesso">CD removido com sucesso!</p>
					<a href="index.php">Voltar</a>
				<?php else: ?>
					<h2>Deseja remover '<?php echo $cd['titulo']; ?>'?</h2>
					<div style="width: 400px; margin-left: 110px; margin-top: 45px; text-align: center;">
						<img src="img/capas/<?php echo $cd['codigo_cd'] ?>.jpg" alt=""><br><br>
						<form id="removecd" action="removercd.php" method="post">
							<input type="hidden" name="removeid" value="<?php echo $cd['codigo_cd']; ?>">
							<input id="removecdbtn" type="submit" class="btn btn-primary" value="Remover">
						</form>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<footer>
		<div id="ifpb">Instituto Federal de Educação, Ciência e Tecnologia da Paraíba</div><br>
		<div id="sub">Tecnologia em Sistemas para Internet<br>
		Programação para WEB I<br>
		Professor: Edemberg Rocha<br>
		Grupo: Rafael Cruz, Natanael Guedes e Tulio Gomes
		<div>
	</footer>
</body>
</html>