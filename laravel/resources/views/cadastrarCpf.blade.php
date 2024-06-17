<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport">
    <title>Cadastro Cpf</title>
</head>
<body>
    <h2>Cadastro de CPF</h2>
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif 
    <p>Informe o CPF:</p>
    <form action="{{ route('efetuar-cadastro') }}" method="post">
        @csrf
        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" id="cpf">
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>    