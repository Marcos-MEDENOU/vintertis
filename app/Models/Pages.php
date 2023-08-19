<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pages extends Model
{
    use HasFactory;


     /**
     * @var string
     */
    protected $table = 'Pages';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        // 'published_at' => 'date',
    ];

    protected $fillable = [
        'title',
        'url',
    ];
    
    public function blocks(): HasMany
    {
        return $this->hasMany(Blocks::class, 'page_id');
    }
    
}
