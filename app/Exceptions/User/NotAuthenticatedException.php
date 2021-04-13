<?php
declare(strict_types=1);

namespace App\Exceptions\User;

use Exception;

class NotAuthenticatedException extends Exception
{
    public const API = 1;

    public const WEB = 2;

}
