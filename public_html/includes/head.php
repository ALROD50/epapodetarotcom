<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<!-- Global Google  -->
		<meta charset="UTF-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<title><?php echo $title; ?></title>
		<base href="https://www.epapodetarot.com.br"/>
		<meta name="keywords" content="<?php echo $keywords; ?>"/>
		<meta name="description" content="<?php echo $metadescription; ?>"/>
		<meta name="author" content="Agência Nova Systems Marketing Digital"/>
		<meta name="generator" content="Nova Systems" />
		<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
		<link rel="shortcut icon" href="images/favicon.ico"/>
		<meta property="og:image" name="og:image" content="<?php echo $metaimage; ?>"/>
		<!-- <link rel="stylesheet" href="assets/preloader.css" media="print" onload="this.media='all'"/> -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Anek+Telugu:wght@400&display=swap" rel="stylesheet">
	  	<?php 
	  	if ($mostrarconversaogoogleads=="sim") {
	  	 	echo $conversaodogoogle;
	  	} 
	  	?>
		<!-- Smartsupp Live Chat script -->
		<script type="text/javascript">
		var _smartsupp = _smartsupp || {};
		_smartsupp.key = '72a03b11ee4f4248ebe32d043dd78767d9b7667c';
		window.smartsupp||(function(d) {
		var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
		s=d.getElementsByTagName('script')[0];c=d.createElement('script');
		c.type='text/javascript';c.charset='utf-8';c.async=true;
		c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
		})(document);
		</script>
	</head>
	<body role="document">

		<!-- Preloader -->
	    <div id="preloader">
	        <div class="inner">
	            <div class="bolas">
	                <div></div>
	                <div></div>
	                <div></div>                    
	            </div>
	        </div>
	    </div>