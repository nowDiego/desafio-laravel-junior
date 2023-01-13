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

  <main class="container-fluid w-100 d-flex flex-column align-items-center">

    <section class="w-100 d-flex justify-content-center "> 
      <a href="/product/create" class="btn btn-outline-primary">Novo Produto</a>
    </section>

  <form action="{{route('product.index')}}" method="GET" class="mt-2 d-flex w-100 justify-content-center align-items-center">
    <div class="input-group w-50">
    <input type="text" name="search" id="search" placeholder="Pesquisar por nome ou codigo de barra" class="form-control">
   <button class="btn btn-outline-primary">Pesquisar</button>
    </div>
  </form>
  
  <section class="w-50 m-10 mt-5">


    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nome Produto</th>
          <th scope="col">Cod.Barra</th>
          <th scope="col">Valor Unitário</th>
          <th scope="col"></th>
          <th scope="col"></th>
          <th scope="col"></th>

        </tr>
      </thead>
      <tbody>



    @foreach ($products as $item)

 <tr>
  <th scope="row">{{$item->id}}</th>
  <th >{{$item->nome_produto}}</th>
  <td>{{$item->cod_barra}}</td>
  <td>{{$item->valor_unitario}}</td>
  <td> <a class="btn btn-outline-info" href="/product/{{$item->id}}">Detalhe </a> </td>
  <td> <a class="btn btn-outline-warning" href="/product/{{$item->id}}/edit">Editar </a></td>
  <td> <button class="btn btn-outline-danger" id="delete" onclick="handleDelete({{$item->id}})">Excluir</button></td>

</tr>
 


 @endforeach
    
</tbody>
</table>
</section>

 {{ $products->links("pagination::bootstrap-4") }}

</main>


</body>
<script>
    async function handleDelete(value){
    
        await  fetch(`/product/${value}`,
      {
          headers: {
          'Accept': 'application/json, text/plain, */*',
          'Content-Type': 'application/json'
        },
          method: "DELETE",
          body: JSON.stringify(
              {_token: "{{ csrf_token() }}"
             }
              )
      })
      .then(function(res){ return res.json(); })
      .then(function(data){     
             
        if(data.status===true){
          document.location.reload(true)    
            }  
          
          })
          
    
    }
        

    
    </script>
</html>