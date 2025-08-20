<?php include ("../app/header.php"); ?>

<div class="container" style="margin-left: -10px; padding-top: 10px;"></div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Serviços</h2>
        <a href="/Projeto_Extensao/controller/ServicoController.php?acao=formCadastro" class="btn btn-success"><i class="fas fa-plus"></i> Novo Serviço</a>
    </div>

    <form action="/Projeto_Extensao/controller/ServicoController.php?acao=buscar" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="busca" class="form-control" placeholder="Pesquisar serviço...">
            <button class="btn btn-primary" type="submit" name="acao" value="buscar">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>

<div style="padding-bottom: 10px;">
  <a href="/Projeto_Extensao/controller/ServicoController.php?acao=listar" class="btn btn-success"></i> Todos</a>
  <a href="/Projeto_Extensao/controller/ServicoController.php?acao=listarEntregues" class="btn btn-success"></i> Serviços Entregues</a>
  <a href="/Projeto_Extensao/controller/ServicoController.php?acao=listarPendentes" class="btn btn-success"></i> Serviços Pendentes</a>
</div>


<div class='table-responsive'>
        <table class='table table-striped align-middle'>
            <thead class='table-dark'>
              <tr>
                <th>ID</th>
                <th>CLIENTE</th>
                <th class='col-descricao'>DESCRIÇÃO</th>
                <th>DATA DE ENTRADA</th>
                <th>ENTREGA</th>
                <th>VALOR</th>
                <th>AÇÕES</th>
              </tr>
            </thead>
            <tbody>
              <?php

                  while ($registro = mysqli_fetch_assoc($servicos)) {
                    $idServico = $registro['idServico'];
                    $entrega = $registro['entrega'] == 0 ? 'Sim' : 'Não';
                    $valor = number_format($registro['valorTotal'], 2, ',', '.');
                    echo "
                      <tr>
                        <td>{$registro['idServico']}</td>
                        <td>{$registro['nome']}</td>
                        <td>{$registro['descricao']}</td>
                        <td>{$registro['dataEntrada']}</td>
                        <td>$entrega</td>
                        <td>R$ $valor</td>
                        <td class='text-center'>
                          <a class='btn btn-warning btn-sm' href='/Projeto_Extensao/controller/ServicoController.php?acao=verServico&id=$idServico'>
                              <i class='fas fa-edit'></i>
                          </a>
                          <a class='btn btn-danger btn-sm' href='../../controller/ServicoController.php?acao=excluir&id=$idServico' onclick=\"return confirm('Tem certeza que deseja excluir?')\">
                            <i class='fas fa-trash'></i>
                          </a>
                        </td>
                      </tr>";
                  }
                  ?>

                  </tbody>
            </table>
        </div>

<!-- Paginação -->
        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item <?= ($paginaAtual <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?acao=listar&pagina=<?= $paginaAtual - 1 ?>">Anterior</a>
                </li>

                <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
                    <li class="page-item <?= ($i == $paginaAtual) ? 'active' : '' ?>">
                        <a class="page-link" href="?acao=listar&pagina=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php } ?>

                <li class="page-item <?= ($paginaAtual >= $totalPaginas) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?acao=listar&pagina=<?= $paginaAtual + 1 ?>">Próximo</a>
                </li>
            </ul>
        </nav>
</div>

<?php include "../app/footer.php"; ?>