<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;

abstract class Controller
{
    protected static function render(Response $response, $view, $dados = [])
    {
        $arquivo_view = VIEWS . $view . '.php';

        if (file_exists($arquivo_view)) {
            extract($dados);

            ob_start();
            include $arquivo_view;
            $conteudo = ob_get_clean();

            $response->getBody()->write($conteudo);

            return $response;
        } else {
            $response = $response->withStatus(404);
            $response->getBody()->write('View não encontrada');

            return $response;
        }
    }
}
