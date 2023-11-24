<?php
include 'firebird.php';
include 'mysql.php';

set_time_limit(0);

/* no arquivo php.ini
max_execution_time = 300  ; Defina um valor maior, como 300 segundos.*/

$chavePrimariaVdCliente = isset($_POST['chavePrimariaVdCliente']) ? $_POST['chavePrimariaVdCliente'] : "";
$chavePrimariaEqProduto = isset($_POST['chavePrimariaEqProduto']) ? $_POST['chavePrimariaEqProduto'] : "";
$chavePrimariaCpForneced = isset($_POST['chavePrimariaCpForneced']) ? $_POST['chavePrimariaCpForneced'] : "";
$chavePrimariaCpCompra   = isset($_POST['chavePrimariaCpCompra']) ? $_POST['chavePrimariaCpCompra'] : "";
$chavePrimariaVdVenda    = isset($_POST['chavePrimariaVdVenda']) ? $_POST['chavePrimariaVdVenda'] : "";
$codemp = isset($_POST['codemp']) ? $_POST['codemp'] : "";

$firebirdConexao = new FirebirdConexao();
$firebird = $firebirdConexao->getConexao();

function migraVDCliente($conexaoFirebird, $conexaoMySQL, $codemp) {
    try {
        // Consulta para obter a quantidade de registros da tabela vdcliente do Firebird
        $sqlFirebird = "SELECT COUNT(*) as total FROM vdcliente"; // Use letras minúsculas no nome da tabela
        $stmtFirebird = $conexaoFirebird->query($sqlFirebird);

        $totalRegistros = $stmtFirebird->fetchColumn();
        echo "Quantidade de registros no Firebird: " . $totalRegistros . "<br>";

        if ($totalRegistros > 0) {
            echo "Registros a serem migrados da tabela vdcliente: " . $totalRegistros . "<br>";

            $mysqlConexao = Conexao::getInstance(); // Obtém a conexão MySQL dentro da função
            
            
             // Primeiro, faça a inserção dos dados da tabela eqalmox
            $sqlFirebirdVdTipoCli = "SELECT * FROM vdtipocli";
            $stmtFirebirdVdTipoCli = $conexaoFirebird->query($sqlFirebirdVdTipoCli);

            foreach ($stmtFirebirdVdTipoCli as $rowFirebirdVdTipoCli) {
                // Ajuste os parâmetros de inserção da tabela eqalmox conforme necessário
                $sqlInsertVdTipoCli = "INSERT INTO vdtipocli (id, codtipocli, desctipocli, codemp) VALUES (NULL, :codtipocli, :desctipocli, :codemp)";
                $stmtInsertVdTipoCli = $mysqlConexao->prepare($sqlInsertVdTipoCli);
                $stmtInsertVdTipoCli->bindParam(':codtipocli', $rowFirebirdVdTipoCli['CODTIPOCLI'], PDO::PARAM_STR);
                $stmtInsertVdTipoCli->bindParam(':desctipocli', $rowFirebirdVdTipoCli['DESCTIPOCLI'], PDO::PARAM_STR);
                $stmtInsertVdTipoCli->bindParam(':codemp', $codemp, PDO::PARAM_STR);

                $stmtInsertVdTipoCli->execute();

                echo "Inserido novo registro para vdtipocli: " . $rowFirebirdVdTipoCli['CODTIPOCLI'] . "<br>";
            }
            
            
            // Primeiro, faça a inserção dos dados da tabela eqalmox
            $sqlFirebirdVdClasCli = "SELECT * FROM vdclascli";
            $stmtFirebirdVdClasCli = $conexaoFirebird->query($sqlFirebirdVdClasCli);

            foreach ($stmtFirebirdVdClasCli as $rowFirebirdVdClasCli) {
                // Ajuste os parâmetros de inserção da tabela eqalmox conforme necessário
                $sqlInsertVdClasCli = "INSERT INTO vdclascli (id, codclascli, descclascli, codemp) VALUES (NULL, :codclascli, :descclascli, :codemp)";
                $stmtInsertVdClasCli = $mysqlConexao->prepare($sqlInsertVdClasCli);
                $stmtInsertVdClasCli->bindParam(':codclascli', $rowFirebirdVdClasCli['CODCLASCLI'], PDO::PARAM_STR);
                $stmtInsertVdClasCli->bindParam(':descclascli', $rowFirebirdVdClasCli['DESCCLASCLI'], PDO::PARAM_STR);
                $stmtInsertVdClasCli->bindParam(':codemp', $codemp, PDO::PARAM_STR);

                $stmtInsertVdClasCli->execute();

                echo "Inserido novo registro para vdclascli: " . $rowFirebirdVdClasCli['CODCLASCLI'] . "<br>";
            }


            // Agora, faremos uma nova consulta para obter os registros da tabela vdcliente do Firebird
            $sqlFirebird = "SELECT * FROM vdcliente"; // Use letras minúsculas no nome da tabela
            $stmtFirebird = $conexaoFirebird->query($sqlFirebird);

            // Loop através dos registros do Firebird
            foreach ($stmtFirebird as $rowFirebird) {
                $codcliFirebird = $rowFirebird['CODCLI'];

                // Verificar se o codcli já existe na tabela vdcliente do MySQL
                $sqlMySQL = "SELECT codcli FROM vdcliente WHERE codcli = :codcli and codemp=:codemp";
                $stmtMySQL = $mysqlConexao->prepare($sqlMySQL);
                $stmtMySQL->bindParam(':codcli', $codcliFirebird, PDO::PARAM_STR);
                $stmtMySQL->bindParam(':codemp', $codemp, PDO::PARAM_STR );
                $stmtMySQL->execute();

                echo "Consulta MySQL para verificar se codcli existe retornou: " . $stmtMySQL->rowCount() . "<br>";

                // Se não existe, insira os dados
                if ($stmtMySQL->rowCount() == 0) {
                    $sqlInsert = "INSERT INTO vdcliente (id, codcli, razcli, nomecli, endcli, numcli, complcli, baircli, cidcli, cepcli, codemp, codclascli, codtipocli, datacli, ativocli, cnpjcli, insccli, cpfcli, rgcli, fonecli, dddcli, emailnfecli) VALUES (NULL, :codcli, :razcli, :nomecli, :endcli, :numcli, :complcli, :baircli, :cidcli, :cepcli, :codemp, :codclascli, :codtipocli, :datacli, :ativocli, :cnpjcli, :insccli, :cpfcli, :rgcli, :fonecli, :dddcli, :emailnfecli)";

                    $stmtInsert = $mysqlConexao->prepare($sqlInsert);
                    $stmtInsert->bindParam(':codcli', $codcliFirebird, PDO::PARAM_STR);
                    $stmtInsert->bindParam(':razcli', $rowFirebird['RAZCLI'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':nomecli', $rowFirebird['NOMECLI'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':endcli', $rowFirebird['ENDCLI'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':numcli', $rowFirebird['NUMCLI'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':complcli', $rowFirebird['COMPLCLI'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':baircli', $rowFirebird['BAIRCLI'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':cidcli', $rowFirebird['CIDCLI'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':cepcli', $rowFirebird['CEPCLI'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':codemp', $codemp, PDO::PARAM_STR);
                    $stmtInsert->bindParam(':codclascli', $rowFirebird['CODCLASCLI'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':codtipocli', $rowFirebird['CODTIPOCLI'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':datacli', $rowFirebird['DATACLI'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':ativocli', $rowFirebird['ATIVOCLI'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':cnpjcli', $rowFirebird['CNPJCLI'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':insccli', $rowFirebird['INSCCLI'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':cpfcli', $rowFirebird['CPFCLI'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':rgcli', $rowFirebird['RGCLI'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':fonecli', $rowFirebird['FONECLI'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':dddcli', $rowFirebird['DDDCLI'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':emailnfecli', $rowFirebird['EMAILNFECLI'], PDO::PARAM_STR);
    

                    $stmtInsert->execute();


                    echo "Inserido novo registro para codcli: " . $codcliFirebird . "<br>";


                 
                } else {
                    echo "Registro já existe para codcli: " . $codcliFirebird . "<br>";
                }
            }
        } else {
            echo "Nenhum registro a ser migrado da tabela vdcliente do Firebird.<br>";
        }
    } catch (PDOException $e) {
        echo "Erro na migração da tabela vdcliente: " . $e->getMessage() . "<br>";
    }
}

function migraEQProduto($conexaoFirebird, $conexaoMySQL, $codemp) {
    try {
        // Consulta para obter a quantidade de registros da tabela eqproduto do Firebird
        $sqlFirebird = "SELECT COUNT(*) as total FROM eqproduto";
        $stmtFirebird = $conexaoFirebird->query($sqlFirebird);

        $totalRegistros = $stmtFirebird->fetchColumn();
        echo "Quantidade de registros no Firebird (eqproduto): " . $totalRegistros . "<br>";

        $mysqlConexao = Conexao::getInstance(); // Obtém a conexão MySQL dentro da função

        if ($totalRegistros > 0) {
            echo "Registros a serem migrados da tabela eqproduto: " . $totalRegistros . "<br>";

            // Primeiro, faça a inserção dos dados da tabela eqalmox
            $sqlFirebirdEqAlmox = "SELECT * FROM eqalmox";
            $stmtFirebirdEqAlmox = $conexaoFirebird->query($sqlFirebirdEqAlmox);

            foreach ($stmtFirebirdEqAlmox as $rowFirebirdEqAlmox) {
                // Ajuste os parâmetros de inserção da tabela eqalmox conforme necessário
                $sqlInsertEqAlmox = "INSERT INTO eqalmox (id, codalmox, descalmox, codemp) VALUES (NULL, :codalmox, :descalmox, :codemp)";
                $stmtInsertEqAlmox = $mysqlConexao->prepare($sqlInsertEqAlmox);
                $stmtInsertEqAlmox->bindParam(':codalmox', $rowFirebirdEqAlmox['CODALMOX'], PDO::PARAM_STR);
                $stmtInsertEqAlmox->bindParam(':descalmox', $rowFirebirdEqAlmox['DESCALMOX'], PDO::PARAM_STR);
                $stmtInsertEqAlmox->bindParam(':codemp', $codemp, PDO::PARAM_STR);

                $stmtInsertEqAlmox->execute();

                echo "Inserido novo registro para codalmox: " . $rowFirebirdEqAlmox['CODALMOX'] . "<br>";
            }

            // Em seguida, faça a inserção dos dados da tabela eqmarca
            $sqlFirebirdEqMarca = "SELECT * FROM eqmarca";
            $stmtFirebirdEqMarca = $conexaoFirebird->query($sqlFirebirdEqMarca);

            foreach ($stmtFirebirdEqMarca as $rowFirebirdEqMarca) {
                // Ajuste os parâmetros de inserção da tabela eqmarca conforme necessário
                $sqlInsertEqMarca = "INSERT INTO eqmarca (id, codmarca, descmarca, codemp) VALUES (NULL, :codmarca, :descmarca, :codemp)";
                $stmtInsertEqMarca = $mysqlConexao->prepare($sqlInsertEqMarca);
                $stmtInsertEqMarca->bindParam(':codmarca', $rowFirebirdEqMarca['CODMARCA'], PDO::PARAM_STR);
                $stmtInsertEqMarca->bindParam(':descmarca', $rowFirebirdEqMarca['DESCMARCA'], PDO::PARAM_STR);
                $stmtInsertEqMarca->bindParam(':codemp', $codemp, PDO::PARAM_STR);

                $stmtInsertEqMarca->execute();

                echo "Inserido novo registro para codmarca: " . $rowFirebirdEqMarca['CODMARCA'] . "<br>";
            }

            // Agora, faça a inserção dos dados da tabela eqgrupo
            $sqlFirebirdEqGrupo = "SELECT * FROM eqgrupo";
            $stmtFirebirdEqGrupo = $conexaoFirebird->query($sqlFirebirdEqGrupo);

            foreach ($stmtFirebirdEqGrupo as $rowFirebirdEqGrupo) {
                // Ajuste os parâmetros de inserção da tabela eqgrupo conforme necessário
                $sqlInsertEqGrupo = "INSERT INTO eqgrupo (id, codgrup, descgrup, nivelgrup, codsubgrup, siglagrup, codemp) VALUES (NULL, :codgrup, :descgrup, :nivelgrup, :codsubgrup, :siglagrup,:codemp)";
                $stmtInsertEqGrupo = $mysqlConexao->prepare($sqlInsertEqGrupo);
                $stmtInsertEqGrupo->bindParam(':codgrup',    $rowFirebirdEqGrupo['CODGRUP'], PDO::PARAM_STR);
                $stmtInsertEqGrupo->bindParam(':descgrup',   $rowFirebirdEqGrupo['DESCGRUP'], PDO::PARAM_STR);
                $stmtInsertEqGrupo->bindParam(':nivelgrup',  $rowFirebirdEqGrupo['NIVELGRUP'], PDO::PARAM_STR);                
                $stmtInsertEqGrupo->bindParam(':codsubgrup', $rowFirebirdEqGrupo['CODSUBGRUP'], PDO::PARAM_STR);
                $stmtInsertEqGrupo->bindParam(':siglagrup',  $rowFirebirdEqGrupo['SIGLAGRUP'], PDO::PARAM_STR);
                $stmtInsertEqGrupo->bindParam(':codemp',     $codemp, PDO::PARAM_STR);

                $stmtInsertEqGrupo->execute();

                echo "Inserido novo registro para codgrupo: " . $rowFirebirdEqGrupo['CODGRUP'] . "<br>";
            }

            // Agora, faremos uma nova consulta para obter os registros da tabela eqproduto do Firebird
            $sqlFirebird = "SELECT * FROM eqproduto";
            $stmtFirebird = $conexaoFirebird->query($sqlFirebird);

            // Loop através dos registros do Firebird
            foreach ($stmtFirebird as $rowFirebird) {
                $codprodFirebird = $rowFirebird['CODPROD'];

                // Verificar se o codprod já existe na tabela eqproduto do MySQL
                $sqlMySQL = "SELECT codprod FROM eqproduto WHERE codprod = :codprod and codemp=:codemp";
                $stmtMySQL = $mysqlConexao->prepare($sqlMySQL);
                $stmtMySQL->bindParam(':codprod', $codprodFirebird, PDO::PARAM_STR);
                $stmtMySQL->bindParam(':codemp', $codemp, PDO::PARAM_STR);
                $stmtMySQL->execute();

                echo "Consulta MySQL para verificar se codprod existe retornou: " . $stmtMySQL->rowCount() . "<br>";

                // Se não existe, insira os dados
                if ($stmtMySQL->rowCount() == 0) {
                    $sqlInsert = "INSERT INTO eqproduto (id, codprod, descprod, refprod, codfisc, codmarca, descauxprod, tipoprod, codgrup, codfabprod, pesoliqprod, pesobrutprod, precobaseprod, custoinfoprod, sldprod, usareceitaprod, codemp) VALUES (NULL, :codprod, :descprod, :refprod, :codfisc, :codmarca, :descauxprod, :tipoprod, :codgrup, :codfabprod, :pesoliqprod, :pesobrutprod, :precobaseprod, :custoinfoprod, :sldprod, :usareceitaprod, :codemp)";
                    $stmtInsert = $mysqlConexao->prepare($sqlInsert);
                    $stmtInsert->bindParam(':codprod', $codprodFirebird, PDO::PARAM_STR);
                    $stmtInsert->bindParam(':descprod', $rowFirebird['DESCPROD'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':refprod', $rowFirebird['REFPROD'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':codfisc', $rowFirebird['CODFISC'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':codmarca', $rowFirebird['CODMARCA'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':descauxprod', $rowFirebird['DESCAUXPROD'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':tipoprod', $rowFirebird['TIPOPROD'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':codgrup', $rowFirebird['CODGRUP'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':codfabprod', $rowFirebird['CODFABPROD'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':pesoliqprod', $rowFirebird['PESOLIQPROD'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':pesobrutprod', $rowFirebird['PESOBRUTPROD'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':precobaseprod', $rowFirebird['PRECOBASEPROD'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':custoinfoprod', $rowFirebird['CUSTOINFOPROD'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':sldprod', $rowFirebird['SLDPROD'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':usareceitaprod', $rowFirebird['USARECEITAPROD'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':codemp', $codemp, PDO::PARAM_STR);

                    $stmtInsert->execute();

                    echo "Inserido novo registro para codprod: " . $codprodFirebird . "<br>";
                } else {
                    echo "Registro já existe para codprod: " . $codprodFirebird . "<br>";
                }
            }
        } else {
            echo "Nenhum registro a ser migrado da tabela eqproduto do Firebird.<br>";
        }
    } catch (PDOException $e) {
        echo "Erro na migração da tabela eqproduto: " . $e->getMessage() . "<br>";
    }
}


function migraCpForneced($conexaoFirebird, $conexaoMySQL, $codemp) {
    try {
        // Consulta para obter a quantidade de registros da tabela cpforneced do Firebird
        $sqlFirebird = "SELECT COUNT(*) as total FROM cpforneced";
        $stmtFirebird = $conexaoFirebird->query($sqlFirebird);

        $totalRegistros = $stmtFirebird->fetchColumn();
        echo "Quantidade de registros no Firebird (cpforneced): " . $totalRegistros . "<br>";

        $mysqlConexao = Conexao::getInstance(); // Obtém a conexão MySQL dentro da função

        if ($totalRegistros > 0) {
            echo "Registros a serem migrados da tabela cpforneced: " . $totalRegistros . "<br>";

            // Primeiro, faça a inserção dos dados da tabela eqalmox (semelhante ao que você fez para as outras tabelas)
            $sqlFirebirdCpTipoFor = "SELECT * FROM cptipofor";
            $stmtFirebirdCpTipoFor = $conexaoFirebird->query($sqlFirebirdCpTipoFor);

            foreach ($stmtFirebirdCpTipoFor as $rowFirebirdCpTipoFor) {
                // Ajuste os parâmetros de inserção da tabela eqalmox conforme necessário
                $sqlInsertCpTipoFor = "INSERT INTO cptipofor (id, codtipofor, desctipofor, codemp) VALUES (NULL, :codtipofor, :desctipofor, :codemp)";
                $stmtInsertCpTipoFor = $mysqlConexao->prepare($sqlInsertCpTipoFor);
                $stmtInsertCpTipoFor->bindParam(':codtipofor', $rowFirebirdCpTipoFor['CODTIPOFOR'], PDO::PARAM_STR);
                $stmtInsertCpTipoFor->bindParam(':desctipofor', $rowFirebirdCpTipoFor['DESCTIPOFOR'], PDO::PARAM_STR);
                $stmtInsertCpTipoFor->bindParam(':codemp', $codemp, PDO::PARAM_STR);
        
                $stmtInsertCpTipoFor->execute();

                echo "Inserido novo registro para CpTipoFor: " . $rowFirebirdCpTipoFor['CODTIPOFOR'] . "<br>";
            }


            // Agora, faça a inserção dos dados da tabela cpforneced (semelhante ao que você fez para vdcliente)
            $sqlFirebirdCpForneced = "SELECT * FROM cpforneced";
            $stmtFirebirdCpForneced = $conexaoFirebird->query($sqlFirebirdCpForneced);

            foreach ($stmtFirebirdCpForneced as $rowFirebirdCpForneced) {
                $codforFirebird = $rowFirebirdCpForneced['CODFOR'];

                // Verificar se o codfor já existe na tabela cpforneced do MySQL
                $sqlMySQL = "SELECT codfor FROM cpforneced WHERE codfor=:codfor and codemp=:codemp";
                $stmtMySQL = $mysqlConexao->prepare($sqlMySQL);
                $stmtMySQL->bindParam(':codfor', $codforFirebird, PDO::PARAM_STR);
                $stmtMySQL->bindParam(':codemp', $codemp, PDO::PARAM_STR);
                $stmtMySQL->execute();

                echo "Consulta MySQL para verificar se codfor existe retornou: " . $stmtMySQL->rowCount() . "<br>";

                // Se não existe, insira os dados
                if ($stmtMySQL->rowCount() == 0) {
                    $sqlInsert = "INSERT INTO cpforneced (id, codfor, razfor, nomefor, endfor, numfor, complfor, bairfor, cidfor, cepfor, codemp, codtipofor, datafor, ativofor, cnpjfor, inscfor, cpffor, rgfor, fonefor, dddfonefor, emailfor) VALUES (NULL, :codfor, :razfor, :nomefor, :endfor, :numfor, :complfor, :bairfor, :cidfor, :cepfor, :codemp, :codtipofor, :datafor, :ativofor, :cnpjfor, :inscfor, :cpffor, :rgfor, :fonefor, :dddfonefor, :emailfor)";
                    $stmtInsert = $mysqlConexao->prepare($sqlInsert);
                    $stmtInsert->bindParam(':codfor', $codforFirebird, PDO::PARAM_STR);
                    $stmtInsert->bindParam(':razfor', $rowFirebirdCpForneced['RAZFOR'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':nomefor', $rowFirebirdCpForneced['NOMEFOR'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':endfor', $rowFirebirdCpForneced['ENDFOR'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':numfor', $rowFirebirdCpForneced['NUMFOR'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':complfor', $rowFirebirdCpForneced['COMPLFOR'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':bairfor', $rowFirebirdCpForneced['BAIRFOR'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':cidfor', $rowFirebirdCpForneced['CIDFOR'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':cepfor', $rowFirebirdCpForneced['CEPFOR'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':codemp', $codemp, PDO::PARAM_STR);
                    $stmtInsert->bindParam(':codtipofor', $rowFirebirdCpForneced['CODTIPOFOR'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':datafor', $rowFirebirdCpForneced['DATAFOR'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':ativofor', $rowFirebirdCpForneced['ATIVOFOR'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':cnpjfor', $rowFirebirdCpForneced['CNPJFOR'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':inscfor', $rowFirebirdCpForneced['INSCFOR'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':cpffor', $rowFirebirdCpForneced['CPFFOR'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':rgfor', $rowFirebirdCpForneced['RGFOR'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':fonefor', $rowFirebirdCpForneced['FONEFOR'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':dddfonefor', $rowFirebirdCpForneced['DDDFONEFOR'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':emailfor', $rowFirebirdCpForneced['EMAILFOR'], PDO::PARAM_STR);
                  
                    $stmtInsert->execute();

                    echo "Inserido novo registro para codfor: " . $codforFirebird . "<br>";
                } else {
                    echo "Registro já existe para codfor: " . $codforFirebird . "<br>";
                }
            }
        } else {
            echo "Nenhum registro a ser migrado da tabela cpforneced do Firebird.<br>";
        }
    } catch (PDOException $e) {
        echo "Erro na migração da tabela cpforneced: " . $e->getMessage() . "<br>";
    }
}


function migraCpCompra($conexaoFirebird, $conexaoMySQL, $codemp) {
    try {
        // Consulta para obter a quantidade de registros da tabela cpcompra do Firebird
        $sqlFirebird = "SELECT COUNT(*) as total FROM cpcompra";
        $stmtFirebird = $conexaoFirebird->query($sqlFirebird);

        $totalRegistros = $stmtFirebird->fetchColumn();
        echo "Quantidade de registros no Firebird (cpcompra): " . $totalRegistros . "<br>";

        $mysqlConexao = Conexao::getInstance(); // Obtém a conexão MySQL dentro da função

        if ($totalRegistros > 0) {
            echo "Registros a serem migrados da tabela cpcompra: " . $totalRegistros . "<br>";

            // Agora, faça a inserção dos dados da tabela cpcompra (semelhante ao que você fez para eqproduto)
            $sqlFirebirdCpCompra = "SELECT * FROM cpcompra";
            $stmtFirebirdCpCompra = $conexaoFirebird->query($sqlFirebirdCpCompra);

            foreach ($stmtFirebirdCpCompra as $rowFirebirdCpCompra) {
                $codcompraFirebird = $rowFirebirdCpCompra['CODCOMPRA'];

                // Verificar se o codcompra já existe na tabela cpcompra do MySQL
                $sqlMySQL = "SELECT codcompra FROM cpcompra WHERE codcompra = :codcompra and codemp=:codemp";
                $stmtMySQL = $mysqlConexao->prepare($sqlMySQL);
                $stmtMySQL->bindParam(':codcompra', $codcompraFirebird, PDO::PARAM_STR);
                $stmtMySQL->bindParam(':codemp', $codemp, PDO::PARAM_STR);
                $stmtMySQL->execute();

                echo "Consulta MySQL para verificar se codcompra existe retornou: " . $stmtMySQL->rowCount() . "<br>";

                // Se não existe, insira os dados
                if ($stmtMySQL->rowCount() == 0) {
                    $sqlInsert = "INSERT INTO cpcompra (id, codcompra, codplanopag, codfor, serie, codtipomov, doccompra, dtemitcompra, dtcompcompra, vlrprodcompra, vlrliqcompra, vlrcompra, vlrdesccompra, vlrdescitcompra, vlradiccompra, vlrbaseicmscompra, vlrbaseipicompra, vlrbasecofinscompra, vlricmscompra, vlrfretecompra, tipofretecompra, chavenfecompra, statuscompra, codemp) VALUES (NULL, :codcompra, :codplanopag, :codfor, :serie, :codtipomov, :doccompra, :dtemitcompra, :dtcompcompra, :vlrprodcompra, :vlrliqcompra, :vlrcompra, :vlrdesccompra, :vlrdescitcompra, :vlradiccompra, :vlrbaseicmscompra, :vlrbaseipicompra, :vlrbasecofinscompra, :vlricmscompra, :vlrfretecompra, :tipofretecompra, :chavenfecompra, :statuscompra, :codemp)";
                    $stmtInsert = $mysqlConexao->prepare($sqlInsert);
                    $stmtInsert->bindParam(':codcompra', $codcompraFirebird, PDO::PARAM_STR);
                    $stmtInsert->bindParam(':codplanopag', $rowFirebirdCpCompra['CODPLANOPAG'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':codfor', $rowFirebirdCpCompra['CODFOR'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':serie', $rowFirebirdCpCompra['SERIE'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':codtipomov', $rowFirebirdCpCompra['CODTIPOMOV'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':doccompra', $rowFirebirdCpCompra['DOCCOMPRA'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':dtemitcompra', $rowFirebirdCpCompra['DTEMITCOMPRA'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':dtcompcompra', $rowFirebirdCpCompra['DTCOMPCOMPRA'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':vlrprodcompra', $rowFirebirdCpCompra['VLRPRODCOMPRA'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':vlrliqcompra', $rowFirebirdCpCompra['VLRLIQCOPMRA'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':vlrcompra', $rowFirebirdCpCompra['VLRCOMPRA'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':vlrdesccompra', $rowFirebirdCpCompra['VLRDESCCOMPRA'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':vlrdescitcompra', $rowFirebirdCpCompra['VLRDESCITCOMPRA'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':vlradiccompra', $rowFirebirdCpCompra['VLRADICCOMPRA'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':vlrbaseicmscompra', $rowFirebirdCpCompra['VLRBASEICMSCOMPRA'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':vlrbaseipicompra', $rowFirebirdCpCompra['VLRBASEIPICOMPRA'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':vlrbasecofinscompra', $rowFirebirdCpCompra['VLRBASECOFINSCOMPRA'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':vlricmscompra', $rowFirebirdCpCompra['VLRICMSCOMPRA'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':vlrfretecompra', $rowFirebirdCpCompra['VLRFRETECOMPRA'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':tipofretecompra', $rowFirebirdCpCompra['TIPOFRETECOMPRA'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':chavenfecompra', $rowFirebirdCpCompra['CHAVENFECOMPRA'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':statuscompra', $rowFirebirdCpCompra['STATUSCOMPRA'], PDO::PARAM_STR);
                    $stmtInsert->bindParam(':codemp', $codemp, PDO::PARAM_STR);

                    $stmtInsert->execute();
                    

                    echo "Inserido novo registro para codcompra: " . $codcompraFirebird . "<br>";

                    
                    // Após a inserção na tabela cpcompra, insira na tabela cpitcompra
                    $sqlFirebirdCpItCompra = "SELECT * FROM cpitcompra WHERE CODCOMPRA = :codcompra";
                    $stmtFirebirdCpItCompra = $conexaoFirebird->prepare($sqlFirebirdCpItCompra);

                    foreach ($stmtFirebirdCpCompra as $rowFirebirdCpCompra) {
                    $codcompraFirebird = $rowFirebirdCpCompra['CODCOMPRA'];

                        // Selecionar os itens da tabela cpitcompra relacionados a este codcompra
                        $stmtFirebirdCpItCompra->bindParam(':codcompra', $codcompraFirebird, PDO::PARAM_STR);
                        $stmtFirebirdCpItCompra->execute();

                        foreach ($stmtFirebirdCpItCompra as $rowFirebirdCpItCompra) {
                        // Verificar se o registro já existe na tabela cpitcompra do MySQL
                            $sqlMySQLCpItCompra = "SELECT id FROM cpitcompra WHERE id = :id";
                            $stmtMySQLCpItCompra = $mysqlConexao->prepare($sqlMySQLCpItCompra);
                            $stmtMySQLCpItCompra->bindParam(':id', $rowFirebirdCpItCompra['ID'], PDO::PARAM_STR);
                            $stmtMySQLCpItCompra->execute();

                            // Se não existe, insira os dados
                            if ($stmtMySQLCpItCompra->rowCount() == 0) {
                              // Continuação do seu código anterior
                                $sqlInsert = "INSERT INTO cpcompra (id, codcompra, codplanopag, codfor, serie, codtipomov, doccompra, dtemitcompra, dtcompcompra, vlrprodcompra, vlrliqcompra, vlrcompra, vlrdesccompra, vlrdescitcompra, vlradiccompra, vlrbaseicmscompra, vlrbaseipicompra, vlrbasecofinscompra, vlricmscompra, vlrfretecompra, tipofretecompra, chavenfecompra, statuscompra, codemp) VALUES (NULL, :codcompra, :codplanopag, :codfor, :serie, :codtipomov, :doccompra, :dtemitcompra, :dtcompcompra, :vlrprodcompra, :vlrliqcompra, :vlrcompra, :vlrdesccompra, :vlrdescitcompra, :vlradiccompra, :vlrbaseicmscompra, :vlrbaseipicompra, :vlrbasecofinscompra, :vlricmscompra, :vlrfretecompra, :tipofretecompra, :chavenfecompra, :statuscompra, :codemp)";
                                $stmtInsert = $mysqlConexao->prepare($sqlInsert);
                                $stmtInsert->bindParam(':codcompra', $codcompraFirebird, PDO::PARAM_STR);
                                // Continuar com os seguintes campos adicionados
                                $stmtInsert->bindParam(':coditcompra', $rowFirebirdCpCompra['CODITCOMPRA'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':codprod', $rowFirebirdCpCompra['CODPROD'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':codlote', $rowFirebirdCpCompra['CODLOTE'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':codnat', $rowFirebirdCpCompra['CODNAT'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':codalmox', $rowFirebirdCpCompra['CODALMOX'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':qtditcompra', $rowFirebirdCpCompra['QTDITCOMPRA'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':precoitcompra', $rowFirebirdCpCompra['PRECOITCOMPRA'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':percdescitcompra', $rowFirebirdCpCompra['PERCDESCITCOMPRA'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':vlrdescitcompra', $rowFirebirdCpCompra['VLRDESCITCOMPRA'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':percicmsitcompra', $rowFirebirdCpCompra['PERCICMSITCOMPRA'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':vlrbaseicmsitcompra', $rowFirebirdCpCompra['VLRBASEICMSITCOMPRA'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':vlricmsitcompra', $rowFirebirdCpCompra['VLRICMSITCOMPRA'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':percicmsstitcompra', $rowFirebirdCpCompra['PERCICMSSTITCOMPRA'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':vlrbaseicmsstitcompra', $rowFirebirdCpCompra['VLRBASEICMSSTITCOMPRA'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':vlricmsstitcompra', $rowFirebirdCpCompra['VLRICMSSTITCOMPRA'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':percipiitcompra', $rowFirebirdCpCompra['PERCIPIITCOMPRA'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':vlrbaseipiitcompra', $rowFirebirdCpCompra['VLRBASEIPIITCOMPRA'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':vlripiitcompra', $rowFirebirdCpCompra['VLRIPIITCOMPRA'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':vlrliqitcompra', $rowFirebirdCpCompra['VLRLIQITCOMPRA'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':vlradicitcomrpa', $rowFirebirdCpCompra['VLRADICITCOMPRA'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':vlrproditcompra', $rowFirebirdCpCompra['VLRPRODITCOMPRA'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':custoitcompra', $rowFirebirdCpCompra['CUSTOITCOMPRA'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':refprod', $rowFirebirdCpCompra['REFPROD'], PDO::PARAM_STR);
                                $stmtInsert->bindParam(':vlritoutrasdespitcompra', $rowFirebirdCpCompra['VLRITOUTRASDESPITCOMPRA'], PDO::PARAM_STR);


                                $stmtInsertCpItCompra->execute();
                            }
                        }
                    }
                    
                    

                } else {
                    echo "Registro já existe para codcompra: " . $codcompraFirebird . "<br>";
                }
            }
        } else {
            echo "Nenhum registro a ser migrado da tabela cpcompra do Firebird.<br>";
        }
    } catch (PDOException $e) {
        echo "Erro na migração da tabela cpcompra: " . $e->getMessage() . "<br>";
    }
}




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

        <?php
        echo "Código da Empresa (codemp) recebido: ";
        if (isset($codemp)) {
            echo $codemp;
        } else {
            echo "Nenhum valor recebido.";
        }

        echo "<br>";

        echo "Chave Primária vdcliente recebida: ";
        if (!empty($chavePrimariaVdCliente)) {
            echo $chavePrimariaVdCliente;
            migraVDCliente($firebird, $chavePrimariaVdCliente, $codemp); // Chamar a função migraVDCliente
        } else {
            echo "Nenhum valor recebido.";
        }

        echo "<br>";

        echo "Chave Primária eqproduto recebida: ";
        if (!empty($chavePrimariaEqProduto)) {
            echo $chavePrimariaEqProduto;
             migraEQProduto($firebird, $chavePrimariaEqProduto, $codemp);
        } else {

            echo "Nenhum valor recebido.";            
        }

        echo "<br>";

        echo "Chave Primária cpforneced recebida: ";
        if (!empty($chavePrimariaCpForneced)) {
            echo $chavePrimariaCpForneced;
            migraCpForneced($firebird, $chavePrimariaCpForneced, $codemp);
        } else {
            echo "Nenhum valor recebido.";
        }
        
        
        echo "<br>";

        echo "Chave Primária cpcompra recebida: ";
        if (!empty($chavePrimariaCpCompra)) {
            echo $chavePrimariaCpCompra;
            migraCpCompra($firebird, $chavePrimariaCpCompra, $codemp);
        } else {
            echo "Nenhum valor recebido.";
        }
        
        echo "<br>";

        echo "Chave Primária vdvenda recebida: ";
        if (!empty($chavePrimariaVdVenda)) {
            echo $chavePrimariaVdVenda;
            migraVdVenda($firebird, $chavePrimariaVdVenda, $codemp);
        } else {
            echo "Nenhum valor recebido.";
        }        
        ?>

    </div>
</body>
</html>