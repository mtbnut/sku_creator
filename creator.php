<?

// SKU version of creator.php

error_reporting(E_ERROR);

if($_REQUEST['mode']) {	
	$skuXML = (isset($_REQUEST['skuxml'])) ? $_REQUEST['skumxl'] : 'input/sku_map.xml';
	$bikeXML = (isset($_REQUEST['bikexml'])) ? $_REQUEST['bikexml'] : 'input/bikes.xml';

	$jsonTemplate = 'templates/json-SKU.php';
	
	$jsonBikeOutput = 'bikes_wSKU.js';
			
	// Give it enough time to parse
	set_time_limit(50000);	
	
	if( $object = simplexml_load_file($bikeXML)) {
	
			include($jsonTemplate);
			
			// bikes json
			$bikes = $object->bike;
			$theskus = $objectsku->bike;			
			$json = defineBikeJSON($bikes, $theskus);	
			
			// export file
			$filename = 'output/english/bikes/search/' . $jsonBikeOutput;
			$handle = fopen($filename, 'w+');
			fwrite($handle, $json);
			
			fclose($handle);
			
			print('<b>Success!</b>SKU map has been created. <ul class="bullet"> <li><a href="'.$filename.'">SKU JSON</a></li></ul>');
			
			exit();
	}
}
?>
