<?php
require_once ('session.php');
require_once ('shared.php');
require_once('header.php');
print "<p/>";
if(!apiVersionIsAtLeast(10.0)) {
	show_error("Metadata API not supported prior to version 10.0", false, true);
	exit;
}

require_once ('soapclient/SforceMetadataClient.php');
?>
<script type="text/javascript" src="script/simpletreemenu.js">
/***********************************************
* Simple Tree Menu - Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
<link rel="stylesheet" type="text/css" href="style/simpletree.css" />
<?php

global $metadataConnection;
try {
	$describeMetadataResult = $metadataConnection->describeMetadata();
} catch (Exception $e) {
	show_errors($e->getMessage(), false, true);
}

foreach($describeMetadataResult as $resultsKey => $resultsValue) {
	if($resultsKey == 'metadataObjects'){
		foreach($resultsValue as $metadataResultsKey => $metadataResultsValue) {
			$processedMetadataDescribe[$metadataResultsValue->xmlName] = $metadataResultsValue;
		}
	}
}

$processedMetadataDescribe = natcaseksort($processedMetadataDescribe);


print "<a href=\"javascript:ddtreemenu.flatten('describeMetadataTree', 'expand')\">Expand All</a> | <a href=\"javascript:ddtreemenu.flatten('describeMetadataTree', 'collapse')\">Collapse All</a>\n" .
      "<ul id='describeMetadataTree' class='treeview'>\n";

printNode($processedMetadataDescribe);

require_once('footer.php');
?>
<script type="text/javascript">
ddtreemenu.createTree("describeMetadataTree", true);
</script>