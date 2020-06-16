<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['title', 'body', 'updated_at', 'slug', 'user', 'is_deleted'];
}
