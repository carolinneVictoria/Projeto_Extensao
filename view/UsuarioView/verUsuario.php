<?php include("../app/header.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white text-center">
                    <h4 class="mb-0">Detalhes do Usuário</h4>
                </div>
                <div class="card-body">
                    <form>
                        <input type="hidden" name="idUsuario" value="<?= htmlspecialchars($usuario['idUsuario']); ?>">
                        
                        <div class="row g-3">
                            <div class="col-12 text-center mb-3">
                                <img src="/Projeto_Extensao/<?= htmlspecialchars($usuario['fotoUsuario']); ?>" alt="Foto do Usuário" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nomeUsuario" name="nomeUsuario" value="<?= htmlspecialchars($usuario['nomeUsuario']); ?>" disabled placeholder="Nome do Usuário">
                                    <label for="nomeUsuario">Nome:</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="telefoneUsuario" name="telefoneUsuario" value="<?= htmlspecialchars($usuario['telefoneUsuario']); ?>" disabled placeholder="Telefone">
                                    <label for="telefoneUsuario">Telefone:</label>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="emailUsuario" name="emailUsuario" value="<?= htmlspecialchars($usuario['emailUsuario']); ?>" disabled placeholder="Email">
                                    <label for="emailUsuario">Email:</label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <button onclick="history.back()" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </button>
                            <div>
                                <a href='../controller/UsuarioController.php?acao=formAtualizar&id=<?= $usuario['idUsuario']; ?>' class='btn btn-warning me-2 text-white'>
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <a href='../controller/UsuarioController.php?acao=excluir&id=<?= $usuario['idUsuario']; ?>' class='btn btn-danger' onclick='return confirm("Tem certeza que deseja excluir?")'>
                                    <i class="fas fa-trash"></i> Excluir
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../app/footer.php"); ?>