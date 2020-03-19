<?php

namespace Telkins\Watchable\Tests\Support\Models;

use Illuminate\Database\Eloquent\Model;
use Telkins\Watchable\Watchable;

class Movie extends Model
{
    use Watchable;

    protected $fillable = [
        'title',
    ];
}