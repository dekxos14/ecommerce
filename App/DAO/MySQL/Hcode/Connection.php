<?php

namespace App\DAO\MySQL\Hcode;

abstract class Connection
{
    /**
     * Esse protected permite que as classes que hedarem de Connection também usem o PDO;
     * @var \PDO
     */
    protected $pdo;

    public function __construct()
    {
        $host = getenv('CODEEASY_GERENCIADOR_DE_LOJAS_MYSQL_HOST');
        $port = getenv('CODEEASY_GERENCIADOR_DE_LOJAS_MYSQL_PORT');
        $user = getenv('CODEEASY_GERENCIADOR_DE_LOJAS_MYSQL_USER');
        $pass = getenv('CODEEASY_GERENCIADOR_DE_LOJAS_MYSQL_PASSWORD');
        $dbname = getenv('CODEEASY_GERENCIADOR_DE_LOJAS_MYSQL_DBNAME');

        $dsn = "mysql:host={$host};dbname={$dbname};port={$port};charset=utf8";

        $this->pdo = new \PDO($dsn, $user, $pass);
        $this->pdo->setAttribute(
            \PDO::ATTR_ERRMODE,
            \PDO::ERRMODE_EXCEPTION
        );
    }
}
