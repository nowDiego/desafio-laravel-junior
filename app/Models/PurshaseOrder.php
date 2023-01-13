<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurshaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'dt_pedido',  
        'valor_total',
        'customer_id',
        'order_status_id'              
      ];


      public function customer(){
        return $this->hasOne(Customer::class,'id','customer_id');
      }

      public function orderItem(){
        return $this->hasMany(OrderItem::class,'purshase_order_id','id');
      }

      public function orderStatus(){
        return $this->belongsTo(OrderStatus::class,'order_status_id','id');
      }
    

}
