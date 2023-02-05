<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Book
 *
 * @property int $id
 * @property string $isbn
 * @property string $title
 * @property string|null $slug
 * @property int|null $category_id
 * @property int|null $publisher_id
 * @property string $selling_price
 * @property string|null $buying_price
 * @property int $stock
 * @property string|null $description
 * @property string $image
 * @property int|null $book_page
 * @property string|null $weight
 * @property string $type_cover
 * @property int $is_visible
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @property-read \App\Models\Publisher|null $publisher
 * @method static \Illuminate\Database\Eloquent\Builder|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereBookPage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereBuyingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereIsVisible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereIsbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book wherePublisherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereSellingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereTypeCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereWeight($value)
 * @mixin \Eloquent
 */
class Book extends Model
{
    protected $fillable = [
        'isbn',
        'title',
        'slug',
        'category_id',
        'publisher_id',
        'selling_price',
        'buying_price',
        'stock',
        'description',
        'image',
        'book_page',
        'weight',
        'type_cover',
        'is_visible'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }
}
