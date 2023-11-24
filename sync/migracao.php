<?php
$codemp = $_POST['codemp'];
$vdclienteChecked = isset($_POST['checkVdCliente']) && $_POST['checkVdCliente'] === "on";
$eqprodutoChecked = isset($_POST['checkEqProduto']) && $_POST['checkEqProduto'] === "on";
$cpfornecedChecked = isset($_POST['checkCpForneced']) && $_POST['checkCpForneced'] === "on";
$cpcompraChecked = isset($_POST['checkCpCompra']) && $_POST['checkCpCompra'] === "on";
$vdvendaChecked = isset($_POST['checkVdVenda']) && $_POST['checkVdVenda'] === "on";

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Migração de Dados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Migração de Dados</h1>

        <form method="post" action="migrado.php">
            <h2>Chaves Primárias</h2>

            <?php if ($vdclienteChecked): ?>
            <label for="chavePrimariaVdCliente">Chave Primária vdcliente (Clientes | Classificação | Tipo de Cliente (Firebird)):</label>
            <input type="text" id="chavePrimariaVdCliente" name="chavePrimariaVdCliente" onChange="javascript:this.value=this.value.toLowerCase();"><br>
            <?php endif; ?>

            <?php if ($eqprodutoChecked): ?>
            <label for="chavePrimariaEqProduto">Chave Primária eqproduto (Produtos | Grupos | Marcas | Unidades (Firebird)):</label>
            <input type="text" id="chavePrimariaEqProduto" name="chavePrimariaEqProduto" onChange="javascript:this.value=this.value.toLowerCase();"><br>
            <?php endif; ?>

            <?php if ($cpfornecedChecked): ?>
            <label for="chavePrimariaCpForneced">Chave Primária cpforneced (Fornecedores | Tipos de Fornecedores (Firebird)):</label>
            <input type="text" id="chavePrimariaCpForneced" name="chavePrimariaCpForneced" onChange="javascript:this.value=this.value.toLowerCase();"><br>
            <?php endif; ?>

            <?php if ($cpcompraChecked): ?>
            <label for="chavePrimariaCpCompra">Chave Primária cpcompra (Compras | Itens | Contas a Pagar (Firebird)):</label>
            <input type="text" id="chavePrimariaCpCompra" name="chavePrimariaCpCompra" onChange="javascript:this.value=this.value.toLowerCase();"><br>
            <?php endif; ?>
            
            <?php if ($vdvendaChecked): ?>
            <label for="chavePrimariaVdVenda">Chave Primária vdvenda (Vendas | Itens | Contas a Receber Firebird)):</label>
            <input type="text" id="chavePrimariaVdVenda" name="chavePrimariaVdVenda" onChange="javascript:this.value=this.value.toLowerCase();"><br>
            <?php endif; ?>            


            <input type="hidden" name="codemp" value="<?php echo $codemp; ?>">

            <input type="submit" value="Iniciar Migração" onclick="return confirm('Tem certeza de que deseja iniciar a migração?')">
        </form>
    </div>
</body>
</html>
