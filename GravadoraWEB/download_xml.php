<?php 
	 
  
 	$bd = 'localhost';
$user='root';
$sen='';
$banco='gravadora';

$con = new PDO("mysql:host=$bd;dbname=$banco",$user,$sen);

	$sql = "SELECT * FROM cd";
	$dom = new DomDocument();
	$cd = $dom->createElement("cd");
	$dom->appendChild($cd);
 	

foreach($con->query($sql) as $v){
$codigo = $dom->createAttribute("codigo_cd");
$codigo->value=$v['codigo_cd'];
$cd->appendChild($codigo);

$titulo=$dom->createElement('titulo',$v['titulo']);
 $cd->appendChild($titulo);

 $lancamento=$dom->createElement("DataDeLancamento",$v['data_lancamento']);
 $cd->appendChild($lancamento);

$cantofk = $dom->createElement("Cantor_fk",$v['cantor_fk']);
$cd->appendChild($cantofk);
$dom->appendChild($cd);

}

 		 
			
echo "<pre>";
	$dom->formatOutput =  TRUE;
	echo htmlentities($dom->save('down/cd.xml'));
echo "</pre>";
	//$dom->save("down/cd.xml");
//header("Location:down/cd.xml");
	echo "<a href='download_xml.php' download='cds.xml' class='btn btn-default'><i class='fa fa-download'></i> Download XML</a>";		

?>
