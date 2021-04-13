<?php
declare(strict_types=1);

namespace App\Services;

use Psr\Log\LoggerInterface;
use Px\Framework\AWS\Cognito\Cognito;

class CognitoService
{
    private Cognito $cognito;

    public function __construct(array $config, LoggerInterface $logger) {
        $this->cognito = new Cognito($config, $logger);
    }

    public function __call(string $method, array $arguments = []) {
        if (!method_exists($this, $method)) {
            return $this->cognito->{$method}(...$arguments);
        }
    }

    public function getConnector(): Cognito
    {
        return $this->cognito;
    }
}
