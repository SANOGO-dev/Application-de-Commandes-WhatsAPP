<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
 
class Order extends Model
{
    protected $fillable = [
        'shop_id', 'reference', 'client_nom', 'client_tel',
        'adresse','note','total', 'statut',
    ];
 
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
 
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
 
    // Référence lisible : CMD-20261031-0001
    public static function genererReference(): string
    {
        $prefixe = 'CMD-' . now()->format('Ymd') . '-';
        $numero = static::where('reference', 'like', $prefixe . '%')->count() + 1;
 
        return $prefixe . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }
}