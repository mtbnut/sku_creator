<?

// this is for SKU/Bike ID creation

function defineBikeHTML($bike) {

	$image = '';
	if($bike->originaljpg != 'null') {
		$image = '../assets/bikes/images/'.preg_replace('#[^A-Za-z0-9_-]#','-', str_replace(' ', '-', str_replace('  ', ' ', $bike->name)) ) .'.jpg';
	}

	// Figure out if its a large image and class it up
	$imagepath = 'input/images/'.$bike->originaljpg;
	$class = '';
	$imgtag = '';
	if(file_exists($imagepath)) {
		$size = getimagesize($imagepath);
		if($size[0] > 660) {
			$class= 'class="large" ';
		}
		$imgtag = '<img id="bike"'.$class.' src="'.$image.'" alt="" />';
	}

	// if not specialized
	$backLink = 'specialized.html';
	$pageClass = 'specialized';


$html = <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" ng-app="store">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="robots" content="noindex" />
	<title>{$bike->name} Parts Finder</title>

	<link rel="stylesheet" type="text/css" charset="utf-8" href="../assets/style/main.css" />
	<link rel="stylesheet" type="text/css" charset="utf-8" href="../assets/style/bootstrap.css" />

	<script src="../assets/javascript/angular.min.js"></script>
	<script src="../assets/javascript/app.js"></script>
	
	<!--[if lte IE 6]><link href="../../assets/style/ie6styles.css" rel="stylesheet" type="text/css" /><![endif]-->
	<!--[if IE 7]><link href="../../assets/style/ie7styles.css" rel="stylesheet" type="text/css" /><![endif]-->

	<!-- Google Analytics !-->
	<script type="text/javascript">/*<![CDATA[*/
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-8719013-1']);
			_gaq.push(['_trackPageview']);

			(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
	/*]]>*/</script>

	<!-- Global Libraries !-->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>

	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="http://jqueryui.com/jquery-wp-content/themes/jqueryui.com/style.css">

	<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>	
	<script type="text/javascript" src="../assets/javascript/config.js"></script>
	<script type="text/javascript" src="../assets/javascript/main.js"></script>
	<script type="text/javascript" src="../assets/javascript/functions.js"></script>
	<script type="text/javascript" src="../assets/javascript/plugins.js"></script>
	<script src="../assets/javascript/NewWindow.js"></script>	

	<script>
		function sendFeedback() {
		    var link = "mailto:"
		             + "?cc:"
		             + "&subject=" + escape("Link to the {$bike->name} ({$bike->id})")
		             + "&body=" + escape("Link to the page: ") + (document.URL)
		    ;
		    window.location.href = link;
		}

		function sendMail() {
		    window.open("https://sbctsw.wufoo.com/forms/s9ialza0f2w4f8/def/field7={$bike->id}&field5={$bike->name}", "_blank", "width=450, height=550, top=100, left=100, menubar=no, status=no, titlebar=no, location=no" )
		}
	</script>

	<!--Shadowbox code begin-->
	
	<script type="text/javascript" src="http://ibd.specialized.com/bb/_js/shadowbox/shadowbox.js"></script>
	<link rel="stylesheet" type="text/css" charset="utf-8" href="../assets/style/shadowbox.css" />

<script>

Shadowbox.init({overlayOpacity: 0.0, resizeDuration: 0.4, overlayColor:'transparent', player: ["img", "iframe"]});

function displayLargePartImage (imagePath) {
  Shadowbox.open({
      content:    imagePath,
      player:     "img",
      title:      "<a id='sb-nav-close' title='Close this image' onclick='Shadowbox.close()' style='float:right;cursor:pointer;'>&nbsp;&nbsp;&nbsp;&nbsp;</a>"
  });
}

function searchParts()
{ 
   //var closeout = document.getElementById('closeoutsCheckBox').value;
   var family = document.getElementById('warrantyBikeFamilySelect').value;
   var modelyear = document.getElementById('warrantyModelYearSelect').value;
   var modelname = document.getElementById('warrantyModelSelect').value;
   var component = document.getElementById('warrantyComponentTypeSelect').value;
   var partsearch = document.getElementById('warrantyPartSearch').value;
   
   if(partsearch != '') {
	   window.location.href ='SBCBBAvailServicePartsSearch.jsp?part_description='+partsearch;
	   return;
   }
  
   if(family == '' && modelyear =='') {
	   alert("You must enter bike family, model year, bike model and component type or SKU Search.");
	   return;
   } else {    
   		//window.location.href ='SBCBBAvailServicePartsSearch.jsp?familyName='+family+'&modelYear='+modelyear+'&modelName='+modelname+'&componentType='+component+'&closeOuts='+closeout
   		window.location.href ='SBCBBAvailServicePartsSearch.jsp?familyName='+family+'&modelYear='+modelyear+'&modelName='+modelname+'&componentType='+component   				
   }
}

var cat;
var myr;
var md;

function setDropDown() {
	var serialsearch = document.getElementById('serialNumberSearch').value;
	//alert(serialsearch.charAt(0).toLowerCase() + serialsearch.slice(1).toLowerCase());
	if (serialsearch == '')
	{
		alert("You must enter a Serial Number ");
		return;
	}
	
    $.ajax({type:   "GET",
    		  async:false,
              url:  "SBCBBAvailSerialSearch1.jsp",
              data: "serial="+serialsearch,
              success: function(html) {
                       var tmpList = html.substring(html.indexOf("ZZZZ@")+5,html.length-2);
                       var dropList = tmpList.split("@");
                       var listLength = dropList.length;
                       cat =  dropList[0].split("#");
                       myr =  dropList[1].split("#");
                       md  =  dropList[2].split("#");
                       //alert(cat + " " + myr + " " + md);
                       document.getElementById('warrantyBikeFamilySelect').value = cat;                      
                       }
          });

	if (cat != '')
	{
	   document.getElementById('serialBkFamily').style.visibility = 'visible';
	   document.getElementById('serialMdYear').style.visibility = 'visible';
	   document.getElementById('serialBkMd').style.visibility = 'visible';
	   document.getElementById('serialBkFamilyL').style.visibility = 'visible';
	   document.getElementById('serialMdYearL').style.visibility = 'visible';
	   document.getElementById('serialBkMdL').style.visibility = 'visible';
	   document.getElementById('serialBkFamily').value = cat;
	   document.getElementById('serialMdYear').value = myr;
	   document.getElementById('serialBkMd').value = md;
	}
	
	if (cat == '')
	{
		alert("No Data Found for Serial Number " + serialsearch);
		return false;
	}
	
	//alert(cat);
	
    $.ajax({type:   "GET",
    		async:false,
            url:  "SBCBBWarrantyPartsAjax.jsp",
            data:    "categoryName="+ cat+
                       "&closeOuts=" +"N"+
                       "&cmd="+"getModelYearList",
              success: function(json) {
            	      var opts = eval('('+json+')');
            	      //alert("HERE @@" + opts);
            	      var listObj = document.getElementById("warrantyModelYearSelect");
            	       var a = 0
                       listObj.options.length = 0;
                       listObj.options[a] = new Option('Select ', '');
            	       for(var c=0; c < opts.length; c++) 
            	       {
            	       		a++;
                    		var tOptVal = opts[c];
                    		listObj.options[a] = new Option(tOptVal, tOptVal);
                    		//var tStr = listObj.options[a].value;
                    		//alert(listObj.options[a].value);
							if (myr == listObj.options[a].value)
							{
								//alert("HERE I MATCH@@"+ listObj.options[a]);
								listObj.options[a].selected = true;
							}                  	  		
                  		}
                     }
          });


		 $.ajax({type:   "GET",
    		async:false,
            url:  "SBCBBWarrantyPartsAjax.jsp",
            data:    "categoryName="+ cat+
            		   "&modelYear="+myr+
                       "&closeOuts=" +"N"+
                       "&cmd="+"getModelList",
              success: function(json) {
            	      var opts = eval('('+json+')');
            	      var listObj = document.getElementById("warrantyModelSelect");
            	       var a = 0
                       listObj.options.length = 0;
                       listObj.options[a] = new Option('Select..', '');
            	       for(var c=0; c < opts.length; c++) 
            	       {
            	       		a++;
                    		var tOptVal = opts[c];
                    		listObj.options[a] = new Option(tOptVal, tOptVal);
                    		if(md == listObj.options[a].value)
                    		{
                    			listObj.options[a].selected = true;
                    		}
                  		}
                     }
          });
}

</script>
<!--Shadowbox code end-->

<script>
	   $( document ).tooltip();
</script>
	
<style>

	  .ui-tooltip {
	  	background: #ca0003;
	    border: 1px solid white;
	    padding: 8px;
	    width: 170px;
	    position: absolute;
	    color: white;
	    font: bold 14px DINOTCondensed, Helvetica, sans-serif;
	    box-shadow: 0 0 8px black;
	    border-radius: 0px;
	  }

</style>

</head>

<body class="{$pageClass}" ng-controller="StoreController as store">

	<div id="wrapper">
		<div id="logo">{$bike->family} Bicycles</div>
		<div id="content-top"></div>
		<div id="content" class="bike">
			<div id="menu"></div>
         <a href="https://sbctsw.wufoo.com/forms/m1nvyabi1u95iqb/def/field104=ProdFinder ({$bike->name} / {$bike->id})" onclick="window.open(this.href,  null, 'height=601, width=680, toolbar=0, location=0, status=0, scrollbars=0, resizable=1'); return false" id="review">Click here to help us improve <strong>Service.specialized.com</strong> by answering one simple question!</a>
			{$imgtag}

			<section ng-controller="PanelController as panel">

			<div id="stick">

			<ul class="nav nav-pills" >
			   <li ng-class="{ active: panel.isSelected(1)}"> <a href ng-click="panel.selectTab(1)">Original Equipment Specs</a></li>
			   <li ng-class="{ active: panel.isSelected(2)}"> <a href ng-click="panel.selectTab(2)">Service Parts</a></li>
	   		   <li ng-class="{ active: panel.isSelected(3)}"> <a href ng-click="panel.selectTab(3)">Documents</a></li>
			   <li ng-class="{ active: panel.isSelected(4)}"> <a href ng-click="panel.selectTab(4)">Videos</a></li>
			</ul>
			
				<div id="back">
					<a href="../{$backLink}" title="Return to the Product Finder.">Back to Product Finder</a>
				</div>
				<div id="icons">
					<button id="share" onclick="sendFeedback(); return false" title="Share this page. A link to this page will be placed in a new window in your default e-mail client. Whomever you're sharing it with must have their own login account to view the page."></button>
					<div class="print icon"><a href="#" title="Print the contents of this page. Select the tab you want to print; only the contents of the selected tab will be printed.">Print this Page</a></div>
					<button id="feedback" onclick="sendMail(); return false" title="Report errors/issues on this page. Help us to improve the Product Finder by letting us know if you see anything wrong. "></button>
				</div> 
				<h3>{$bike->name}</h3>
			</div>			
			
			<div class="even" class="panel" ng-show="panel.isSelected(3)">
				<div class="description" id="tsw-note"><strong>NOTE:&nbsp;LEGACY SERVICE</strong> denotes content that has been moved over from the Technical Service Website (TSW, formerly the GSS). All documents are in PDF format. </div>
			</div>	
			
			<div id="specs">
				{$bike->componentHTML}
			</div>
		</div>		
	</div>
	
	</section>

	<script type="text/javascript" src="../assets/javascript/jquery.sticky.js"></script>

	<script>
	  $(document).ready(function(){
	    $("#stick").sticky({topSpacing:0,getWidthFrom:"#content"});
		  });
	</script>

    <script type="text/javascript">
	    function imgError(image) {
	    image.onerror = "";
	    image.src = "http://ibd.specialized.com/bb/_img/ics.jpg";
	    return true;
	    }
    </script>

</body>
</html>
HTML;
	return $html;
}


function defineComponentHTML($components, $pdfNames) {
	$html = '';
	$value = 1;

	foreach($components as $component) {

		$class = ($value % 2) ? ' class="even"' : ' class="odd"';

		$pdf = '';
		if($component->pdf != '') {
			// lookup translation in xml
			$pdf = $component->pdf;
			$query = "/pdfs/pdf[original='".$pdf."']/rename";
			$pdflink = $pdfNames->xpath($query);
			$file = $pdflink[0];
			$pdf = '<a class="pdf" href="http://service.specialized.com/collateral/ownersguide/new/assets/pdf/' . $file . '" target="_blank"><img src="../assets/images/resource.gif"></a>';
	
		}

		$componentLink = "";
		if(preg_match("/^[W]\d\d\d\d.*$/", $component->vendor)||preg_match("/^[S]\d\d\d\d.*$/", $component->vendor)||preg_match("/^\d\d\d\d\d-\d\d\d\d$/", $component->vendor)||preg_match("/^\d\d\dE-\d\d\d\d$/", $component->vendor)||preg_match("/^\d\d\de-\d\d\d\d-s$/", $component->vendor)||preg_match("/^\d\d\d\d-\d\d\d\d$/", $component->vendor)) {
		$componentLink = <<<HTML
<div$class class="panel" ng-show="panel.isSelected(2)">
	<div class="name-sp">{$component->type}</div>
	<div class="description-sp">{$component->description}{$pdf}</div>
	<div class="pn-sp"><a href="javascript:NewWindow('$component->vendor')">$component->vendor</a></div>
	<div class="imgurl">
		<img class="thumbHover" onclick="displayLargePartImage('$component->largeurl')" width="90" src="$component->largeurl" onerror="imgError(this)">
    </div>	
</div>
HTML;

		} elseif (preg_match("/Air Chart/i", $component->type)||preg_match("/Appendix/i", $component->type)||preg_match("/Instruction Guide/i", $component->type)||preg_match("/Manuals/i", $component->type)||preg_match("/Schematic/i", $component->type)||preg_match("/Tech Bulletin/i", $component->type)||preg_match("/Tuning Guide/i", $component->type)||preg_match("/Warranty Policy/i", $component->type))  {			
			$componentLink = <<<HTML
<div class="even" class="panel" ng-show="panel.isSelected(3)">
	<div class="name">{$component->type}</div>
	<div class="description">{$component->description}{$pdf}</div>
</div>
HTML;
		}

		elseif (preg_match("/Legacy Service/i", $component->type))  {			
			$componentLink = <<<HTML
<div class="even" class="panel" ng-show="panel.isSelected(3)">
	<div class="name" style="color: #ED1C24;">{$component->type}</div>
	<div class="description">{$component->description}{$pdf}</div>
</div>
HTML;
		}

		elseif (preg_match("/Video/i", $component->type))  {
			$componentLink = <<<HTML
<div class="video" ng-show="panel.isSelected(4)">
	<div>{$component->description}</div>
	<iframe width="320" height="200" src="http://{$component->pdf}" frameborder="0"></iframe>
</div>
HTML;
		} else  {			
			$componentLink = <<<HTML
<div$class class="panel" ng-show="panel.isSelected(1)">
	<div class="name">{$component->type}</div>
	<div class="description">{$component->description}{$pdf}</div>
</div>
HTML;
		}

		//if($component->description != '') {
			$html .= <<<HTML
			{$componentLink}
HTML;
			$value++;
		//}

	}
	return $html;
}
//fclose($handle);
?>
