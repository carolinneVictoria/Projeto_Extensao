<?php include("../../app/header.php");

include ('../../config/conexaoBD.php');
include ('../../model/Cliente.php');

$clienteModel = new Cliente($conn);

if (isset($_GET['id'])) {
    $idCliente = $_GET['id'];
    
    $cliente = $clienteModel->buscarClientePorId($idCliente);
} else {
    echo "ID do Cliente não informado!";
    exit(); 
}
?>

<div class="container-fluid">
    <h4>Detalhes do Cliente:</h4>
 
    <div class="col-sm-12">

        <form action="../../controller/ClienteController.php?acao=atualizar" method="POST" enctype="multipart/form-data" class="was-validated">

            <input type="hidden" name="idCliente" value="<?= $cliente['idCliente']; ?> ">

            <div class="row">

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control border border-info rounded" id="nome" name="nome" value="<?= htmlspecialchars($cliente['nome']); ?>" required readonly>
                    <label for="nome">Nome:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control border border-info rounded" id="telefone" name="telefone" value="<?= htmlspecialchars($cliente['telefone']); ?>"required readonly>
                    <label for="telefone">Telefone:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control border border-info rounded" id="cpf" name="cpf" value="<?= htmlspecialchars($cliente['cpf']); ?>" required readonly>
                    <label for="cpf">CPF:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="date" class="form-control border border-info rounded" id="dataNascimento" name="dataNascimento" value="<?= htmlspecialchars($cliente['dataNascimento']); ?>" required readonly>
                    <label for="dataNascimento">Data de Nascimento:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control border border-info rounded" id="endereco" name="endereco" value="<?= htmlspecialchars($cliente['endereco']); ?>" readonly>
                    <label for="endereco">Endereço</label>
                </div>
            </div>

             <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control border border-info rounded" id="bicicleta" name="bicicleta" value="<?= htmlspecialchars($cliente['bicicleta']); ?>" readonly>
                    <label for="bicicleta">Bicicleta</label>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="d-flex justify-content-end gap-2">
                    <a href='formAtualizarCliente.php?id=<?= $idCliente ?>' class='btn btn-primary btn-sm'>Atualizar</a>
                    <a href='../../controller/ClienteController.php?acao=excluir&id=<?= $idCliente?>' class='btn btn-danger btn-sm' onclick="return confirm('Tem certeza que deseja excluir? Esse cliente pode ter um serviço, e ele será excluido junto!')">Excluir</a>
                    <a href="clientes.php" class="btn btn-secondary btn me-2">Voltar</a>
                </div>
            </div>

            </div>
        </form>
    </div>
</div>


<?php include("../../app/footer.php"); ?>