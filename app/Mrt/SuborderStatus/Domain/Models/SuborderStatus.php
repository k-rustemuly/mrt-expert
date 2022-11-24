<?php

namespace App\Mrt\SuborderStatus\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class SuborderStatus extends Model
{

    /**
     * @var string Создано
     */
    const CREATED = '1';

    /**
     * @var string В ожидании отклика
     */
    const WAITING = '2';

    /**
     * @var string В обработке у доктора
     */
    const UNDER_TREATMENT = '3';

    /**
     * @var string Отозвано
     */
    const REVOKED = '4';

    /**
     * @var string Отклонен
     */
    const REJECTED = '5';

    /**
     * @var string Завершен
     */
    const COMPLETED = '6';

    /**
     * @var string Отменен
     */
    const CANCELED = '7';

    public $table = 'rb_suborder_status';

    protected $guarded = ['id'];

}
