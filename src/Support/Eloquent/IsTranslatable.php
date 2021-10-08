<?php

namespace Tir\Crud\Support\Eloquent;

use Illuminate\Support\Facades\App;

trait IsTranslatable
{
    public static function boot()
    {
        parent::boot();
        
        self::creating(function($model){
            $model->locale = request()->input('locale');
        });

    }

    public function newQuery() {
        return parent::newQuery()->where('locale', request()->input('locale'));
    }

}