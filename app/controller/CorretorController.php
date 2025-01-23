<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Model\CorretorModel;
use App\DAO\CorretorDAO;

class CorretorController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $flashSuccessMessage = $_SESSION['flashSuccessMessage'] ?? null;
        $flashErrorMessage = $_SESSION['flashErrorMessage'] ?? null;

        unset($_SESSION['flashSuccessMessage']);
        unset($_SESSION['flashErrorMessage']);

        $corretorDAO = new CorretorDAO();
        $corretores = $corretorDAO->findAll();

        $message = empty($corretores) ? 'Nenhum corretor encontrado.' : null;

        return parent::render($response, 'FormCadastro', [
            'flashSuccessMessage' => $flashSuccessMessage,
            'flashErrorMessage' => $flashErrorMessage,
            'corretores' => $corretores,
            'message' => $message
        ]);
    }



    public function create(Request $request, Response $response)
    {
        try {
            $data = $request->getParsedBody();
            var_dump($data);

            if (strlen($data['cpf']) != 11) {
                $_SESSION['flashErrorMessage'] = 'O CPF deve ter exatamente 11 caracteres.';
                return $response->withHeader('Location', '/corretor')->withStatus(302);
            }

            if (strlen($data['creci']) <= 2) {
                $_SESSION['flashErrorMessage'] = 'O CRECI deve ter mais de 2 caracteres.';
                return $response->withHeader('Location', '/corretor')->withStatus(302);
            }

            if (strlen($data['nome']) < 3) {
                $_SESSION['flashErrorMessage'] = 'O nome deve ter pelo menos 3 caracteres.';
                return $response->withHeader('Location', '/corretor')->withStatus(302);
            }


            $corretor = new CorretorModel(null, $data['nome'], $data['cpf'], $data['creci']);
            $corretorDAO = new CorretorDAO();
            $result = $corretorDAO->create($corretor);

            if ($result === true) {
                $_SESSION['flashSuccessMessage'] = 'Corretor cadastrado com sucesso!';
            } else {
                $_SESSION['flashErrorMessage'] = $result;
            }

            return $response->withHeader('Location', '/corretor')->withStatus(302);
        } catch (\Exception $e) {
            $_SESSION['flashErrorMessage'] = 'Erro ao cadastrar corretor: ' . $e->getMessage();
            return $response->withHeader('Location', '/corretor')->withStatus(302);
        }
    }

    public function editar(Request $request, Response $response, $args)
    {
        $corretorDAO = new CorretorDAO();
        $id = $args['id'];
        $corretor = $corretorDAO->findById($id);

        return parent::render($response, 'FormEdite', [
            'corretor' => $corretor
        ]);
    }

    public function salvarEdicao(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        $id = $args['id'];

        if (strlen($data['cpf']) != 11) {
            $_SESSION['flashErrorMessage'] = 'O CPF deve ter exatamente 11 caracteres.';
            return $response->withHeader('Location', '/corretor/editar/' . $id)->withStatus(302);
        }

        if (strlen($data['creci']) <= 2) {
            $_SESSION['flashErrorMessage'] = 'O CRECI deve ter mais de 2 caracteres.';
            return $response->withHeader('Location', '/corretor/editar/' . $id)->withStatus(302);
        }

        if (strlen($data['nome']) < 3) {
            $_SESSION['flashErrorMessage'] = 'O nome deve ter pelo menos 3 caracteres.';
            return $response->withHeader('Location', '/corretor/editar/' . $id)->withStatus(302);
        }

        $corretorDAO = new CorretorDAO();
        $corretor = new CorretorModel($id, $data['nome'], $data['cpf'], $data['creci']);
        $result = $corretorDAO->update($corretor);

        if ($result) {
            $_SESSION['flashSuccessMessage'] = 'Corretor atualizado com sucesso!';
        } else {
            $_SESSION['flashErrorMessage'] = 'Erro ao atualizar corretor';
        }

        return $response->withHeader('Location', '/corretor')->withStatus(302);
    }

    public function excluir(Request $request, Response $response, $args)
    {
        try {
            $corretorDAO = new CorretorDAO();
            $id = $args['id'];
            $corretorDAO->delete($id);

            $_SESSION['flashSuccessMessage'] = 'Corretor excluído com sucesso!';
            return $response->withHeader('Location', '/corretor')->withStatus(302);
        } catch (\Exception $e) {
            $_SESSION['flashErrorMessage'] = 'Erro ao excluir corretor: ' . $e->getMessage();
            return $response->withHeader('Location', '/corretor')->withStatus(302);
        }
    }

}


