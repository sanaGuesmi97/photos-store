<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'images';
    protected $fillable = [
        'image',
        'title',
        'description',
        'price',
        'user_id',
        'category_id',
        'article_id'
    ];
   



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsTo(Categories::class,"category_id");
    }
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
