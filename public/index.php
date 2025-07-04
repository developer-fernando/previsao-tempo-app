<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\Env;
use App\Controllers\ClimaController;
use App\Helpers\FormatacaoHelper;

Env::carregar();

$queryParaApi = $_GET['location_query'] ?? ($_GET['cidade'] ?? '');
$cidadeExibicaoNoInput = $_GET['cidade'] ?? '';

$mostrarTodos = isset($_GET['todos']);

$controller = new ClimaController();
$resultado = [];

if (!empty($queryParaApi)) {
    $resultado = $controller->buscarPorCidade($queryParaApi, $mostrarTodos);

    if (empty($cidadeExibicaoNoInput) && isset($resultado['location']['name'])) {
        $cidadeExibicaoNoInput = $resultado['location']['name'] . ', ' . $resultado['location']['region'] . ', ' . $resultado['location']['country'];
    }
}

include './templates/header.php';
?>

<main>
    <form method="GET" class="form-busca" autocomplete="off">
        <input type="text" name="cidade" placeholder="Digite a cidade..." value="<?php echo htmlspecialchars($cidadeExibicaoNoInput); ?>" required>
        <button type="submit">Buscar</button>
    </form>

    <?php if (!empty($queryParaApi)) : ?>
        <?php if (isset($resultado['erro'])) : ?>
            <p class="erro"><?php echo htmlspecialchars($resultado['erro']); ?></p>
        <?php else : ?>
            <div class="clima-atual">
                <h3>Clima Atual em <?php echo $resultado['location']['name'] . ' - ' . $resultado['location']['region'] . ', ' . $resultado['location']['country']; ?></h3>
                <p>Temperatura: <?php echo $resultado['current']['temp_c']; ?>°C</p>
                <p>Condição: <?php echo $resultado['current']['condition']['text']; ?></p>
                <img src="https:<?php echo $resultado['current']['condition']['icon']; ?>" alt="Ícone Clima">
            </div>

            <section class="secao-clima">
                <h2>Previsão dos Próximos Dias</h2>

                <?php foreach ($resultado['previsoes'] as $previsao) : ?>
                    <div class="card-clima">
                        <div class="cabecalho-card">
                            <strong><?php echo $previsao['data']; ?></strong>
                        </div>
                        <div class="dados-principais">
                            <div class="precipitacao">
                                <span><?php echo $previsao['chanceChuva']; ?>%</span>
                                <p>Chuva</p>
                            </div>
                            <div class="temperatura">
                                <p>Min.: <?php echo $previsao['minima']; ?>°</p>
                                <p>Máx.: <?php echo $previsao['maxima']; ?>°</p>
                            </div>
                        </div>
                        <div class="grafico">
                            <div class="barra" style="width:<?php echo $previsao['chanceChuva']; ?>%;"></div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if (!$mostrarTodos) : ?>
                    <a href="index.php?cidade=<?php echo urlencode($cidadeExibicaoNoInput); ?>&location_query=<?php echo urlencode($queryParaApi); ?>&todos=1" class="btn-acao">Ver Todos</a>
                <?php else : ?>
                    <a href="index.php?cidade=<?php echo urlencode($cidadeExibicaoNoInput); ?>&location_query=<?php echo urlencode($queryParaApi); ?>" class="btn-acao">Ocultar</a>
                <?php endif; ?>
            </section>
        <?php endif; ?>
    <?php else : ?>
        <p class="aviso">Por favor, informe uma cidade no campo acima para realizar a busca.</p>
    <?php endif; ?>
</main>

<script src="assets/js/script.js"></script>
<?php include './templates/footer.php'; ?>