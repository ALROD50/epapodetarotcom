<!-- Breadcumbs -->
<div class="card card-body mt-2 ml-2 mr-2 p-1 d-xl-block d-lg-block d-none">
  <!-- Go to www.addthis.com/dashboard to customize your tools -->
  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59681b17bd25eb95"></script>
  <div class="row">
    <div class="col-md-6 pt-3">
      <?php echo @"<p><a href='home'>Página Inicial</a> / <a href='loja'>Loja Virtual</a> / <a href='loja/$URLCATEGORIA'>$tituloCategoria </a> </p>"; ?>
    </div>
    <div class="col-md-6 text-right pt-3">
      <div class="addthis_inline_share_toolbox"></div>
    </div>
  </div>
</div>

<!-- Filtro, Lista de Anúncios Resultados -->
<div class="row mt-3">
  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12">
    <?php include "loja_site/filtro.php"; ?>
  </div>
  
  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-xs-12">

    <?php
    //Paginação-------------------------------------------------------------------------
    /*
    * Constantes usadas pela classe de conexão, poderia estar num arquivo externo.
    */
    // o dsn é a string para conexão com o PDO que pode variar de banco para banco
    // Por isto, preste atenção que nesta string temos o driver, o host e o banco(dbname)
    defined('DSN') or define('DSN', 'mysql:host=localhost;dbname=tarotdeh_sistema');
    defined('USUARIO') or define('USUARIO', 'tarotdeh_sistema');
    defined('SENHA') or define('SENHA', 'AZ4xGDcBI,Q+');

    /*
    * Classe para paginação em PDO
    */
    class Paginacao_PDO
    {
      public $paginador = 'pag';  
      private $solicitador;
      public $sql;
      public $limite = 10;
      public $quantidade = 5;

      // Construtor carrega a string usada para como paginador
      public function __construct() 
      {
        $this->solicitador = ( isset ($_REQUEST["{$this->paginador}"]) ) ? $_REQUEST["{$this->paginador}"] : 0 ;    
      }
      // Conexão privada
      private function conexao()
      {
        $conexao = new Conexao();
        $con = $conexao->conexao;
        return $con;
      }
      // Retorna o número de resultados encontrados 
      public function resultado()
      {
        $this->resultado = $this->conexao()->query(str_replace('*', 'COUNT(*)', $this->sql));
        $this->numeroResultados = $this->resultado->fetchColumn();
        return $this->numeroResultados;
      }
      // Imprime um texto amigável mostrando o status das paginas em relação ao resultado atual
      public function imprimeBarraResultados()
      {   
        if($this->resultado() > 0) {
          echo '<p class="info_resultado_busca">';
          echo 'Exibindo página <b>' . $this->paginaAtual() . '</b> de <b>' . $this->paginasTotais() . '</b> disponíveis para <b style="">'.$this->resultado().'</b> resultados encontrados.</p>';
        } else {
          ?>
          <div class="row" style="margin-top:20px;">
            <div class="col-md-12">
              <div class="card card-body" style="background:#fff; color:#383C3F;">
                </br>
                <center><p>Nenhum resultado encontrado para sua pesquisa!</p></center>
                <center><b>Use os filtros para ajustar melhor os resultados...</b></center>
                </br>
              </div>
            </div>
          </div>
          <?php
        } 
      } 
      // Calcula o número total de páginas
      public function paginasTotais()
      {   
        $paginasTotais = ceil($this->resultado() / $this->limite);
        return $paginasTotais;
      }
      // Procura o número da página Atual
      public function paginaAtual()
      {
        if (isset($this->solicitador) && is_numeric($this->solicitador)) {     
          $this->paginaAtual = (int) $this->solicitador;
        } else {
          $this->paginaAtual = 1;
        }

        if ($this->paginaAtual > $this->paginasTotais()) {
          $this->paginaAtual = $this->paginasTotais();
        }

        if ($this->paginaAtual < 1) {
          $this->paginaAtual = 1;
        }

        return $this->paginaAtual;
        
      }
      // Calcula o offset da consulta
      private function offset()
      {
        $offset = ($this->paginaAtual() - 1) * $this->limite; 
        return $offset;
      }
      // Retorna o SQL para trabalhar posteriormente
      public function sql()
      {
        $sql = $this->sql . " LIMIT {$this->limite} OFFSET {$this->offset()} ";
        return $sql;
      }
      // Imprime a barra de navegação da paginaçaõ
      public function imprimeBarraNavegacao() 
      {
        if($this->resultado() > 0) {    
          ?>
          <style type="text/css">
            .pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
              z-index: 2;
              color: #fff;
              cursor: default;
              background-color: #E30266;
              border-color: #E30266;
            }
          </style>
          <?php
          // . $this->reconstruiQueryString($this->paginador) - código ficava depois de: "=" . 
          echo "<nav aria-label=\"Page navigation\">";
          echo "<ul class=\"pagination\">";
          if ($this->paginaAtual() > 1) {
            echo " <li class='page-item'><a class='page-link' href='loja/?" . $this->paginador . "=1" . "'>Primeira</a></li> ";
            $anterior = $this->paginaAtual() - 1;
            echo " <li class='page-item'><a class='page-link' href='loja/?" . $this->paginador . "=" . $anterior  . "'>Anterior</a></li> ";
          }
                
          for ($x = ($this->paginaAtual() - $this->quantidade); $x < (($this->paginaAtual() + $this->quantidade) + 1); $x++) {
            if (($x > 0) && ($x <= $this->paginasTotais())) {
              if ($x == $this->paginaAtual()) {
                echo " <li class=\"page-item active\" aria-current='page'><a ><span class='page-link'>$x<span class='sr-only'>(current)</span></span></a></li> ";
              } else {
                echo " <li class='page-item'><a class='page-link' href='loja/?" . $this->paginador . "=" . $x  . "'>$x</a></li> ";
              }
            }
          }
          
          if ($this->paginaAtual() != $this->paginasTotais()) {
            $paginaProxima = $this->paginaAtual() + 1;
            echo " <li class='page-item'><a class='page-link' href='loja/?" . $this->paginador . "=" . $paginaProxima  . "'>Próxima</a></li> ";
            echo " <li class='page-item'><a class='page-link' href='loja/?" . $this->paginador . "=" . $this->paginasTotais()  . "'>Última</a></li> ";
          }
          echo "</ul>";
          echo "</nav><br>";
        } 
      }
      // Monta os valores da Query String novamente
      public function reconstruiQueryString($valoresQueryString) {
        if (!empty($_SERVER['QUERY_STRING'])) {
          $partes = explode("&", $_SERVER['QUERY_STRING']);
          $novasPartes = array();
          foreach ($partes as $val) {
            if (stristr($val, $valoresQueryString) == false)  {
              array_push($novasPartes, $val);
            }
          }
          if (count($novasPartes) != 0) {
            $queryString = "&".implode("&", $novasPartes);
          } else {
            return false;
          }
          return $queryString; // nova string criada
        } else {
          return false;
        }
      } 
      
    }
    // Você pode criar outra forma de conexão se desejar
    class Conexao
    {
      private $_usuario;
      private $_senha;
      private $_dsn;
      
      public function __construct()
      {
        $this->defineUsuario(USUARIO);
        $this->defineSenha(SENHA);
        $this->defineDSN(DSN);  
        $this->abreConexao();
      }
      // Define o Usuário
      public function defineUsuario($usuario)
      {
        $this->_usuario = $usuario;
      }
      // Define a Senha   
      public function defineSenha($senha)
      {
        $this->_senha = $senha;
      }
      // Define o DSN   
      public function defineDSN($dns)
      {
        $this->_dsn = $dns;
      }
      // Abre a conexão sem retornar a mesma
      public function abreConexao()
      {
        $this->conexao = new PDO($this->_dsn, $this->_usuario, $this->_senha);
        $this->conexao->query("SET NAMES utf8");
      }
      // Fecha a conexao
      public function fechaConexao()
      {
        $this->_conexao = null;
      }
    }

    // Para trabalharmos externamente à classe Paginacao_PDO
    $conexao = new Conexao();
    $conexao = $conexao->conexao;
    // Iniciamos a paginacao
    $paginacao = new Paginacao_PDO();

    // Verifica se existe a variavel do filtro na URL
    if ($CategoriaLojaAtiva == 'SIM') {
      $paginacao->sql = "select * from loja_produtos WHERE status='Ativo' AND estoque>0 AND categoria='$idCategoria' ";
    } else {
      $paginacao->sql = "select * from loja_produtos WHERE status='Ativo' AND estoque>0 ";
    }
    
    // Status dos Resultados
    $paginacao->imprimeBarraResultados();
    // A partir do método sql() de Paginacao_PDO
   
    // Vamos listar os resultados
    $res = $conexao->query($paginacao->sql());
    while($r = $res->fetch(PDO::FETCH_OBJ)) {
      // print $r->titulo;
      $id_anuncio=$r->id;
      $titulo=$r->titulo;
      $titulo = ucfirst(strtolower($titulo));
      $alias=$r->alias;
      $descricao=$r->descricao;
      $descricao = strip_tags($descricao);
      $descricaodois=limita_caracteres($descricao, '150', $quebra = true);
      $foto_abertura=$r->foto_abertura;
      $altura=$r->altura;
      $largura=$r->largura;
      $comprimento=$r->comprimento;
      $peso=$r->peso;
      $fotos=$r->fotos;
      $precobd=$r->preco;
      $preco=MostraValorDinheiroCorretamente($precobd);
      $visualizacoes=$r->visualizacoes;
      $categoria=$r->categoria;
      $executa66 = $pdo->query("SELECT * FROM loja_categorias WHERE id='$categoria'");
      while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)) { 
        $categoria_nome=$dadoss66['titulo'];
        $categoria_alias=$dadoss66['alias'];
      }
      $status=$r->status;
      $estoque=$r->estoque;
      $meta_descricao=$r->meta_descricao;
      $meta_keywords=$r->meta_keywords;
      ?>
      <div class="row" style="margin-bottom:10px;">
        
        <div class="col-md-4">
          <!-- Foto de Principal -->
          <a href='<?php echo "https://www.tarotdehorus.com.br/loja-item/$categoria_alias/$alias"; ?>' title="<?php echo $titulo; ?>">
            <div id="" class='img-thumbnail rounded efeitodois' style="height: 168px; width: 262px; background-position: center; background-size: cover; background-image: url('<?php echo 'https://www.tarotdehorus.com.br/loja_admin/foto_abertura/'.$foto_abertura; ?>');">
            </div>
          </a>
        </div>
        
        <div class="col-md-8" style="padding-top: 0px;">
          
          <!-- Título -->
          <a href='<?php echo "https://www.tarotdehorus.com.br/loja-item/$categoria_alias/$alias"; ?>' title="<?php echo $titulo; ?>"><h3 style="margin-top: 0px;"><?php echo $titulo; ?></h3></a>

          <!-- Preço -->
          <h3><?php echo $preco; ?></h3>

          <!-- Descrição -->
          <?php echo strip_tags($descricaodois); ?><br>

          <!-- Adicionar ao Carrinho -->
          <form id="addCarrinho" name="addCarrinho" method="post" action="carrinho-compras" class="form-horizontal" style="padding: 0; margin: 0;">
            <input type="hidden" name="id_anuncio" value="<?php echo $id_anuncio; ?>" />
            <input type="hidden" name="quantidadeselecionada" value="1" />
            <input type="hidden" name="preco" value="<?php echo $precobd; ?>" />
            <input type="hidden" name="altura" value="<?php echo $altura; ?>" />
            <input type="hidden" name="largura" value="<?php echo $largura; ?>" />
            <input type="hidden" name="comprimento" value="<?php echo $comprimento; ?>" />
            <input type="hidden" name="peso" value="<?php echo $peso; ?>" />
            <button name="enviarAddCarrinho" id="enviarAddCarrinho" class="btn btn-md btn-danger"><i class="fas fa-shopping-cart center"></i> COMPRAR</button>
          </form>
        
        </div>
      </div>

      <hr>
      <?php
    }
    // Barra de Navegação
    $paginacao->imprimeBarraNavegacao();
    //Paginação -------------------------------------------------------------------------
    ?>

  </div>
</div>