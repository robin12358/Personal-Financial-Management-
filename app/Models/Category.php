<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table ='categories';
    protected $guarded = [];
    protected $primaryKey="category_id";
 
    public function spends(){
        return $this->hasManyThrough(
            Spend::class,
            Sub_category::class,
            'category',
            'sub_category',
            'category_id',
            'sub_category_id'
        );
    }
}
