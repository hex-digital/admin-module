<?php

declare(strict_types=1);

namespace HexDigital\ApiConsoleModule\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 */
final class Admin extends Authenticatable
{
    use SoftDeletes;

    protected $guarded = [];

    public function name(): Attribute
    {
        return Attribute::get(get: fn () => "{$this->first_name} {$this->last_name}");
    }
}
