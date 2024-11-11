<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class TrainingSession extends Model
{
    use HasFactory;
    protected $fillable = [
        'hyperparametre_id',
        'image_directory_id',
    ];
    public array $images = [];

    // Définir la relation avec Hyperparameter
    public function hyperparameter()
    {
        return $this->belongsTo(Hyperparametre::class, 'hyperparametre_id');
    }

    // Définir la relation avec ImageDirectory
    public function imageDirectory()
    {
        return $this->belongsTo(ImageDirectory::class, 'image_directory_id');

    }


    public function getImagesAttribute() {
        if ($this->imageDirectory) {
            // Récupérer tous les fichiers du répertoire et les retourner
            return Storage::disk('public')->files($this->imageDirectory->path);
        }
        return [];
    }
    
    
}
