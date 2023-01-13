<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Pedido de Compra</title>
    <link href="/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>

  @include('Components.menu')

  <main class="container-fluid w-100 d-flex  align-items-center">

    <div class="d-flex flex-column justify-content-center align-items-center w-30">
      <h1> Editar <span class="f_orange">Pedido</span> </h1>
      <img src="/images/customer.png" class="img-fluid w-50 h-70" alt="cliente">
  </div>

    <form  class="w-30" action="/PurshaseOrder" method="post" >
        @csrf
        @method('PATCH')
      
        <div class="mb-3">
          <label for="customer">Cliente: {{$purshaseOrder->customer->nome}}</label>     
        </div>
     
        
        <div class="mb-3">
          <label for="status">Status</label> 
        <select name="status" id="status">
            @foreach ($status as $item)
            <option value={{$item->id}}>{{$item->status}}</option>
            @endforeach           
        </select>
        </div>

        <div class="mb-3">
          <label for="product">Produto</label>        

        <select name="product" id="product">
            <option value="">Select One …</option>
            @foreach ($products as $item)
            <option value={{$item->id}} data-valor={{$item->valor_unitario}}>{{$item->nome_produto}}</option>
            @endforeach           
        </select>
        </div>

        <div class="mb-3">
        <label for="quantidade">Quantidade</label>        
        <input type="text" id="quantidade" name="quantidade" value="{{$purshaseOrder->quantidade}}" /> 
      </div>

        <div class="mb-3">
        <label for="Valor Unitário">Valor Unitário</label>      
        <input type="text" disabled id="valor_unitario" name="valor_unitario"/> 
      </div>

        <div class="mb-3">
        <label for="valor_total_item">Valor Total Item:</label>        
        <input type="text" disabled id="valor_total_item" name="valor_total_item" value=0 /> 
      </div>
        
      <div class="mb-3">
        <button id="addItem" class="btn btn-success" >Adicionar</button>
      </div>



     </form>

     <div  class="d-flex flex-column w-40 h-50">
     
      <div class="mb-3 ms-5">
        <label for="valor_total_pedido" >Valor Total</label>        
        <input disabled  type="text" id="valor_total_pedido" name="valor_total_pedido" value="{{$purshaseOrder->valor_total}}" /> 
      </div>

      <section id="products_list" class="ms-5 overflow-auto">
        @foreach ($purshaseOrder->orderItem as $item)
          <div class="mb-3 p-2 bg_orange rounded-2">             
            <p>Produto: {{$item->product->nome_produto}}</p>
            <p>Valor Unitário: {{$item->product->valor_unitario}}</p>                
            <p>Quantidade: {{$item->quantidade}}</p>
            <p>Valor Total: {{$item->total}}</p>
             </div> 

          @endforeach 
        </section>

        <button type="submit" id="formPurshaseOrder" class="btn btn-primary mt-3 ms-5">Atualizar Compra</button>


      </main>
</body>

<script>
   
    const valor_unitario = document.getElementById("valor_unitario")
    const valor_total_item = document.getElementById("valor_total_item")    
    const productList = document.getElementById("products_list")
    const selectProduct = document.getElementById('product');
    const selectStatus = document.getElementById('status');
    const selectCustomer = document.getElementById('customer');
    const addItem = document.getElementById('addItem');


    const quantidade = document.getElementById("quantidade")
    const valor_total_pedido = document.getElementById("valor_total_pedido")
        const formPurshaseOrder = document.getElementById('formPurshaseOrder');

    let listOrderItem = [];


  
     

async function handleOnSubmit(value){       
    
    console.log(value)
  await  fetch(`/PurshaseOrder/{{$purshaseOrder->id}}`,
  {
      headers: {
      'Accept': 'application/json, text/plain, */*',
      'Content-Type': 'application/json'
    },
      method: "PATCH",
      body: JSON.stringify(
          {_token: "{{ csrf_token() }}",valor_total:value.valor_total, status:value.status,
           orderItems:value.items
         }
          )
  })
  .then(function(res){ return res.json(); })
  .then(function(data){     
         
    if(data.status===true){
      window.location.href = "/PurshaseOrder";

        }  
      
      })
      
  }


document.getElementById("addItem").addEventListener("click", function(event){

  event.preventDefault();

  if(quantidade.value !== "" && quantidade.value>0 && 
 valor_total_item.value !== "" && valor_total_item.value >0  &&
 valor_total_item.value>0 && selectProduct.options[selectProduct.selectedIndex].value !== "" )
 {
  listOrderItem.push({
    quantidade:quantidade.value,
    total:valor_total_item.value,
    product_id:selectProduct.options[selectProduct.selectedIndex].value
})

 
  let content = `<div class="mb-3 p-2 bg_orange rounded-2"> 
                <p>Produto: ${selectProduct.options[selectProduct.selectedIndex].text}</p>
                <p>Valor Unitário: ${valor_unitario.value}</p>                
                <p>Quantidade: ${quantidade.value}</p>
                <p>Valor Total: ${valor_total_item.value}</p>
                 </div> `;

   productList.innerHTML += content;

  valor_total_pedido.value = parseFloat(valor_total_pedido.value) + parseFloat(valor_total_item.value);
  cleanInput();


            }

});


function cleanInput(){
  quantidade.value = "";
  valor_unitario.value="";
  valor_total_item.value="";
}



selectProduct.addEventListener('change', (event) => {

var valor = selectProduct.options[selectProduct.selectedIndex].dataset.valor;

valor!==undefined?valor_unitario.value = valor: cleanInput()

});


quantidade.addEventListener('focusout', function(){
  if(quantidade.value>0){
  let total = parseInt(valor_unitario.value) * parseInt(quantidade.value)
    valor_total_item.value = total
  }
});



formPurshaseOrder.addEventListener('click', function(event){
 event.preventDefault();

 let value = new Object();
//  value.customer = selectCustomer.options[selectCustomer.selectedIndex].value
 value.valor_total = valor_total_pedido.value
 value.status = selectStatus.options[selectStatus.selectedIndex].value
 value.items = listOrderItem 


handleOnSubmit(value)


});



    </script>
</html>