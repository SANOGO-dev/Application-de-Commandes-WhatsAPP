<?php


namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
 
class Shop extends Model
{
    protected $fillable = [
        'user_id', 'nom', 'slug', 'whatsapp',
        'description', 'couleur', 'statut_abonnement', 'expire_le',
    ];
 
    protected $casts = [
        'expire_le' => 'date',
    ];
 
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
 
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
 
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
 
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
 
    // La boutique est visible si l'abonnement est en essai ou actif et non expiré
    public function isActive(): bool
    {
        return in_array($this->statut_abonnement, ['essai', 'actif'])
            && ($this->expire_le === null || $this->expire_le->isFuture());
    }
 
    // Les URLs /{slug} utilisent le slug au lieu de l'id
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}