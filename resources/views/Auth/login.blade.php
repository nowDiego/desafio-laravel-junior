<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>
    <main class="container-fluid w-100 d-flex flex-column align-items-center justify-content-center">

    <form action="/login" method="post" class="p-4 border border-top-0">

        @csrf
        <div class="mb-3">
        <label for="usuario" class="form-label">Usuário</label>
        <input type="text" name="usuario" id="usuario" class="form-control">
        </div>

        <div class="mb-3">
        <label for="senha" class="form-label">Senha:</label>
        <input type="password" name="senha" id="senha" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary w-100">Entrar</button>
       
           
        @if(Session::has('message'))
<p class="mt-2 f_red">{{ Session::get('message') }}</p>
@endif   

    </form>

    </main>
    
</body>
</html>