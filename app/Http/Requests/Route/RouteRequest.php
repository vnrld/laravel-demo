<?php
declare(strict_types=1);

namespace App\Http\Requests\Route;

use App\Http\Requests\BaseFormRequest;

class RouteRequest extends BaseFormRequest
{
    protected array $routeParams = [];

    public function all($keys = null): array
    {
        // Include the next line if you need form data, too.
        $request = parent::all($keys);

        foreach ($this->routeParams as $param) {
            $request[$param] = $this->route($param);
        }

        return $request;
    }

    public function getParam(string $key, $default = null) {
        return $this->all()[$key] ?? $default;
    }

}
