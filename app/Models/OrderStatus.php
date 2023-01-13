<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',        
      ];


      public function purshaseOrders(){
        return $this->hasMany(PurshaseOrder::class,'order_status_id','id');
      }


}
