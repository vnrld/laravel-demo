<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
    protected $table = 'user_history';

    public $incrementing = false;

    public $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'entry'
    ];
}
