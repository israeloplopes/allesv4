<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ean'])) {
    $ean = $_POST['ean'];

    // Seu código de consulta aqui

    $url = 'https://api.cosmos.bluesoft.com.br/gtins/' . $ean;
    $headers = array(
        "Content-Type: application/json",
        "X-Cosmos-Token: GgRkDNqKitG5BolwRQWfQg"
    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FAILONERROR, true);

    $data = curl_exec($curl);

    if ($data === false || $data == NULL) {
        echo "Erro na consulta: " . curl_error($curl);
    } else {
        $x = json_decode($data);

        // Verifique se as propriedades estão definidas antes de acessá-las
        $produto = isset($x->description) ? $x->description : "Produto não encontrado";
        $preco = isset($x->price) ? $x->price : "Preço indisponível";
        $marca = isset($x->brand->name) ? $x->brand->name : "Marca não disponível";
        $grupo = isset($x->gpc->description) ? $x->gpc->description : "Grupo não disponível";
        $ncm = isset($x->ncm->code) ? $x->ncm->code : "NCM não disponível";
        $peso = isset($x->net_weight) ? $x->net_weight : " não disponível";
        $fotoprod = isset($x->thumbnail) ? $x->thumbnail : "Imagem não disponível";

        // Exiba os resultados formatados em HTML
        echo '<table cellpadding="0" cellspacing="0" border="0" width="94%" align="center">';
        echo '<thead>';
        echo '<tr>';
        echo '<th rowspan="7" width="15%"><img src="' . $fotoprod . '" width="150" height="150"></th>';
        echo '</tr>';
        echo '<tr>';
        echo '<td width="50%"><strong>' . $produto . '</strong></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td width="15%">Preço ' . $preco . ' <small>no mercado</small></td>';
        echo '<td width="35%">Marca ' . $marca . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td width="15%">NCM ' . $ncm . ' <small></small></td>';
        echo '<td width="35%">Peso ' . $peso . '</td>';
        echo '</tr>';
        
        // ... (restante dos resultados)
        echo '</thead>';
        echo '</table>';
    }

    curl_close($curl);
} else {
    echo "Requisição inválida.";
}
?>
