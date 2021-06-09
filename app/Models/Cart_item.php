<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart_item extends Model
{
    use HasFactory;

    protected $table = 'cart_items';

    public $timestamps = false;
    public function product(){
        $this->hasOne("App\Models\Product");
    }

    public function cart(){
        $this->belongsTo("App\Models\Cart");
    }
}




