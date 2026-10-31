<?php
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
 
class Product extends Model
{
    protected $fillable = [
        'shop_id', 'category_id', 'nom', 'description',
        'prix', 'stock', 'image', 'actif',
    ];
 
    protected $casts = [
        'actif' => 'boolean',
    ];
 
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
 
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
 
    // Prix affiché : 2500 -> "2 500 FCFA"
    public function getPrixFormateAttribute(): string
    {
        return number_format($this->prix, 0, ',', ' ') . ' FCFA';
    }
}