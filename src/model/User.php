<?php

namespace App\Model;

use PDO;


class User
{
    private PDO $conexao;

    public function __construct(PDO $connection)
    {
        $this->conexao = $connection;
    }
    public function create(string $inputname,string $inputemail, string $inputpasword): int 
    {
        $hashedpassword = (password_hash($inputpasword, PASSWORD_DEFAULT));

        $sql = "INSERT INTO users (name , email, password) VALUES (:name,:email,:senha)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindValue(':name', $inputname);
        $stmt->bindValue(':email', $inputemail);
        $stmt->bindValue(':senha', $hashedpassword);

        $stmt->execute();

        return (int) $this->conexao->lastInsertId();
    }
    public function findByEmail(string $email):?array
    {
        $sql = "SELECT id, name, email, password FROM users WHERE email= :email";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        
            return $stmt->fetch(PDO::FETCH_ASSOC)?: null;
       
    }

}
