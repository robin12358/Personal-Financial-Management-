<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_category extends Model
{
    use HasFactory;
    protected $table = 'sub_categories';
    protected $guarded = [];
    protected $fillable = ['name'];
    protected $primaryKey="sub_category_id";
    public function categorys(){
        return $this->hasone(Category::class,'category_id','category');
    }
    public function spends(){
        return $this->hasMany(Spend::class,'sub_category');
    }
}
