<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['name','img_url'];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
