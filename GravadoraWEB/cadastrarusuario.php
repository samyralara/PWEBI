<?php 
	include_once('funcoes.php');
	$msg = "";

	if(isset($_POST['nome'])){
		$nome = $_POST['nome'];
		$login = $_POST['login'];
		$senha = $_POST['senha'];
		
		if($nome != "" && $login != "" && $senha != ""){
			if(!adicionarUsuario($bd, $_POST)){
				$msg = "Este usuário já existe em nosso sistema!";
			}else{
				header("Location:cadastrarusuario.php?info=cadastrado", "refresh");
			}
		}else{
			$msg = "Erro: O servidor não recebeu o formulario completo!";
		}
	}
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
				<h2>Cadastrar</h2>
				
				<?php if($msg != ""):?> <p class="erro"><?php echo $msg; ?></p> <?php endif; ?>
				<?php if(isset($_GET['info'])):?> <p class="sucesso">Usuário cadastrado!</p> <?php endif; ?>
				
				<form action="cadastrarusuario.php" method="post">
						<label for="login">Nome:</label>
						<input type="text" name="nome" id="nome" required>
						<label for="login">Login:</label>
						<input type="text" name="login" id="login" required>
						<label for="senha">Senha</label>
						<input type="password" name="senha" id="senha" required><br>
						<input type="submit" value="Cadastrar">
				</form>
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