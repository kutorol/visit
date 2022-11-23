<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\UserPurchase.
 *
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $name
 * @property string $type
 * @property int $days
 * @property \Illuminate\Support\Carbon|null $product_created_at
 * @property \Illuminate\Support\Carbon|null $product_updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchase newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserPurchase onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchase query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchase whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchase whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchase whereProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchase whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|UserPurchase withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserPurchase withoutTrashed()
 * @mixin \Eloquent
 * @property int $product_id
 * @method static \Illuminate\Database\Eloquent\Builder|UserPurchase whereProductId($value)
 */
class UserPurchase extends Model
{
    use HasFactory, SoftDeletes;

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'product_id',
    ];
}
