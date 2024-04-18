<?php

namespace Brackets\LaravelModuleComposerPackage\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = ['notes'];

    protected $casts = [];
}
