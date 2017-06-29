<!--
Projeto GravadoraWeb

Desenvolver um sistema Web, em PHP, para o cadastro de CDs produzidos por uma determinada gravadora. Deverão ser cadastrados, também, os usuários do sistema.

        CD(codigo, titulo, data_lançamento, cantor_fk).
        Cantor (código, nome)
        Usuario(codigo, login, nome, senha)

O sistema deverá atender aos seguintes requisitos:

Cadastrar CDs, cantores e usuários.

Sobre o cadastro do usuário:
	A inclusão deverá incluir login/senha (verificando se o login já existe).
	A senha deverá ser inserida no bando de dados e checada através de criptografia.
Sobre o cadastro dos CDs:
	Apenas usuários logados poderão:
		Cadastrar CDs;
O usuário poderá enviar uma imagem da capa do CD.
Listar CDs cadastrados, exibindo seus dados e suas capas;
Alterar os dados de qualquer CD;
Os dados dos CDs deverão ser validados com expressões regulares, antes de sua inserção no banco de dados.
Usar consultas de CDs por : título e/ou cantor e/ou período de lançamento).
Usar API PDO.
O sistema deverá possuir um controle de login, com controle de sessões em TODAS as páginas que deverão acesso restrito ao usuário.
O sistema deverá disponibilizar para download dos dados dos CDs em XML.
As informações necessárias a conexão com o SGBD deverão estar em um arquivo TXT.
Deverá existir alguma funcionalidade com AJAX+JSON (definida posteriormente).
Importante:
Data Apresentação/Entrega: até 08/07/2015
Equipes: máximo 3 alunos.

-->

<?php 
	include_once('funcoes.php');
	$cds = getCDs($bd);
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
				<h2>Listagem de CDs</h2>
				
				<?php if(estaLogado()): ?>
					
					<input type="text" name="pesquisa" id="pesquisainput" placeholder="Pesquisar...">
					<select name="filtro_select" id="filtro_select">
						<option value="album">Álbum</option>
						<option value="cantor">Cantor</option>
						<option value="lancamento">Data de lançamento</option>
					</select>
					<div id="listagemcd">
						<?php
							if($cds->rowCount() > 0){
								foreach ($cds as $cd) {
									echo "<div class='cdblock'><img class='cdb_img' src='img/capas/". $cd['codigo_cd'] .".jpg' alt=''><div class='cdb_title'>" . $cd['titulo'] . "</div><div class='cdb_artist'>" . $cd['nome'] . "</div><div class='cdb_lancamento'>(". $cd['data_lancamento'] .")</div><div class='cdb_acoes'><a href='editarcd.php?codigo=". $cd['codigo_cd'] ."'>Editar</a> | <a href='removercd.php?codigo=". $cd['codigo_cd'] ."'>Remover</a></div></div>";
								}
							}else{
								echo "<h5>Nenhum CD no banco de dados.</h5>";
							}
						?>
					</div>

				<?php else: ?>
					
					<h4>Por favor, faça <a href="entrar.php">login</a> ou <a href="cadastrarusuario.php">cadastre-se</a> para ver a listagem de CDs.</h4>
				
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