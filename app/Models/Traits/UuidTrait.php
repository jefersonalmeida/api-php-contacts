<?php

namespace Jas\Models\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Trait UuidTrait
 * @package Jas\Models\Traits
 */
trait UuidTrait
{
    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(
            function ($model) {
                /**
                 * @var $model Model
                 */
                $model->incrementing = false;
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        );

        static::retrieved(
            function ($model) {
                $model->incrementing = false;
            }
        );

        static::saving(
            function (Model $model) {
                if ($model->timestamps === true) {
                    $model->{$model->getUpdatedAtColumn()} = Carbon::now();
                }
            }
        );
    }
}
