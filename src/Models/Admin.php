<?php

declare(strict_types=1);

namespace HexDigital\ApiConsoleModule\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 */
final class Admin extends Authenticatable
{
    use HasRoles;
    use Notifiable;
    use SoftDeletes;

    protected $guarded = [];

    public function name(): Attribute
    {
        return Attribute::get(get: fn () => "{$this->first_name} {$this->last_name}");
    }
}
