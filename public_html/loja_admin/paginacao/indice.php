<style type="text/css">
    #paginacao {font-family: Verdana, Arial, Helvetica; font-size: 12px;}
    .pgoff {color: #FF0000; text-decoration: none;}
    a.pg {color: #003366; text-decoration: none;}
    a:hover.pg {color: #0066cc; text-decoration:underline;}
</style>
<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8

echo "<div id='paginacao'>";
    //Verificando se estamos na primeira página se não estivetr ele imprime o botão de anterior e o numero da primeira página
    //Se não ele desativa o botão de anterior e seta o indicador na primeira página
    if ($pagina > 1) {
        echo '&nbsp;<a class="pg" href="javascript:paginar(' . ($pagina - 2) . ',' . $paginas . ',' . $quant_resul . ')">&laquo; anterior</a>&nbsp;';
        echo '&nbsp;<a class="pg" href="javascript:paginar(0,' . $paginas . ',' . $quant_resul . ')">1</a>&nbsp;';
    } else {
        echo "<font  color=#CCCCCC>&laquo; anterior</font>";
        echo "&nbsp;<span class='pgoff'>[1]</span>&nbsp;";
    }
    // imprimindo as demais páginas

    for ($i = $pagina; $i <= ($pagina + 1); $i++) {
        //imprindo o botão da página antes da atual, ela necessita ser diferente da primeira página
        if (($i - 1) == ($pagina - 1) and ($i - 1) != 1 and ($i != 1)) {
            echo '...&nbsp;<a class="pg" href="javascript:paginar(' . ($i - 2) . ',' . $paginas . ',' . $quant_resul . ')">' . ($i - 1) . '</a>&nbsp;';
        }
        // verificando se estamos na primeira página ou na ultima se estiver ele não imprime nada.
        if ($i == 1 or $i == $paginas or $i == $paginas) {
            echo"";
        }
        // se a página for igual a página atual ele seta o indicador na página e desativa o botão
        elseif ($pagina == $i) {
            echo "&nbsp;<span class='pgoff'>[$i]</span>&nbsp;";
        }
        //imprimindo a página após a página atual,
        elseif ($i < $pagina) {
            echo '&nbsp;<a class="pg" href="javascript:paginar(' . $i - 1 . ',' . $paginas . ',' . $quant_resul . ')">' . $i . '</a>&nbsp;';
        }
        if (($i + 1) == ($pagina + 1) and ($i + 1) != $paginas and $i != $paginas) {
            echo '&nbsp;<a class="pg" href="javascript:paginar(' . ($i) . ',' . $paginas . ',' . $quant_resul . ')">' . ($i + 1) . '</a>&nbsp;...';
        }
    }
    // verificando novamente se existe apenas a primeira página, se so existir ela é impresso o botão proximo desativado
    if ($paginas == 1) {
        echo "";
        echo "<font  color=#CCCCCC>próximo &raquo;</font>";
    }
    //verificando se a página atual é diferente  da ultima página se for diferente ele imprime a ultima página e ativa o botão próximo
    elseif ($pagina < $paginas) {

        echo '&nbsp;<a class="pg"  href="javascript:paginar(' . ($paginas - 1) . ',' . $paginas . ',' . $quant_resul . ')">' . $paginas . '</a>';
        echo '&nbsp;<a class="pg" href="javascript:paginar(' . ($pagina) . ',' . $paginas . ',' . $quant_resul . ')"><b>próximo &raquo;</b></a>&nbsp;';
    }
    // se o sistema estiver na ultima página o indicador é setado na página e o botão próximo é desativado
    else {
        echo "&nbsp;<span class='pgoff'>[" . $paginas . "]</span>&nbsp;";
        echo "<font  color=#CCCCCC>próximo &raquo;</font>";
    }
echo "</div><br>";
?>