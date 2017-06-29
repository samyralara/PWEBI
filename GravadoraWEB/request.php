<?php 
	include_once("funcoes.php");

	if(isset($_GET['pesquisa']) && isset($_GET['filtro'])){
		$pesquisa = $_GET['pesquisa'];
		$filtro = $_GET['filtro'];

		$resultado = pesquisaCDs($bd, $pesquisa, $filtro);
		echo json_encode($resultado);
	}

?>