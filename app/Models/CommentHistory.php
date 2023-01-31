<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentHistory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'comment_id',
        'old_value',
        'new_value',
        'created_at'
    ];
}
