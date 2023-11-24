<?php
class FirebirdConexao {
    private $dbh; // Variável para armazenar a conexão

    public function __construct() {
        $host = FB_HOST;
        $database = FB_DATABASE;
        $username = FB_USER;
        $password = FB_PASSWORD;

        try {
            $this->dbh = new PDO("firebird:dbname=$host:$database", $username, $password);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro na conexão com o Firebird: " . $e->getMessage());
        }
    }

    public function getConexao() {
        return $this->dbh;
    }
}

// Define as informações de conexão com o Firebird
define('FB_HOST', 'localhost'); // Substitua pelo caminho correto do banco Firebird
define('FB_DATABASE', 'c:\sistemas\bancos\fertilizar_sped_dez.fdb'); // Substitua pelo nome do banco Firebird
define('FB_USER', 'sysdba'); // Substitua pelo nome de usuário do Firebird
define('FB_PASSWORD', 'masterkey'); // Substitua pela senha de conexão do Firebird
?>
