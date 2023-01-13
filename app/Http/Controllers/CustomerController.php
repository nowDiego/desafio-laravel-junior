<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CustomerStoreRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

      try{

       $customers = Customer::where("nome","LIKE","%{$request->search}%")
       ->paginate(20);

        return view('Customer.index',['customers'=>$customers]);
    
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
        return view('Customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerStoreRequest $request)
    {

      try{
      
      $customer = new Customer();
      $customer->cpf = $request->cpf; 
      $customer->nome = $request->nome; 
      $customer->email = $request->email; 
      $customer->genero = $request->genero; 


      $customer->save();
      
      if(!$customer){
        return Redirect::back()->with('error', 'Ocorreu um erro ao cadastrar');
      }
      
        return Redirect::to('/customer');

    
      } catch (Throwable $e) {
        report($e);
        
        return Redirect::back()->with('error', 'Ocorreu um erro ao cadastrar');
    }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
      try{

       if(!$customer){
        return Redirect::to('/customer');
       }

       return view('Customer.show',['customer'=>$customer]);
 
      } catch (Throwable $e) {
        report($e);
    
        return Redirect::back()->with('error', 'Ocorreu um erro');
    }

      }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
      try{

        if(!$customer){
            return Redirect::to('/customer');
           }
    
           return view('Customer.edit',['customer'=>$customer]);
    
          } catch (Throwable $e) {
            report($e);
        
            return Redirect::back()->with('error', 'Ocorreu um erro');
        }

          }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
      try{

      if(!$customer){
            return Redirect::to('/customer');
           }

       $customer->update([
            'cpf'=>$request->cpf,
            'nome'=>$request->nome,
            'email'=>$request->email
       ]);
     
 
     
     return view('Customer.show',['customer'=>$customer]);


    } catch (Throwable $e) {
      report($e);
  
      return Redirect::back()->with('error', 'Ocorreu um erro');
  }
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
       try{

      if(!$customer){
        return  response()->json(['status'=>false,'message'=>'Ocorreu um erro ao deletar']);
      }

        $result = $customer->delete();

        if(!$result){
          return  response()->json(['status'=>false,'message'=>'Ocorreu um erro ao deletar']);
        }

        return  response()->json(['status'=>true,'message'=>'Cliente deletado com sucesso']);

      } catch (Throwable $e) {
        report($e);
    
        return  response()->json(['status'=>false,'message'=>'Ocorreu um erro ao deletar']);
    }

    }
}
