@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
{{--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forbidden</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-image: url('{{ asset('images/images/') }}');
    background-size: contain;
    background-repeat: no-repeat;
    height: 100vh;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
}

        .content {
            text-align: center;
            background-color: rgba(160, 153, 153, 0.8);
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="content">
        <h1>DETENTE</h1>
        <p>Sorry, no puedes entrar aqui curioso/a.</p>
    </div>
</body>
</html>
--}}