<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product</title>
    <link href="/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    @include('Components.menu')

    <main class="container-fluid d-flex justify-content-center align-items-center">
        <div class="d-flex flex-column justify-content-center align-items-center ">
            <h1><span class="f_orange">Produto</span> </h1>
            <img src="/images/customer.png" class="img-fluid w-50 h-70" alt="cliente">
        </div>

<section class="border p-5">
    <p>{{$product->nome_produto}}</p>
    <p>{{$product->cod_barra}}</p>
    <p>{{$product->valor_unitario}}</p>
</section>

</main>
    
</body>
</html>