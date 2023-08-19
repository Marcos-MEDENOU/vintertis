<?php

namespace App\Models\Blog;

use Althinect\FilamentSpatieRolesPermissions\Concerns\HasSuperAdmin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Tags\HasTags;
// use Spatie\Permission\Traits\HasRoles;

class Post extends Model
{
    use HasFactory;
    //use App\Models\Blog\App\Models\Blog\HasTags;
    // use HasRoles;
    /**
     * @var string
     */
    protected $table = 'blog_posts';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'date',
    ];

    protected $fillable = [
        'title',
        'slug',
        'content',
        'published_at',
        'image',
        'meta_description',
        'meta_keywords',
        'seo_title'
        
    ];
    
    // public function author(): BelongsTo
    // {
    //     return $this->belongsTo(Author::class, 'blog_author_id');
    // }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'blog_category_id');
    }

  
}
