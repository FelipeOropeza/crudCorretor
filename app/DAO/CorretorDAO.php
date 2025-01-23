<?php

namespace App\DAO;

use PDO;
use App\Model\CorretorModel;

class CorretorDAO extends DAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create(CorretorModel $corretor)
    {
        try {
            $sql = "INSERT INTO corretores (name, cpf, creci) VALUES (:name, :cpf, :creci)";
            $stmt = $this->conexao->prepare($sql);

            $stmt->bindValue(':name', $corretor->getName());
            $stmt->bindValue(':cpf', $corretor->getCpf());
            $stmt->bindValue(':creci', $corretor->getCreci());

            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return 'CPF ou CRECI já cadastrados.';
            }
            return 'Erro ao criar corretor: ' . $e->getMessage();
        }
    }


    public function findAll()
    {
        try {
            $query = "SELECT * FROM corretores";
            $stmt = $this->conexao->query($query);

            $corretoresData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($corretoresData) {
                $corretores = [];
                foreach ($corretoresData as $data) {
                    $corretores[] = new CorretorModel(
                        $data['id'],
                        $data['name'],
                        $data['cpf'],
                        $data['creci']
                    );
                }
                return $corretores;
            }
            return [];
        } catch (\PDOException $e) {
            throw new \Exception("Erro ao buscar corretores: " . $e->getMessage());
        }
    }

    public function findById($id)
    {
        try {
            $sql = "SELECT * FROM corretores WHERE id = :id";
            $stmt = $this->conexao->prepare($sql);

            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $corretor = new CorretorModel(
                    $row['id'],
                    $row['name'],
                    $row['cpf'],
                    $row['creci']
                );

                return $corretor;
            } else {
                return null;
            }
        } catch (\PDOException $e) {
            return null;
        }
    }


    public function update(CorretorModel $corretor)
    {
        try {
            var_dump($corretor);
            $sql = "UPDATE corretores SET name = :name, cpf = :cpf, creci = :creci WHERE id = :id";
            $stmt = $this->conexao->prepare($sql);

            $stmt->bindValue(':id', $corretor->getId());
            $stmt->bindValue(':name', $corretor->getName());
            $stmt->bindValue(':cpf', $corretor->getCpf());
            $stmt->bindValue(':creci', $corretor->getCreci());

            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }


    public function delete($id)
    {
        try {
            $sql = "DELETE FROM corretores WHERE id = :id";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Erro ao excluir corretor: " . $e->getMessage());
        }
    }
}