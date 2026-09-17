<?php

namespace App\Models\Traits;

trait HasSurveyVerification
{
    protected static function bootHasSurveyVerification()
    {
        static::saving(function ($model) {
            if (!isset($model->attributes['is_verified']) || $model->attributes['is_verified'] === null) {
                $model->is_verified = 1;
            }
        });

        static::updating(function ($model) {
            $model->is_verified = 1;
        });
    }
}
