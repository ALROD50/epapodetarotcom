<!-- ATUALIZA EMAILS DE CLIENTES QUE ESTÃO ORÇANDO SERVIÇOS AUTOMATICAMENTE -->

<!-- EXCLUI TODOS OS E-MAILS ATUAIS DA CAMPANHA -->
<?php
$pdo->query("DELETE FROM mail_lista WHERE id_camp='15'");
?>

<!-- SELECIONA TODOS OS EMAILS DE CLIENTES QUE ESTÃO ORÇANDO EM ORÇAMENTOS -->
<?php
$sqlemail = $pdo->query("SELECT * FROM clientes WHERE nivel='CLIENTE' ");
while ($selecionaemail = $sqlemail->fetch(PDO::FETCH_ASSOC)) {
  
  $nome = $selecionaemail['nome'];
  $email = $selecionaemail['email'];
  $data = $selecionaemail['data_registro'];

  // ADICIONA OS E-MAILS NA LISTA DA CAMPANHA
  $pdo->query("INSERT INTO mail_lista (
    id_camp,
    nome,
    email,
    data
  ) VALUES (
    '15',
    '$nome',
    '$email',
    '$data'
  )");
}

// Redireciona de volta
$msgs = "E-mails Atualizados Com Sucesso!<br>";
echo "<script>document.location.href='minha-conta/?pg=mail/email_listar.php&msgs=$msgs&id=15'</script>"; 
?>