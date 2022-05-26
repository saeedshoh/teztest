<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

class Role extends \Spatie\Permission\Models\Role implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

/*    public const ROLE_ADMIN = 1;
    public const ROLE_MODERATOR = 2;
    public const ROLE_MERCHANT = 3;
    public const ROLE_DELIVERY = 4;
    public const ROLE_OPERATOR = 5;

    public const ROLES_ARRAY = [
        self::ROLE_ADMIN => 'Админ',
        self::ROLE_MODERATOR => 'Модератор',
        self::ROLE_MERCHANT => 'Мерчант',
        self::ROLE_DELIVERY => 'Доставщик',
        self::ROLE_OPERATOR => 'Оператор'
    ];*/
}
