<!-- Filtro, Lista de Anúncios Resultados -->
<div class="row mt-3">
  <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12 px-0">
    <?php include "site_blog/site_categorias.php"; ?>
  </div>
  
  <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-xs-12 pr-0">

    <?php
    //Paginação-------------------------------------------------------------------------
    /*
    * Constantes usadas pela classe de conexão, poderia estar num arquivo externo.
    */
    // o dsn é a string para conexão com o PDO que pode variar de banco para banco
    // Por isto, preste atenção que nesta string temos o driver, o host e o banco(dbname)
    defined('DSN') or define('DSN', 'mysql:host=localhost;dbname=epapodetarotcom_sistema');
    defined('USUARIO') or define('USUARIO', 'epapodetarotcom_67674');
    defined('SENHA') or define('SENHA', 'r5cug6wdj7offsts3t');

    /*
    * Classe para paginação em PDO
    */
    class Paginacao_PDO
    {
      public $paginador = 'pag';  
      private $solicitador;
      public $sql;
      public $limite = 9;
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
          
        	echo '<h1><i class="far fa-newspaper"></i> Blog É Papo de Tarot</h1><hr>';
			//echo '<p class="info_resultado_busca">';
			//echo 'Exibindo página <b>' . $this->paginaAtual() . '</b> de <b>' . $this->paginasTotais() . '</b> disponíveis para <b style="">'.$this->resultado().'</b> resultados encontrados.</p>';
        } else {
          ?>
          <div class="row" style="margin-top:20px;">
            <div class="col-md-12">
              <div class="card card-body" style="background:#fff; color:#383C3F;">
                </br>
                <center><p>Nenhum resultado encontrado para sua pesquisa!</p></center>
                <center><b>Use as categorias para ajustar o resultado...</b></center>
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
            echo " <li class='page-item'><a class='page-link' href='blog/?" . $this->paginador . "=1" . "'>Primeira</a></li> ";
            $anterior = $this->paginaAtual() - 1;
            echo " <li class='page-item'><a class='page-link' href='blog/?" . $this->paginador . "=" . $anterior  . "'>Anterior</a></li> ";
          }
                
          for ($x = ($this->paginaAtual() - $this->quantidade); $x < (($this->paginaAtual() + $this->quantidade) + 1); $x++) {
            if (($x > 0) && ($x <= $this->paginasTotais())) {
              if ($x == $this->paginaAtual()) {
                echo " <li class=\"page-item active\" aria-current='page'><a ><span class='page-link'>$x<span class='sr-only'>(current)</span></span></a></li> ";
              } else {
                echo " <li class='page-item'><a class='page-link' href='blog/?" . $this->paginador . "=" . $x  . "'>$x</a></li> ";
              }
            }
          }
          
          if ($this->paginaAtual() != $this->paginasTotais()) {
            $paginaProxima = $this->paginaAtual() + 1;
            echo " <li class='page-item'><a class='page-link' href='blog/?" . $this->paginador . "=" . $paginaProxima  . "'>Próxima</a></li> ";
            echo " <li class='page-item'><a class='page-link' href='blog/?" . $this->paginador . "=" . $this->paginasTotais()  . "'>Última</a></li> ";
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
    if ($CategoriaBlogAtiva == 'SIM') {
      $paginacao->sql = "select * from blog_itens WHERE status='Ativo' AND categoria='$idCategoria' ";
    } else {
      $paginacao->sql = "select * from blog_itens WHERE status='Ativo'";
    }
    
    // Status dos Resultados
    $paginacao->imprimeBarraResultados();
    // A partir do método sql() de Paginacao_PDO
   
    ?>
    <div class="row">
    <?php
    // Vamos listar os resultados
    $res = $conexao->query($paginacao->sql());
    while($r = $res->fetch(PDO::FETCH_OBJ)) {
		// print $r->titulo;
		$id_post=$r->id;
		$titulo=$r->titulo;
		$alias=$r->alias;
		$texto=$r->texto;
		$texto = strip_tags($texto);
		$textocurta=limita_caracteres($texto, '105', $quebra = true);
		$foto_abertura=$r->foto_abertura;
		$visualizacoes=$r->visualizacoes;
		$categoria=$r->categoria;
		$executa66 = $pdo->query("SELECT * FROM blog_categoria WHERE id='$categoria'");
		while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)) { 
			$categoria_nome=$dadoss66['titulo'];
			$categoria_alias=$dadoss66['alias'];
		}
		?>
		<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-3">
			<div class="card">
			  <img src="<?php echo 'https://www.epapodetarot.com.br/images/blog/foto_abertura/'.$foto_abertura; ?>" class="card-img-top" alt="<?php echo $titulo; ?>" title="<?php echo $titulo; ?>">
			  <div class="card-body">
			    <h3 class="text-primary"><?php echo $titulo; ?></h3>
			    <p class="card-text" style="font-size:18px;"><?php echo $textocurta; ?></p>
			    <a href="<?php echo "https://www.epapodetarot.com.br/blog-artigo/$categoria_alias/$alias"; ?>" class="btn btn-lg btn-warning">Ler Artigo</a>
			  </div>
			</div>
		</div>
		<?php
    }
    ?>
    </div>
    <div class="mb-5 mt-5"></div>
    <?php
    // Barra de Navegação
    $paginacao->imprimeBarraNavegacao();
    //Paginação -------------------------------------------------------------------------
    ?>

  </div>
</div>