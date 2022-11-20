<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product.
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property int $days
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory;

    public const TYPE_SUBSCRIPTION = 'subscription';
    public const TYPE_LOCKER = 'locker';

    protected $fillable = [
        'name',
        'type',
        'days',
    ];

    public static function getTypes() :array {
        return [self::TYPE_LOCKER, self::TYPE_SUBSCRIPTION];
    }

    public static function checkType(string $type): bool
    {
        return in_array(mb_strtolower($type), self::getTypes() , true);
    }
}
