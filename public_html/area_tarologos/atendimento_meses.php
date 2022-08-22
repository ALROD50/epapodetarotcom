<h3 class="text-success mt-3">Atendimentos Realizados</h3>
<hr>

<ul class="nav nav-tabs" id="myTab" role="tablist" style="font-size:12px">
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='01'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabJaneiro-tab" href="#tabJaneiro" data-toggle="tab" role="tab" aria-controls="tabJaneiro">Janeiro</a>
  </li>
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='02'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabFevereiro-tab" href="#tabFevereiro" data-toggle="tab" role="tab" aria-controls="tabFevereiro">Fevereiro</a>
  </li>
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='03'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabMarco-tab" href="#tabMarco" data-toggle="tab" role="tab" aria-controls="tabMarco">Março</a>
  </li>
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='04'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabAbril-tab" href="#tabAbril" data-toggle="tab" role="tab" aria-controls="tabAbril">Abril</a>
  </li>
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='05'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabMaio-tab" href="#tabMaio" data-toggle="tab" role="tab" aria-controls="tabMaio">Maio</a>
  </li>
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='06'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabJunho-tab" href="#tabJunho" data-toggle="tab" role="tab" aria-controls="tabJunho">Junho</a>
  </li>
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='07'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabJulho-tab" href="#tabJulho" data-toggle="tab" role="tab" aria-controls="tabJulho">Julho</a>
  </li>
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='08'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabAgosto-tab" href="#tabAgosto" data-toggle="tab" role="tab" aria-controls="tabAgosto">Agosto</a>
  </li>
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='09'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabSetembro-tab" href="#tabSetembro" data-toggle="tab" role="tab" aria-controls="tabSetembro">Setembro</a>
  </li>
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='10'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabOutubro-tab" href="#tabOutubro" data-toggle="tab" role="tab" aria-controls="tabOutubro">Outubro</a>
  </li>
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='11'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabNovembro-tab" href="#tabNovembro" data-toggle="tab" role="tab" aria-controls="tabNovembro">Novembro</a>
  </li>
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='12'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabDezembro-tab" href="#tabDezembro" data-toggle="tab" role="tab" aria-controls="tabDezembro">Dezembro</a>
  </li>
</ul>

<div class="tab-content" id="myTabContent">
  <div <?php if ($data_mes == '01') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabJaneiro" role="tabpanel" aria-labelledby="tabJaneiro-tab">
    <?php $tab="01"; $mesatual="Janeiro"; include "atendimentos.php"; ?>
  </div>
  <div <?php if ($data_mes == '02') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabFevereiro" role="tabpanel" aria-labelledby="tabFevereiro-tab">
    <?php $tab="02"; $mesatual="Fevereiro"; include "atendimentos.php"; ?>
  </div>
  <div <?php if ($data_mes == '03') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabMarco" role="tabpanel" aria-labelledby="tabMarco-tab">
    <?php $tab="03"; $mesatual="Março"; include "atendimentos.php"; ?>
  </div>
  <div <?php if ($data_mes == '04') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabAbril" role="tabpanel" aria-labelledby="tabAbril-tab">
    <?php $tab="04"; $mesatual="Abril"; include "atendimentos.php";?>
  </div>
  <div <?php if ($data_mes == '05') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabMaio" role="tabpanel" aria-labelledby="tabMaio-tab">
    <?php $tab="05"; $mesatual="Maio"; include "atendimentos.php"; ?>
  </div>
  <div <?php if ($data_mes == '06') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabJunho" role="tabpanel" aria-labelledby="tabJunho-tab">
    <?php $tab="06"; $mesatual="Junho"; include "atendimentos.php";?>
  </div>
  <div <?php if ($data_mes == '07') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabJulho" role="tabpanel" aria-labelledby="tabJulho-tab">
    <?php $tab="07"; $mesatual="Julho"; include "atendimentos.php"; ?>
  </div>
  <div <?php if ($data_mes == '08') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabAgosto" role="tabpanel" aria-labelledby="tabAgosto-tab">
    <?php $tab="08"; $mesatual="Agosto"; include "atendimentos.php"; ?>
  </div>
  <div <?php if ($data_mes == '09') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabSetembro" role="tabpanel" aria-labelledby="tabSetembro-tab">
    <?php $tab="09"; $mesatual="Setembro"; include "atendimentos.php"; ?>
  </div>
  <div <?php if ($data_mes == '10') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabOutubro" role="tabpanel" aria-labelledby="tabOutubro-tab">
    <?php $tab="10"; $mesatual="Outubro"; include "atendimentos.php"; ?>
  </div>
  <div <?php if ($data_mes == '11') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabNovembro" role="tabpanel" aria-labelledby="tabNovembro-tab">
    <?php $tab="11"; $mesatual="Novembro"; include "atendimentos.php"; ?>
  </div>
  <div <?php if ($data_mes == '12') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabDezembro" role="tabpanel" aria-labelledby="tabDezembro-tab">
    <?php $tab="12"; $mesatual="Dezembro"; include "atendimentos.php"; ?>
  </div>
</div>
