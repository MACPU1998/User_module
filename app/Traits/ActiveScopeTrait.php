<?php

namespace App\Traits;

use App\Models\Scopes\IsActiveScope;

trait ActiveScopeTrait
{
    public static function bootActiveScopeTrait(): void
    {
        static::addGlobalScope(new IsActiveScope());
    }
}
