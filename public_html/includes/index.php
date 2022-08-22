<style>
	body {
	    overflow-x: hidden;
	    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji" !important;
		font-size: 1rem !important;
		font-weight: 400 !important;
		line-height: 1.5 !important;
		color: #212529 !important;
	}
	.estilomenu {
	    background-color: rgba(0, 0, 0, 0.7) !important;
	}
	#navbarSupportedContent {
	    display: none !important;
	}
	#menusitecell {
	    display: none !important;
	}
	footer {
	    display: none !important;
	}
	main {
	    background: rgba(255, 255, 255, 0.9) !important;
	}
	@media (max-width: 321px) {
		#usuarioboxlogado {
			font-size: 15px !important;
		}
	}
</style>
<?php
if ($row_onlinex=="offline" OR $row_onlinex=="") {
	echo "<script>document.location.href='https://www.epapodetarot.com.br/fazer-login'</script>";
	exit();
}

$paginaCorrente = isset($_GET['pg']) ? $_GET['pg'] : '';

//menus
if ($usuario_nivel == "ADMIN"){
	include "includes/menu.php";
} elseif ($usuario_nivel == 'CLIENTE') {
	include "includes/menu_cliente.php"; 
} elseif ($usuario_nivel == 'TAROLOGO') {
	include "includes/menu_tarologos.php"; 
}

//conteudos
if (isset($_GET['pg']) ? $_GET['pg'] : '') {
	include "".$_GET['pg'];
} elseif ($usuario_nivel == 'ADMIN') {
	include "includes/principal.php";
} elseif ($usuario_nivel == 'CLIENTE') {
	include "area_cliente/resumo.php";
} elseif ($usuario_nivel == 'TAROLOGO') {
	include "area_tarologos/resumo.php";
}