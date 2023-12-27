<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes;

    public $table = 'videos';

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        
    ];

    protected $fillable = [
        'title',
        'content',
        'url',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
