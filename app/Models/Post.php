<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table="posts";
    protected $fillable =[
        'id',
        'text',
        'img',
        'user_id',
        'type'
    ];
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }
    protected $primaryKey = "id";
    public $timestamps = true;
}
