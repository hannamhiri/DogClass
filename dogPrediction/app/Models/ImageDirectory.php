<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageDirectory extends Model
{
    use HasFactory;
    protected $fillable = ['path'];


    public function hyperparameters()
    {
        return $this->belongsToMany(Hyperparametre::class, 'training_sessions');
    }

}
