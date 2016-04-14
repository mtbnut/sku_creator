<?

// SKU version of creator.php

error_reporting(E_ERROR);

if($_REQUEST['mode']) {	
	
	$bikeXML = (isset($_REQUEST['bikexml'])) ? $_REQUEST['bikexml'] : 'input/bikes.xml';
	$skuXML = (isset($_REQUEST['skuxml'])) ? $_REQUEST['skumxl'] : 'input/sku_map.xml';
	$componentXML = (isset($_REQUEST['componentxml'])) ? $_REQUEST['componentxml'] : 'input/components.xml';
	$pdfXML = (isset($_REQUEST['pdfxml'])) ? $_REQUEST['componentxml'] : 'input/pdftranslation.xml';
	
	$bikeTemplate = 'templates/bike.php';
	$jsonTemplate = 'templates/json-SKU.php';
	
	$jsonBikeOutput = 'bikes_wSKU.js';
	$jsonComponentOutput = 'components_wSKU.js';
			
	// Give it enough time to parse
	set_time_limit(50000);	
	
	if( $object = simplexml_load_file($bikeXML)) {
		
		$objectsku = simplexml_load_file($skuXML);
		
		$basefolder = 'output/english';
		$folder = $basefolder.'/bikes/';
	
		if($_REQUEST['mode'] == 'json') {
			
			include($jsonTemplate);
			
			// bikes json
			$bikes = $object->bike;
			$theskus = $objectsku->bike;			
			$json = defineBikeJSON($bikes, $skusArray);	
			
			// export file
			$filename = $folder . 'search/' . $jsonBikeOutput;
			$handle = fopen($filename, 'w+');
			fwrite($handle, $json);
			
			if(!$skuNames = simplexml_load_file($skuXML)) {
				print("<b>Warning:</b> The SKU Translation file not found:" . $skuXML . "<br>");						
			}
			// Require pdf translations
			if(!$pdfNames = simplexml_load_file($pdfXML)) {
				print("<b>Warning:</b> PDF Translation file not found:" . $pdfXML . "<br>");						
			}
			
			// component json
			$components = simplexml_load_file($componentXML);
			$pdfComponents = $components->xpath('/components/component[pdf]');
			$json = defineComponentJSON($pdfComponents, $skusArray);	
			
			// export file
			$componentfilename = $folder . 'search/' . $jsonComponentOutput;
			$handle = fopen($componentfilename, 'w+');
			
			if(!fwrite($handle, $json)) {
				print("<b>Warning:</b> Permission denied to write file" . $componentfilename . "<br>");					
			}
			
			
			
			fclose($handle);
			
			print('<b>Success!</b> Autocomplete JSON has been created. <ul class="bullet"> <li><a href="'.$filename.'">Bike JSON</a></li> <li><a href="'.$componentfilename.'">Component JSON</a></li><li><a href="'. $basefolder.'/specialized.html">Specialized search demo</a></li><li><a href="'. $basefolder.'/globe.html">Globe search demo</a></li></ul>');
			
			exit();
		}

	}
	else {
		exit();
	}
}

function unlinkDirectory($dir, $deleteRoot) {
    if(!$dh = @opendir($dir)) {
        return;
    }
    while(false !== ($obj = readdir($dh))) {
        if($obj == '.' || $obj == '..') {
            continue;
        }
        if(!@unlink($dir . '/' . $obj)) {
            unlinkDirectory($dir.'/'.$obj, true);
        }
    }
    closedir($dh);
    if($deleteRoot) {
        @rmdir($dir);
    }   
    return;
} 
?>