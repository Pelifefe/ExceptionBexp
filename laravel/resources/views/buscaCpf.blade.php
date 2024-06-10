<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport">
    <title>Busca CPF</title>
</head>
<body>
    <form action="{{ route('cpf') }}" method="post">
        @csrf
        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" id="cpf">
        <button type="submit">Buscar</button>
    </form>
</body>
</html>    