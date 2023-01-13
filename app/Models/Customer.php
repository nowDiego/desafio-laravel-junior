<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

   protected $fillable = [
     'cpf',
     'nome',
     'email',
     'genero',     
   ];


  public function purshaseOrders(){
    return $this->hasMany(PurshaseOrder::class,'customer_id','id');
  }

}
