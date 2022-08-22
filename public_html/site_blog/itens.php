<!-- caixa de verificação de exclusão -->
<script language='Javascript' type='text/javascript'>
function ConfirmaExclusao($id) {
  if( confirm( "Confirma Exclusão?" ) ) {
  location="minha-conta/?pg=site_blog/excluir_item.php&id="+$id;
  } else {
    alert("O Registro não foi excluido!");
  }
}
</script>

<h3 class="text-success">Blog - Artigos</h3>
<hr>

<a button class="btn btn-primary" style="" href="minha-conta/?pg=site_blog/itens_criar.php"><i class="fas fa-plus-circle"></i> Cadastrar Novo Artigo</button></a>

<?php 
include "filtro.php";


//Paginação-------------------------------------------------------------------------
/*
* Constantes usadas pela classe de conexão, poderia estar num arquivo externo.
*/
// o dsn é a string para conexão com o PDO que pode variar de banco para banco
// Por isto, preste atenção que nesta string temos o driver, o host e o banco(dbname)
defined('DSN') or define('DSN', 'mysql:host=localhost;dbname=epapodetarotcom_sistema');
defined('USUARIO') or define('USUARIO', 'epapodetarotcom_67674');
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
        echo " <li class='page-item'><a class='page-link' href='minha-conta/?pg=site_blog/itens.php&" . $this->paginador . "=1" . "'>Primeira</a></li> ";
        $anterior = $this->paginaAtual() - 1;
        echo " <li class='page-item'><a class='page-link' href='minha-conta/?pg=site_blog/itens.php&" . $this->paginador . "=" . $anterior  . "'>Anterior</a></li> ";
      }
            
      for ($x = ($this->paginaAtual() - $this->quantidade); $x < (($this->paginaAtual() + $this->quantidade) + 1); $x++) {
        if (($x > 0) && ($x <= $this->paginasTotais())) {
          if ($x == $this->paginaAtual()) {
            echo " <li class=\"page-item active\" aria-current='page'><a ><span class='page-link'>$x<span class='sr-only'>(current)</span></span></a></li> ";
          } else {
            echo " <li class='page-item'><a class='page-link' href='minha-conta/?pg=site_blog/itens.php&" . $this->paginador . "=" . $x  . "'>$x</a></li> ";
          }
        }
      }
      
      if ($this->paginaAtual() != $this->paginasTotais()) {
        $paginaProxima = $this->paginaAtual() + 1;
        echo " <li class='page-item'><a class='page-link' href='minha-conta/?pg=site_blog/itens.php&" . $this->paginador . "=" . $paginaProxima  . "'>Próxima</a></li> ";
        echo " <li class='page-item'><a class='page-link' href='minha-conta/?pg=site_blog/itens.php&" . $this->paginador . "=" . $this->paginasTotais()  . "'>Última</a></li> ";
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
$paginacao->sql = "select * from blog_itens WHERE status='Ativo' $filtro_buscar_escolhido ";

// Status dos Resultados
$paginacao->imprimeBarraResultados();
// A partir do método sql() de Paginacao_PDO

// Vamos listar os resultados
$res = $conexao->query($paginacao->sql());

?>
<div class="table-responsive">
<table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:12px;">
  <thead>
    <tr style="background:#265A88; color:#fff;">
      <th> ID</th>
      <th> Foto Principal</th>
      <th> Título</th>
      <th> Data</th>
      <th> Visualizações</th>
      <th> Categoria</th>
      <th> Status</th>
      <th> Visualizar</th>
      <th> Editar</th>
      <th> Excluir</th>
    </tr>
  </thead>
  <tbody>
  <?php  
    while($aux = $res->fetch(PDO::FETCH_ASSOC)) {
      $foto_abertura=$aux['foto_abertura'];
      $id=$aux['id'];
      $titulo=$aux['titulo'];
      $data=$aux['data'];
      $data = MostraDataCorretamente($data);
      $visualizacoes=$aux['visualizacoes'];
      $categoria=$aux['categoria'];
      $status=$aux['status'];
      $alias=$aux['alias'];
      $titulo_alias = TransformaAlias($titulo);
      $executa66 = $pdo->query("SELECT * FROM blog_categoria WHERE id='$categoria'");
      while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)){ 
        $categoria_nome=$dadoss66['titulo'];
        $categoria_alias=$dadoss66['alias'];
      }
      ?>
      <tr>
        <td><?php echo $id; ?></td>
        <td><?php echo "<img src='../images/blog/foto_abertura/$foto_abertura' height='50'/>"; ?></td>
        <td><?php echo $titulo; ?></td>
        <td><?php echo $data; ?></td>
        <td><?php echo $visualizacoes; ?></td>
        <td><?php echo @$categoria_nome; ?></td>
        <td>
        <?php 
          if ($status == 'Ativo') {
              $estiloStatusPagExtra = 'label label-success';
            } elseif ($status == 'Desativado') {
              $estiloStatusPagExtra = 'label label-danger';
            } else {
              $estiloStatusPagExtra = 'label label-default';
          }
          echo '<strong><span class="'.$estiloStatusPagExtra.'">'.$status.'</span></strong>';
        ?>
        </td>
        <td><a button class="btn btn-success btn-sm" <?php echo @"href='../blog-artigo/$categoria_alias/$alias'"; ?> target='_blank'><i class="fas fa-eye"></i> Visualizar</button></a></td>
        <td>
          <?php echo "<a href='minha-conta/?pg=site_blog/itens_editar.php&id=$id' title='Editar' class=\"btn btn-sm\"><i class=\"fas fa-edit\"></i> Editar</a>"; ?>
        </td>
        <td>
          <?php echo "<a href='javascript:;' onclick='ConfirmaExclusao($id);' data-toggle='tooltip' title='Excluir' class=\"btn btn-sm\"><i class=\"fas fa-trash\"></i> Excluir</a>"; ?>
        </td>
      </tr>
      <?php 
    } 
  ?>
  </tbody>
</table>
</div>
<?php
// Barra de Navegação
$paginacao->imprimeBarraNavegacao();
//Paginação -------------------------------------------------------------------------
?>