<?php

namespace App\Http\Controllers;

use Throwable;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use App\Models\PurshaseOrder;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\PurshaseOrderStoreRequest;

class PurshaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      
      try{
        $status = OrderStatus::get();      
        $purshaseOrder = null ;

        if(isset($request->status) || isset($request->search) ){
                   
         if($request->status != 0 && empty($request->search) ){
            $purshaseOrder = PurshaseOrder::with(['customer','orderStatus','orderItem'])
            ->orWhere("order_status_id","=",$request->status)
            ->paginate(20);
         }

         elseif($request->search != "" && ($request->status == 0 || $request->status == "") ){
            $purshaseOrder = PurshaseOrder::with(['customer','orderStatus','orderItem'])
            ->where("id","=",$request->search)
            ->orWhereRelation("customer","nome","=",$request->search)            
            ->paginate(20);
         }
         else{
         
            $purshaseOrder = PurshaseOrder::with(['customer','orderStatus','orderItem'])
            ->where("id","=",$request->search)
            ->orWhere("order_status_id","=",$request->status)
            ->paginate(20);
         }


        }else{

        $purshaseOrder = PurshaseOrder::with(['customer','orderStatus','orderItem'])       
        ->paginate(20);
        }
      
   
        return view('PurshaseOrder.index',['purshaseOrder'=>$purshaseOrder,'status'=>$status]);

   
    } catch (Throwable $e) {
        report($e);
        
        return Redirect::back()->with('error', 'Ocorreu um erro ao cadastrar');
    }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
        
        $products = Product::get();
        $status = OrderStatus::get();
        $customers = Customer::get();

        return view ('PurshaseOrder.create',['products'=>$products,'status'=>$status,'customers'=>$customers]);

    } catch (Throwable $e) {
        report($e);
        
        return Redirect::back()->with('error', 'Ocorreu um erro ao cadastrar');
    }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurshaseOrderStoreRequest $request)
    {

        try{
      
        $purshaseOrder = new PurshaseOrder();
      
        $purshaseOrder->dt_pedido = Carbon::now();
        $purshaseOrder->valor_total = $request->valor_total;
        $purshaseOrder->customer_id = $request->customer;
        $purshaseOrder->order_status_id = $request->status;
        $purshaseOrder->save();
     
        if(!$purshaseOrder){
            return response()->json(['status'=>false,'message'=>'Ocorreu um erro ao cadastrar']);
          }        

       $purshaseOrder->orderItem()->createMany(
            $request->orderItems 
        );


    if(!$purshaseOrder){
        return response()->json(['status'=>false,'message'=>'Ocorreu um erro ao cadastrar']);
        }        


        return response()->json(['status'=>true,'message'=>'Pedido cadastrado com sucesso']);

    } catch (Throwable $e) {
        report($e);
        
        return Redirect::back()->with('error', 'Ocorreu um erro ao cadastrar');
    }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurshaseOrder  $purshaseOrder
     * @return \Illuminate\Http\Response
     */
    public function show(PurshaseOrder $PurshaseOrder)
    {
        try{

        if(!$PurshaseOrder){
            return Redirect::to('/PurshaseOrder');
           }

        return view('PurshaseOrder.show',['purshaseOrder'=>$PurshaseOrder->load(['customer','orderStatus','orderItem'])]);

    } catch (Throwable $e) {
        report($e);
    
        return Redirect::back()->with('error', 'Ocorreu um erro');
    }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurshaseOrder  $purshaseOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(PurshaseOrder $PurshaseOrder)
    {
        try{

        if(!$PurshaseOrder){
            return Redirect::to('/PurshaseOrder');
           }

           $status = OrderStatus::get();
           $products = Product::get();

        return view('PurshaseOrder.edit',['status'=>$status,'products'=>$products,'purshaseOrder'=>$PurshaseOrder->load(['customer','orderStatus','orderItem'])]);

 
    } catch (Throwable $e) {
        report($e);
    
        return Redirect::back()->with('error', 'Ocorreu um erro');
    }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurshaseOrder  $purshaseOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurshaseOrder $PurshaseOrder)
    {
        try{

        if(!$PurshaseOrder){
            return  response()->json(['status'=>false,'message'=>'Ocorreu um erro ao atualizar']);
           }

        $purshaseOrder = $PurshaseOrder->update([
            'valor_total'=>$request->valor_total,
            'order_status_id'=>$request->status,            
       ]);
     
       if(!$purshaseOrder){
        return  response()->json(['status'=>false,'message'=>'Ocorreu um erro ao atualizar']);
       }   
           
       if(!empty($request->orderItems)){

   $orderItem = $PurshaseOrder->orderItem()->createMany(
        $request->orderItems 
        );

     if(!$orderItem){
      return  response()->json(['status'=>false,'message'=>'Ocorreu um erro ao atualizar']);
     }   

       }
         
       return  response()->json(['status'=>true,'message'=>'Pedido atualizado com sucesso']);
        
    } catch (Throwable $e) {
        report($e);
    
        return Redirect::back()->with('error', 'Ocorreu um erro');
    }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurshaseOrder  $purshaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurshaseOrder $PurshaseOrder)
    {
        try{

    if(!$PurshaseOrder){
            return  response()->json(['status'=>false,'message'=>'Ocorreu um erro ao deletar']);
           }   
       
    $result = $PurshaseOrder->delete();

    if(!$result){
        return  response()->json(['status'=>false,'message'=>'Ocorreu um erro ao deletar']);
    }
               
    return  response()->json(['status'=>true,'message'=>'Pedido deletado com sucesso']);
              
} catch (Throwable $e) {
    report($e);

    return  response()->json(['status'=>false,'message'=>'Ocorreu um erro ao deletar']);
}

    }
}
