<?php

namespace App\Models;

use App\Models\Product;
use App\Models\PurshaseOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [        
        'quantidade',
        'total',
        'product_id',
        'purshase_order_id',
      ];

    public function purshaseOrder(){
        return $this->belongsTo(PurshaseOrder::class,'purshase_order_id','id');
    }

    public function product(){
      return $this->hasOne(Product::class,'id','product_id');
    }


}
