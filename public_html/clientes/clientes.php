<!-- caixa de verificação de exclusão -->
<script language='Javascript' type='text/javascript'>
function ConfirmaExclusao($id) {
  if( confirm( "Confirma Exclusão?" ) ) {
  location="minha-conta/?pg=clientes/excluir.php&id="+$id;
  } else {
    alert("O Registro não foi excluido!");
  }
}
</script>

<h3 class="text-success">Clientes</h3>
<hr>
<a button class="btn btn-primary float-right" href="minha-conta/?pg=clientes/criar.php"><i class="fas fa-user-plus"></i> Cadastrar Novo Cliente</button></a>

<?php 
include "filtro.php";
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
  public $limite = 50;
  public $quantidade = 20;

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
        echo " <li class='page-item'><a class='page-link' href='minha-conta/?pg=clientes/clientes.php&" . $this->paginador . "=1" . "'>Primeira</a></li> ";
        $anterior = $this->paginaAtual() - 1;
        echo " <li class='page-item'><a class='page-link' href='minha-conta/?pg=clientes/clientes.php&" . $this->paginador . "=" . $anterior  . "'>Anterior</a></li> ";
      }
            
      for ($x = ($this->paginaAtual() - $this->quantidade); $x < (($this->paginaAtual() + $this->quantidade) + 1); $x++) {
        if (($x > 0) && ($x <= $this->paginasTotais())) {
          if ($x == $this->paginaAtual()) {
            echo " <li class=\"page-item active\" aria-current='page'><a ><span class='page-link'>$x<span class='sr-only'>(current)</span></span></a></li> ";
          } else {
            echo " <li class='page-item'><a class='page-link' href='minha-conta/?pg=clientes/clientes.php&" . $this->paginador . "=" . $x  . "'>$x</a></li> ";
          }
        }
      }
      
      if ($this->paginaAtual() != $this->paginasTotais()) {
        $paginaProxima = $this->paginaAtual() + 1;
        echo " <li class='page-item'><a class='page-link' href='minha-conta/?pg=clientes/clientes.php&" . $this->paginador . "=" . $paginaProxima  . "'>Próxima</a></li> ";
        echo " <li class='page-item'><a class='page-link' href='minha-conta/?pg=clientes/clientes.php&" . $this->paginador . "=" . $this->paginasTotais()  . "'>Última</a></li> ";
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

$paginacao->sql = "select * from clientes WHERE nivel='CLIENTE' $filtro_buscar_escolhido $filtro_nome_escolhido $ordemv_escolhida ";

// Status dos Resultados
$paginacao->imprimeBarraResultados();
// A partir do método sql() de Paginacao_PDO

?>
<div class="row">
<?php
// Vamos listar os resultados
$res = $conexao->query($paginacao->sql());
?>
<div class="table-responsive">
<table class="table table-bordered table-condensed table-hover table-striped" style="margin-top:15px;">
  <thead>
    <tr style="background:#265A88; color:#fff;">
      <th>ID</th>
      <th><i class="glyphicon glyphicon-user"></i> Nome</th>
      <th><i class="glyphicon glyphicon-envelope"></i> Email</th>
      <th><i class="glyphicon glyphicon-earphone"></i> Telefone</th>
      <th><i class="glyphicon glyphicon-calendar"></i> Registro</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php 
    while ($aux = $res->fetch(PDO::FETCH_ASSOC)) {
      $id=$aux['id'];
      $nome=$aux['nome'];
      $nome = ucwords(strtolower($nome));
      $email=$aux['email'];
      $user=$aux['usuario'];
      $data_registro=$aux['data_registro'];
      $data_registro=MostraDataCorretamenteHora($data_registro);
      $telefone=$aux['telefone'];
      $telefone =  remover_caracter($telefone); 
      $telefone =  preg_replace("/_/", "", $telefone);
      ?>
      <tr>
        <td><?php echo $id; ?></td>
        <td><?php echo "<a href='minha-conta/?pg=clientes/view.php&id=$id' data-toggle='tooltip' title='$nome'>$nome</a>"."<a href='minha-conta/?pg=controle/add_credito.php&cliente=$id'> - <i class=\"fas fa-money-bill-alt\"></i></a>"; ?></td>
        <td><?php echo $email; ?></td>
        <td><?php echo "<a href=\"https://api.whatsapp.com/send?phone=55$telefone&text=Oi $nome, tudo bem? Sou a Patricia aqui do É Papo de Tarot, vi que é nova no site. Posso te ajudar a fazer sua consulta com nossos tarólogos? Quer saber como funciona?\" class=\"linkClientesAdmin\" target=\"_Blank\"><i class=\"fab fa-whatsapp\"></i>$telefone</a>"; ?></td>
        <td><?php echo $data_registro; ?></td>
        <td>
          <?php echo "<a href='javascript:;' onclick='ConfirmaExclusao($id);' data-toggle='tooltip' title='Excluir' class=\"btn btn-sm\"><i class=\"far fa-trash-alt\"></i></a>" ?>
        </td>
      </tr>
      <?php 
    } 
  ?>
  </tbody>
</table>
</div>
</div>
<div class="mb-5 mt-5"></div>
<?php
// Barra de Navegação
$paginacao->imprimeBarraNavegacao();
//Paginação -------------------------------------------------------------------------
?>