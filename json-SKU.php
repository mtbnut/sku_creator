<?

// JSON used to generate SKU for Product IDs

function jsonBikeWrapper($specjson, $globejson) {

$json = <<<JSON
[
{$specjson}
]
JSON;
	return $json;
} 

function defineBikeJSON($bikes, $skusArray) {
	
	$json['specialized'] = '';
	$json['globe'] = '';
		
	// sort first
	$nameArray = array();
	foreach($bikes as $bike) {
		$name = trim(strval($bike->name));
		if(!in_array($name, $nameArray, true)) {
			$bikeArray[] = $bike;
			$nameArray[] = $name;
	}	
	}	
	array_multisort($nameArray, SORT_DESC, $bikeArray, SORT_ASC, $skusArray, SORT_ASC);
	reset($bikeArray);
	
	foreach($bikeArray as $bike) { // this is iterating through the primary spreadsheet
		$name = trim(addslashes($bike->name));
		$model = trim(addslashes($bike->modelname));
		// make name ok for file
		$hash = preg_replace('#[^A-Za-z0-9_-]#','-', str_replace(' ', '-', str_replace('  ', ' ', $bike->name)) );
		$link = $file = '../assets/bikes/icons/' . $hash . '.jpg';
		$family = trim(strtolower($bike->family));	

        foreach($skusArray as $skusTemp){  // iterate through the SKUs xml document
          if($skusArray.id === $bike.id){  // if `this` sku matches the mpl product id for `this` bike
          	$sku[] = $skusTemp; // append `this` sku to the temporary skus array
          }
        }
        
        if(count($skusArray) > 0){  // check to see if the temporary skus array contains data
        	$bike->sku = $skusArray;  // if yes then append it to the bike object
        }
	
$json[$family] .= <<<JSON
	{
		"year": "{$bike->year}",
		"bike": "{$bike->bikename}",
		"model": "{$bike->modelname}",
		"type": "{$bike->family}",
		"bikeLink": "http://service.specialized.com/productfinder/products/{$hash}.html",
		"image": "http://service.specialized.com/productfinder/assets/images/{$bike->originaljpg}",
		"skus": [
		  $skusArray
		],
	},

JSON;
	}

	// get rid of trailing comma for globe and specialized
	$json['specialized'] = substr($json['specialized'], 0, strrpos($json['specialized'], ','));
	
	$wrappedjson = jsonBikeWrapper($json['specialized']);
	
	return $wrappedjson;	
}


function jsonComponentWrapper($json) {

$json = <<<JSON
[
	{$json}
]

JSON;
	return $json;
} 

function defineComponentJSON($components, $pdfNames) {
	$json = '';
	
	// sort first
	$nameArray = array();
	foreach($components as $component) {
		$name = trim(strval($component->name));
		if(!in_array($name, $nameArray, true)) {
			$componentArray[] = $component;
			$nameArray[] = $name;
		}	
	}	
	array_multisort($nameArray, $componentArray);
	reset($componentArray);
	
	// now loop for json
	$componentjson = '';
	foreach($componentArray as $component) {
		$name = trim(addslashes($component->name));
		
		// search pdf xml for translated name
		$origname = $component->pdf;
		// lookup 	 in xml
		$query = "/pdfs/pdf[original='".$origname."']/rename";
		$pdflink = $pdfNames->xpath($query);
		$file = $pdflink[0];
		
$componentjson .= <<<JSON
		'{$name}': {
		name: '{$name}',
		description: '',
		pdf: '../assets/pdf/{$file}'
	},

JSON;
	}
	
	// get rid of trailing comma for globe and specialized
	$componentjson = substr($componentjson, 0, strrpos($componentjson, ','));
	
	$wrappedjson = jsonComponentWrapper($componentjson);
	
	return $wrappedjson;	
}


function defineComponentHTML($components) {
	$html = '';
	$value = 1;
	
	foreach($components as $component) {
		$class = ($value % 2) ? 'class="even"' : ' class="odd"';
		$html .= <<<HTML
					<div$class>
						<div class="name">{$component->type}</div>
						<div class="description">{$component->description}{$pdf}</div>
						{$componentLink}
					</div>

HTML;
		$value++; 

	}
	return $html;
}

?>