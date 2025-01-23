<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Corretor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="text-center mb-4">Cadastro de Corretor</h3>

                <?php if (isset($flashSuccessMessage)): ?>
                    <div class="alert alert-success">
                        <?= $flashSuccessMessage ?>
                        <?php unset($_SESSION['flashSuccessMessage']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($flashErrorMessage)): ?>
                    <div class="alert alert-danger">
                        <?= $flashErrorMessage ?>
                        <?php unset($_SESSION['flashErrorMessage']); ?>
                    </div>
                <?php endif; ?>


                <form id="cadastroForm" method="POST" action="/corretor/create">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="text" name="cpf" id="cpf" class="form-control" placeholder="Digite seu CPF"
                                maxlength="14">
                            <div class="text-danger mt-1" id="cpfError"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" name="creci" id="creci" class="form-control"
                                placeholder="Digite seu Creci" maxlength="8">
                            <div class="text-danger mt-1" id="creciError"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="nome" id="nome" class="form-control" placeholder="Digite seu nome">
                        <div class="text-danger mt-1" id="nomeError"></div>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Enviar</button>
                </form>

                <h4 class="mt-5">Corretores Cadastrados</h4>
                <?php if (!empty($message)): ?>
                    <div class="alert alert-warning"><?= $message ?></div>
                <?php else: ?>
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>CRECI</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($corretores as $corretor): ?>
                                <tr>
                                    <td><?= htmlspecialchars($corretor->getId()) ?></td>
                                    <td><?= htmlspecialchars($corretor->getName()) ?></td>
                                    <td><?= htmlspecialchars($corretor->getCpf()) ?></td>
                                    <td><?= htmlspecialchars($corretor->getCreci()) ?></td>
                                    <td>
                                        <a href="/corretor/editar/<?= $corretor->getId() ?>" class="btn btn-warning">Editar</a>
                                        <form action="/corretor/excluir/<?= $corretor->getId() ?>" method="POST"
                                            style="display:inline;">
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>