<!DOCTYPE html>
<html lang="pt-br">
	<head>
	    <!-- <script type="text/javascript">
	    var _smartsupp = _smartsupp || {};
	    _smartsupp.key = 'd91a374ad4f38486598b3f199ba67bc15239def7';
	    window.smartsupp||(function(d) {
	      var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
	      s=d.getElementsByTagName('script')[0];c=d.createElement('script');
	      c.type='text/javascript';c.charset='utf-8';c.async=true;
	      c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
	    })(document);
	    </script> -->
		<!-- Global Google  -->
	    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-163758748-1" crossorigin="anonymous"></script>
	    <script>
	      window.dataLayer = window.dataLayer || [];
	      function gtag(){dataLayer.push(arguments);}
	      gtag('js', new Date());
	      gtag('config', 'UA-163758748-1'); // Global site tag (gtag.js) - Google Analytics
	    </script>
		<meta charset="UTF-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<title><?php echo $title; ?></title>
		<base href="https://www.tarotdehorus.com.br"/>
		<meta name="keywords" content="<?php echo $keywords; ?>"/>
		<meta name="description" content="<?php echo $metadescription; ?>"/>
		<meta name="author" content="Agência Nova Systems Marketing Digital"/>
		<meta name="generator" content="Nova Systems" />
		<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
		<link rel="shortcut icon" href="images/favicon.ico"/>
		<meta property="og:image" name="og:image" content="<?php echo $metaimage; ?>"/>
		<link rel="stylesheet" href="assets/preloader.css" media="print" onload="this.media='all'"/>
	  	<?php 
	  	if ($mostrarconversaogoogleads=="sim") {
	  	 	echo $conversaodogoogle;
	  	} 
	  	?>
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