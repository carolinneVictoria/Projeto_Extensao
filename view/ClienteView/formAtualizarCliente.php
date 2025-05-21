<?php include(__DIR__."/../../app/header.php"); 

include ('./../config/conexaoBD.php');
include ('../../model/Cliente.php');

$clienteModel = new Cliente($conn);
if (isset($_GET['id'])) {
    $idCliente = $_GET['id'];
    
    $cliente = $clienteModel->buscarClientePorId($idCliente);
} else {
    echo "ID do cliente não informado!";
    exit(); 
}
?>

<div class="container-fluid">
    <h4>Atualizar Cliente:</h4>
 
    <div class="col-sm-12">

        <form action="../../controller/ClienteController.php?acao=atualizar" method="POST" enctype="multipart/form-data" class="was-validated">

            <input type="hidden" name="idCliente" value="<?= $cliente['idCliente']; ?> ">

            <div class="row">

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($cliente['nome']); ?>" required>
                    <label for="nome">Nome:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?= htmlspecialchars($cliente['telefone']); ?>"required>
                    <label for="telefone">Telefone:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="cpf" name="cpf" value="<?= htmlspecialchars($cliente['cpf']); ?>" required>
                    <label for="cpf">CPF:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="date" class="form-control" id="dataNascimento" name="dataNascimento" value="<?= htmlspecialchars($cliente['dataNascimento']); ?>" required>
                    <label for="dataNascimento">Data de Nascimento:</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="endereco" name="endereco" value="<?= htmlspecialchars($cliente['endereco']); ?>" >
                    <label for="endereco">Endereço</label>
                </div>
            </div>

             <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="bicicleta" name="bicicleta" value="<?= htmlspecialchars($cliente['bicicleta']); ?>">
                    <label for="bicicleta">Bicicleta</label>
                </div>
            </div>

            <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>

            </div>
        </form>
    </div>
</div>

<?php include("../../app/footer.php"); ?>