<?php $phpName=$_GET['scriptname']; ?>
function ZChangeTemplate(fileAddr){	document.location= '<?php echo $phpName;?>?action=gettemplate&file='+fileAddr;}
function ZLoadTemplatePage(fileAddr){ document.location= '<?php echo $phpName;?>?action=loadTemplPage&file='+fileAddr; }