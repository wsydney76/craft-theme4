<?php

namespace modules\main;

class Env
{

    /**
     * @var mixed[]
     */
    public const CP_VARIABLES = [];

    public static function setCpVars(): void
    {
        foreach (static::CP_VARIABLES as $key => $value) {
            $_SERVER[$key] = $value;
        }
    }
}
