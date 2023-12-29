<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasConstantAsFieldTrait
{
    public function __call($method, $parameters)
    {
        $constant = Str::upper(Str::snake($method));
        $ref = new \ReflectionClass($this);

        if ($ref->hasConstant($constant) && !$ref->hasMethod($method)) {
            return $this->{$ref->getConstant($constant)};
        }

        return parent::__call($method, $parameters);
    }
}
