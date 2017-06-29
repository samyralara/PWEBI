<?php 
	include_once("classes.cla");

	$bd = carregarBanco();

	session_start();

	$dados_usuario = estaLogado();

	function carregarBanco(){

		try{
			$bdtxt = carregarTXT("bd.txt");
			//echo $bdtxt;
			if($bdtxt == null){
				throw new Exception("Erro.");
			}
			$bdarray = txtToArray($bdtxt);
			//var_dump($bdarray);

			if(count($bdarray) != 4){
				throw new Exception("Erro.");
			}
			$host = $bdarray['host'];
			$banco = $bdarray['banco'];
			$bdpdo = new PDO("mysql:host=$host;dbname=$banco", $bdarray['login'], $bdarray['senha']);
		}catch(Exception $e){
			echo "Erro ao conectar o banco de dados.";
			exit;
		}
		return $bdpdo;
		
	}


	function carregarTXT($file){
		$handle = fopen($file,"r");
		
		if ($handle != false && filesize($file) > 0)
		{
			$conteudo = fread($handle,filesize($file));
			fclose($handle);
			return $conteudo;
		}
		return null;
	}

	function txtToArray($string){
		$raw_array = explode(PHP_EOL, $string);
		$array = array();
		foreach ($raw_array as $linha) {
			
			if($linha != ''){
				//var_dump($linha);
				$div = explode(':', $linha);
				if(count($div) == 1){
					$array[$div[0]] = "";
				}else{
					$array[$div[0]] = $div[1];
				}
			}
		}
		return $array;
	}

	function adicionarUsuario($bd, $post){
		$nome = $post['nome'];
		$login = $post['login'];
		$senha = md5($post['senha']);

		if(usuarioJaExiste($bd, $login)){
			return false;
		}

		$bd->exec("insert into usuario(codigo, login, nome, senha) values (null, '$login', '$nome', '$senha');");
		return true;
	}

	function usuarioJaExiste($bd, $login){
		$sql = "select * from usuario where login = '$login';";
		if($bd->query($sql)->fetch(PDO::FETCH_NUM)[0] != 0){
			return true;
		}
		return false;
	}

	function cantorJaExiste($bd, $nome){
		$sql = "select * from cantor where nome = '$nome';";
		if($bd->query($sql)->fetch(PDO::FETCH_NUM)[0] != 0){
			return true;
		}
		return false;
	}

	function cdJaExiste($bd, $titulo){
		$sql = "select * from cd where titulo = '$titulo';";
		if($bd->query($sql)->fetch(PDO::FETCH_NUM)[0] != 0){
			return true;
		}
		return false;
	}

	function autenticar($bd, $post){
		$login = $post['login'];
		$senha = md5($post['senha']);
		$sql = "select * from usuario where login = '$login' and senha = '$senha';";
		$query =  $bd->query($sql)->fetch(PDO::FETCH_ASSOC);
		if($query){
			$_SESSION['dados_logado'] = $query;
			return true;
		}
		return false;
	}

	function estaLogado(){
		if(isset($_SESSION['dados_logado'])){
			return $_SESSION['dados_logado'];
		}
		return false;
	}

	function logoff(){
		if(estaLogado()){
			session_unset($_SESSION['dados_logado']);
			session_destroy();
		}
	}


	function getCDs($bd, $id = null){
		if($id == null){
			$sql = "select * from cd c join cantor ca where c.cantor_fk = ca.codigo_cantor;";
		}else{
			$sql = "select * from cd c join cantor ca where c.cantor_fk = ca.codigo_cantor and c.codigo_cd = $id;";
		}
		$query = $bd->query($sql);
		return $query;
	}

	function pesquisaCDs($bd, $pesquisa, $filtro = null){
		switch ($filtro) {
			case 'album':
				$sql = "select * from cd c join cantor ca where c.cantor_fk = ca.codigo_cantor and c.titulo like '%" . $pesquisa . "%';";
				break;
			
			case 'cantor':
				$sql = "select * from cd c join cantor ca where c.cantor_fk = ca.codigo_cantor and ca.nome like '%" . $pesquisa . "%';";
				break;
			
			case 'lancamento':
				$sql = "select * from cd c join cantor ca where c.cantor_fk = ca.codigo_cantor and c.data_lancamento like '%" . $pesquisa . "%';";
				break;
			
			default:
				$sql = "select * from cd c join cantor ca where c.cantor_fk = ca.codigo_cantor and c.titulo like '%" . $pesquisa . "%';";
				break;
		}

		$query = $bd->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		return $query;
	}

	function adicionarCantor($bd, $post){
		$nome = $post['nome'];
		
		$bd->exec("insert into cantor(codigo_cantor, nome) values (null, '$nome');");
		return true;
	}

	function adicionarCD($bd, $post, $files){
		$titulo = $post['titulo'];
		$data_lancamento = $post['data_lancamento'];
		$cantor = $post['cantor'];

		$bd->exec("insert into cd(codigo_cd, titulo, data_lancamento, cantor_fk) values (null, '$titulo', '$data_lancamento', '$cantor');");


		$last_id = $bd->lastInsertId();

		salvarcapa($last_id, $files);

		return true;
	}

	function validarcapa($file){
		$tipos_img = array("image/jpeg");
		$tamanho_limite = 1048576; //1 MB
		//!array_search($file['type'], $tipos_img)
		if($file['type'] != "image/jpeg"){
			return 'Erro: Somente imagens do tipo JPEG/JPG serão aceitos. (Tipo selecionado: ' . $file['type'] . ')';
		}

		if($file['size'] > $tamanho_limite){
			return 'Erro: Tamanho máximo permitido da imagem é de 1 MB.';
		}

		return true;
	}

	function salvarcapa($id, $file){
		$destino = "img\\capas\\" . $id . ".jpg";

		if(file_exists($destino)) {
		    chmod($destino,0755); //Change the file permissions if allowed
		    unlink($destino); //remove the file
		}
		move_uploaded_file($file['tmp_name'],$destino);
	}

	function getCantores($bd){
		$sql = "select * from cantor c order by c.nome;";
		$query = $bd->query($sql);
		return $query;
	}
	
	function alterarcd($bd, $id, $post, $capa){
		$titulo = $post['titulo'];
		$data_lancamento = $post['data_lancamento'];
		$cantor = $post['cantor'];

		//$bd->exec("UPDATE cd set titulo='$titulo',data_lancamento='$data',cantor_fk=$cantor WHERE codigo_cd=$c");
		$bd->exec("update cd set titulo = '$titulo', data_lancamento = '$data_lancamento', cantor_fk = $cantor where codigo_cd = $id");

		if($capa != null){
			salvarcapa($id, $capa);
		}
		return true;
	}

	function removercd($bd, $id){
		if($bd->exec("delete from cd where codigo_cd = $id") == 0){
			return false;
		}
		return true;
	}

	function gerarXML($bd){
		$dom = new DOMDocument();
		$bd_cds = getCDs($bd);

		$no_cds = $dom->createElement('cds');
		
		foreach ($bd_cds as $cd) {
			$no_cd = $dom->createElement('cd');
			$no_titulo = $dom->createElement('titulo', $cd['titulo']);
			$no_data_lancamento = $dom->createElement('data_lancamento', $cd['data_lancamento']);
			$no_cantor = $dom->createElement('cantor', $cd['nome']);
			$no_cod_cd = $dom->createAttribute('codigo');
			$no_cod_cd->value = $cd['codigo_cd'];
			$no_cod_cantor = $dom->createAttribute('codigo');
			$no_cod_cantor->value = $cd['codigo_cantor'];

			$no_cd->appendChild($no_cod_cd);
			$no_cantor->appendChild($no_cod_cantor);

			$no_cd->appendChild($no_titulo);
			$no_cd->appendChild($no_data_lancamento);
			$no_cd->appendChild($no_cantor);

			$no_cds->appendChild($no_cd);
		}

		$dom->appendChild($no_cds);
		$dom->save('backup.xml');
	}

	function regex_titulo($titulo){
		$titulo_regex = "/[a-z0-9áéíóúàâêôãõüç ]{4,20}/i";
		if(preg_match($titulo_regex, $titulo) == 1){
			return true;
		}
		return false;
	}

	function regex_data($data){
		$data_regex = "/\d{4}-\d{2}-\d{2}/";
		if(preg_match($data_regex, $data) == 1){
			return true;
		}
		return false;
	}




?>