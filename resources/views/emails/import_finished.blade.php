<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Importação de Colaboradores</title>
</head>
<body>
<h2>Processamento realizado com sucesso 🎉</h2>
<p>O arquivo CSV foi processado.</p>

<p><strong>Total de linhas:</strong> {{ $summary['total'] }}</p>
<p><strong>Sucessos:</strong> {{ $summary['success'] }}</p>
<p><strong>Falhas:</strong> {{ $summary['failed'] }}</p>

@if(count($summary['errors']) > 0)
    <h3>Ocorreram erros:</h3>
    <ul>
        @foreach($summary['errors'] as $error)
            <li>Linha {{ $error['line'] }}: {{ implode(', ', $error['messages']) }}</li>
        @endforeach
    </ul>
@endif

<p>Obrigado,<br>Equipe {{ config('app.name') }}</p>
</body>
</html>
