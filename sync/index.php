<?php

require_once('firebird.php');
require_once('mysql.php');


$firebirdConexao = new FirebirdConexao();
$firebird = $firebirdConexao->getConexao();

$mysql = conexao::getInstance(); 

?>


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

        .database-info {
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            padding: 10px;
            margin-top: 20px;
        }

        .form-container {
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            padding: 20px;
            margin-top: 20px;
        }

        .form-label {
            font-weight: bold;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-checkbox {
            margin-right: 10px;
        }

        .form-submit {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Migração de Dados</h1>

        <div class="database-info">
            <h2>Conexão com Firebird</h2>
            <?php
            require_once('firebird.php');?>
        </div>

        <div class="database-info">
            <h2>Conexão com Firebird</h2>
            <?php
            if ($firebird) {
                echo "Conectado ao Firebird com sucesso!";
            } else {
                echo "Erro na conexão com o Firebird.";
            }
            ?>
        </div>

        <div class="database-info">
            <h2>Conexão com MySQL</h2>
            <?php
            if ($mysql) {
                echo "Conectado ao MySQL com sucesso!";
            } else {
                echo "Erro na conexão com o MySQL.";
            }
            ?>
        </div>
        <div class="form-container">
            <form method="post" action="migracao.php">
    <label for="codemp">Código da Empresa (codemp):</label>
    <input type="text" id="codemp" name="codemp" require><br>

    <h2>Verificar Tabelas</h2>

    <label for="checkVdCliente">
        <input type="checkbox" id="checkVdCliente" name="checkVdCliente"> vdcliente
    </label><br>

    <label for="checkEqProduto">
        <input type="checkbox" id="checkEqProduto" name="checkEqProduto"> eqproduto
    </label><br>

    <label for="checkCpForneced">
        <input type="checkbox" id="checkCpForneced" name="checkCpForneced"> cpforneced
    </label><br>
    
   <label for="checkCpCompra">
        <input type="checkbox" id="checkCpCompra" name="checkCpCompra"> cpcompra
    </label><br>    
    
   <label for="checkVdVenda">
        <input type="checkbox" id="checkVdVenda" name="checkVdVenda"> vdvenda
    </label><br>    
    

    <input type="submit" value="Continuar">
</form>
        </div>
    </div>
</body>
</html>
