<?php
// Formatando a data no formato brasileiro
$dataFormatada = date('d/m/Y', strtotime($clima->data));
?>

<div class="card-clima">
    <div class="cabecalho-card">
        <strong><?php echo $dataFormatada; ?></strong>
    </div>

    <div class="dados-principais">
        <div class="precipitacao">
            <span><?php echo $clima->chanceChuva; ?>%</span>
            <p>Chuva</p>
        </div>
        <div class="temperatura">
            <p>Min.: <?php echo number_format($clima->tempMinima, 1); ?>°</p>
            <p>Máx.: <?php echo number_format($clima->tempMaxima, 1); ?>°</p>
        </div>
    </div>

    <div class="grafico">
        <div class="barra" style="width:<?php echo $clima->chanceChuva; ?>%;"></div>
    </div>
</div>