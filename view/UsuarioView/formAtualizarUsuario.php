<?php include("../app/header.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Atualizar Usuário</h4>
                </div>
                <div class="card-body">
                    <form action="/Projeto_Extensao/controller/UsuarioController.php?acao=atualizar" method="POST" enctype="multipart/form-data" class="was-validated">
                        <input type="hidden" name="idUsuario" value="<?= htmlspecialchars($usuario['idUsuario']); ?>">
                        
                        <div class="row g-3">
                            <div class="col-12 text-center mb-3">
                                <?php if (!empty($usuario['fotoUsuario'])): ?>
                                    <img src="/Projeto_Extensao/<?= htmlspecialchars($usuario['fotoUsuario']); ?>" alt="Foto do Usuário" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                    <p class="mt-2 text-muted">Foto atual</p>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nomeUsuario" placeholder="Informe o seu nome" name="nomeUsuario" value="<?= htmlspecialchars($usuario['nomeUsuario']); ?>" required>
                                    <label for="nomeUsuario">Nome:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="telefoneUsuario" placeholder="Informe o seu telefone" name="telefoneUsuario" value="<?= htmlspecialchars($usuario['telefoneUsuario']); ?>" required>
                                    <label for="telefoneUsuario">Telefone:</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="emailUsuario" placeholder="Informe o seu email" name="emailUsuario" value="<?= htmlspecialchars($usuario['emailUsuario']); ?>" required>
                                    <label for="emailUsuario">Email:</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="hidden" name="fotoAntiga" value="<?= htmlspecialchars($usuario['fotoUsuario']); ?>">
                                    <input type="file" class="form-control" id="fotoUsuario" name="fotoUsuario">
                                    <label for="fotoUsuario">Nova Foto:</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating position-relative">
                                    <input type="password" class="form-control" id="senhaUsuario" name="senhaUsuario" placeholder="Informe uma senha">
                                    <label for="senhaUsuario">Senha:</label>
                                    <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2" 
                                            onclick="togglePassword('senhaUsuario', this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating position-relative">
                                    <input type="password" class="form-control" id="confirmarSenhaUsuario" name="confirmarSenhaUsuario" placeholder="Confirme a senha">
                                    <label for="confirmarSenhaUsuario">Confirme a Senha:</label>
                                    <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2" 
                                            onclick="togglePassword('confirmarSenhaUsuario', this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="javascript:history.back()" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                            <button type="submit" class="btn btn-warning text-white">
                                <i class="fas fa-save"></i> Atualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const icon = btn.querySelector("i");

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>

<?php include("../app/footer.php"); ?>