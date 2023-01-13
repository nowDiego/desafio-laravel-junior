<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Product</title>
    <link href="/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>

    @include('Components.menu')

    <main class="container-fluid  d-flex justify-content-center align-items-center">

        <div class="d-flex flex-column justify-content-center align-items-center ">
            <h1> Editar <span class="f_orange">Produto</span> </h1>
            <img src="/images/customer.png" class="img-fluid w-50 h-70" alt="cliente">
        </div>


    <form class="border p-5" method="POST" action="{{ route('product.update',['product' => $product->id]) }}">
        @csrf
        @method('PATCH')
    
        <div class="mb-3">
        <label for="nome_produto">Nome do Produto</label>
        <input type="text" id="nome_produto" name="nome_produto"  value={{$product->nome_produto}} />
        </div>

        <div class="mb-3">
        <label for="cod_barra">Codigo de Barra</label>
        <input type="text" id="cod_barra" name="cod_barra" value={{$product->cod_barra}} />
       </div>

        <div class="mb-3">
        <label for="valor_unitario">Valor Unitário</label>
        <input type="text" id="valor_unitario" name="valor_unitario" value={{$product->valor_unitario}} />
       </div>
       
 
        <button type="submit" class="btn btn-primary">Update</button>
 
     </form>
    
    </main>
</body>
</html>