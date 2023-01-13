<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Customer</title>
    <link href="/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>
  @include('Components.menu')

  <main class="container-fluid w-100 d-flex  align-items-center">

    <div class="d-flex flex-column justify-content-center align-items-center w-30">
      <h1> Cadastro de <span class="f_orange">Pedidos</span> </h1>
      <img src="/images/customer.png" class="img-fluid w-50 h-70" alt="cliente">
  </div>


    <form action="/PurshaseOrder" method="post" class="w-30">
        @csrf
    
        <div class="mb-3">
          <label for="customer">Cliente</label>      

        <select name="customer" id="customer">
            @foreach ($customers as $item)
            <option value={{$item->id}}>{{$item->cpf}}</option>
            @endforeach           
        </select>

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
        <input type="text" id="quantidade" name="quantidade"/> 
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
        <button id="addItem" class="btn btn-success">Adicionar</button>
         
      </div>
        

     </form>

     <div  class="d-flex flex-column w-40 h-50">

   
      <div class="mb-3 ms-5">
        <label for="valor_total_pedido" >Valor Total</label>        
        <input disabled  type="text" id="valor_total_pedido" name="valor_total_pedido" value=0 /> 
      </div>
       <section id="products_list" class="ms-5 overflow-auto "> 

       </section>

       <button type="submit" id="formPurshaseOrder" class="btn btn-primary mt-3 ms-5">Finalizar Compra</button>



      </main>
    
</body>

<script>
   
    const valor_unitario = document.getElementById("valor_unitario")
    const valor_total_item = document.getElementById("valor_total_item")    
    const productList = document.getElementById("products_list")
    const selectProduct = document.getElementById('product');
    const selectStatus = document.getElementById('status');
    const selectCustomer = document.getElementById('customer');

    const quantidade = document.getElementById("quantidade")
    const valor_total_pedido = document.getElementById("valor_total_pedido")
    const formPurshaseOrder = document.getElementById('formPurshaseOrder');

    let listOrderItem = [];


    formPurshaseOrder.style.display = "none"
  
     

async function handleOnSubmit(value){       
    
   
  await  fetch(`/PurshaseOrder`,
  {
      headers: {
      'Accept': 'application/json, text/plain, */*',
      'Content-Type': 'application/json'
    },
      method: "POST",
      body: JSON.stringify(
          {_token: "{{ csrf_token() }}",customer:value.customer,valor_total:value.valor_total, status:value.status,
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
  event.preventDefault()

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
                <p>Cliente: ${selectCustomer.options[selectCustomer.selectedIndex].text}</p>
                <p>Produto: ${selectProduct.options[selectProduct.selectedIndex].text}</p>
                <p>Valor Unitário: ${valor_unitario.value}</p>                
                <p>Quantidade: ${quantidade.value}</p>
                <p>Valor Total: ${valor_total_item.value}</p>
                 </div> `;

  productList.innerHTML += content;

  valor_total_pedido.value = parseFloat(valor_total_pedido.value) + parseFloat(valor_total_item.value);
  cleanInput();

  formPurshaseOrder.style.display = "block"

          }

});



selectProduct.addEventListener('change', (event) => {

let valor = selectProduct.options[selectProduct.selectedIndex].dataset.valor;

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
 value.customer = selectCustomer.options[selectCustomer.selectedIndex].value
 value.valor_total = valor_total_pedido.value
 value.status = selectStatus.options[selectStatus.selectedIndex].value
 value.items = listOrderItem 


handleOnSubmit(value)

});

function cleanInput(){
  quantidade.value = "";
  valor_unitario.value="";
  valor_total_item.value="";
}


    </script>
</html>