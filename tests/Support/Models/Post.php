<?php

namespace Spatie\Comments\Tests\Support\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Comments\Models\Concerns\HasComments;

class Post extends Model
{
    use HasComments;
    use HasFactory;

    protected $guarded = [];
}
