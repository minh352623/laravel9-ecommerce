<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;

use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "products";
    protected $guarded = [];


    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'Product_tags', 'product_id', 'tag_id')->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
