<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spend extends Model
{
    use HasFactory;
    protected $table ='spends';
    protected $guarded = [];
    protected $primaryKey="spend_id";
    
    public function subcategorys(){
        return $this->hasOne(Sub_category::class,'sub_category_id');
    }
    public function categorys(){
        return $this->hasOneThrough(
            Category::class,
            Sub_category::class,
            'sub_category_id',
            'category_id',
            'sub_category',
            'category',
            
        );
    }
   
    
}
