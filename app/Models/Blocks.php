<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blocks extends Model
{
    use HasFactory;

      /**
     * @var string
     */
    protected $table = 'Blocks';

    /**
     * @var array<string, string>
     */
   

    

    protected $fillable = [
        'name',
        'page_id',
        'content',
        'order',
    ];
    
    protected $casts =[
        'content' => 'json'
      ];

    public function pages(): BelongsTo
    {
        return $this->belongsTo(Pages::class, 'page_id');
    }
    
}
