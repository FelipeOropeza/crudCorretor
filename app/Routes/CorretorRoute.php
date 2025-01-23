<?php

use Slim\App;
use App\Controller\CorretorController;

return function (App $app) {
    $app->get('/', function ($request, $response, $args) {
        return $response
            ->withHeader('Location', '/corretor')
            ->withStatus(302);
    });
    
    $app->get('/corretor', [CorretorController::class, 'index']);
    $app->post('/corretor/create', [CorretorController::class, 'create']);
    $app->get('/corretor/editar/{id}', [CorretorController::class, 'editar']);
    $app->post('/corretor/editar/{id}', [CorretorController::class, 'salvarEdicao']);
    $app->post('/corretor/excluir/{id}', [CorretorController::class, 'excluir']);
};