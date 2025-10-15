<?php

namespace App\Core\Utils\GenerateId;

trait GenerateIdTimestamp
{
    protected static function bootGenerateIdTimestamp(): void
    {
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->id = Snowflake::id();
            }
        });
    }
}
