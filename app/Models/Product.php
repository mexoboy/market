<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $external_id
 * @property string $name
 * @property string|null $image_url
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Collection|Category[] $categories
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_url',
        'external_id',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
