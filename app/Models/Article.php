<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'articles';
    protected $fillable = [
        'title',
        'content', 
    ];
    public function images(): HasMany
    {
        return $this->hasMany(Image::class,);
    }
}
