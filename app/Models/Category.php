<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'category'
    ];
    use HasFactory;

    # Relación de muchos a muchos entre Category y User
    public function users(){
        return $this->belongsToMany(User::class);
    }
}
