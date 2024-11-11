<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hyperparametre extends Model
{
    protected $fillable = ['taux_app','nb_epoque','taille_lot', 'patience', 'monitor','optimiseur','nom_modele','f_activation','Val_split','test_split'];
    use HasFactory;

    public function imageDirectories()
    {
        return $this->belongsToMany(ImageDirectory::class, 'training_sessions');
    }
}
