<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProductStoreRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        try{
      

        $products = Product::where("nome_produto","LIKE","%{$request->search}%")
        ->orWhere("cod_barra","=",$request->search)
        ->paginate(20);

        return view('Product.index',['products'=>$products]);


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
        return view ('Product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        try{

        $product = new Product();

        $product->nome_produto = $request->nome_produto;
        $product->cod_barra =  $request->cod_barra;
        $product->valor_unitario =  $request->valor_unitario;
        $product->save();

        if(!$product){
            return Redirect::back()->with('error', 'Ocorreu um erro ao cadastrar');
          }        

          return Redirect::to('/product');

        } catch (Throwable $e) {
            report($e);
            
            return Redirect::back()->with('error', 'Ocorreu um erro ao cadastrar');
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        try{

        if(!$product){
            return Redirect::to('/product');
           }
    
           return view('Product.show',['product'=>$product]);

        } catch (Throwable $e) {
            report($e);
            
            return Redirect::back()->with('error', 'Ocorreu um erro ao cadastrar');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        try{

        if(!$product){
            return Redirect::to('/product');
           }
    
           return view('Product.edit',['product'=>$product]);

        } catch (Throwable $e) {
            report($e);
            
            return Redirect::back()->with('error', 'Ocorreu um erro ao cadastrar');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        try{
       
        if(!$product){
            return Redirect::to('/product');
           }

       $product->update([
            'nome_produto'=>$request->nome_produto,
            'cod_barra'=>$request->cod_barra,
            'valor_unitario'=>$request->valor_unitario
       ]);

     
        
     return view('Product.show',['product'=>$product]);

    } catch (Throwable $e) {
        report($e);
        
        return Redirect::back()->with('error', 'Ocorreu um erro ao cadastrar');
    }

        
    

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try{
        
        if(!$product){
            return  response()->json(['status'=>false,'message'=>'Ocorreu um erro ao deletar']);
        }
    
            $result = $product->delete();
    
            if(!$result){
                return  response()->json(['status'=>false,'message'=>'Ocorreu um erro ao deletar']);
            }
    
            return  response()->json(['status'=>true,'message'=>'Produto deletado com sucesso']);
        
        } catch (Throwable $e) {
            report($e);
        
            return  response()->json(['status'=>false,'message'=>'Ocorreu um erro ao deletar']);
        }
        
        
        }
}
