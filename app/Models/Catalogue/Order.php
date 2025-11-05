<?php

namespace App\Models\Catalogue;

use App\Models\Personnel\Customer;
use App\Models\Catalogue\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;


    protected $appends = ['items', 'customer'];

    public function getCustomerAttribute()
    {
        $customerID = $this->customer_id;
        $getCustomer = Customer::where('customer_id', $customerID)->first();
        return $this->attributes['customer'] = $getCustomer;
    }
  
    public function getItemsAttribute()
    {
        $getID = $this->id;
        $getProducts = OrderItem::where('order_id', $getID)->get();
        return $this->attributes['items'] = $getProducts;
    }
}
