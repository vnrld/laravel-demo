<?php
declare(strict_types=1);

namespace App\Http\Messaging;


final class MessageCodes extends \Px\Framework\Http\Responder\Messaging\MessageCodes
{
    /**
     * User section
     */

    public const USER_CREATED = 10201;

    public const USER_CANNOT_BE_CREATED = 10202;

    public const USER_NOT_FOUND = 10404;

    public const USER_ALREADY_EXISTS = 10409;

    public const USER_DELETED = 10410;
}
