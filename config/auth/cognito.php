<?php

declare(strict_types=1);

use Px\Framework\Auth\Config\Config;

// Configuration for cognito
$config = Config::cognito();

// as every module can have various custom fields, the configuration is overriden here.

return $config;
