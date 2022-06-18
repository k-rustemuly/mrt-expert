<?php

namespace App\Edus\AccessStatus\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class AccessStatus extends Model
{

    /**
     * @var int const заполняется
     */
    public const FILLED_IN = 1;

    /**
     * @var int const На проверке
     */
    public const UNDER_REVIEW = 2;

    /**
     * @var int const Допущен
     */
    public const ADMITTED = 3;

    /**
     * @var int const Не допущен
     */
    public const NOT_ADMITTED = 4;

    /**
     * @var int const Данные устарели
     */
    public const OUT_OF_DATE = 5;

    /**
     * @var int const Запрещено
     */
    public const FORBIDDEN = 6;

    /**
     * @var int const Не имеет право
     */
    public const HAS_NO_RIGHT = 7;

    public $table = 'rb_access_status';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

}