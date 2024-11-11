<?php

namespace App\Http\Controllers;

use App\Models\Hyperparametre;
use App\Models\ImageDirectory;
use App\Models\TrainingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HyperparametreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les hyperparamètres et le dossier d’images
        $request->validate([
            'taux_app' => ['required'],
            'nb_epoque' => ['required'],
            'taille_lot' => ['required'],
            'patience' => ['required'],
            'monitor' => ['required'],
            'optimiseur' => ['required'],
            'nom_modele' => ['required'],
            'f_activation' => ['required'],
            'Val_split' => ['required'],
            'test_split' => ['required'],
            'images' => ['required'], // Assure-toi que le dossier d’images est sélectionné
        ]);
    
        // Enregistrer les hyperparamètres
        $hyper = new Hyperparametre();
        $hyper->taux_app = $request->input('taux_app');
        $hyper->nb_epoque = $request->input('nb_epoque');
        $hyper->taille_lot = $request->input('taille_lot');
        $hyper->patience = $request->input('patience');
        $hyper->monitor = $request->input('monitor');
        $hyper->optimiseur = $request->input('optimiseur');
        $hyper->nom_modele = $request->input('nom_modele');
        $hyper->f_activation = $request->input('f_activation');
        $hyper->Val_split = $request->input('Val_split');
        $hyper->test_split = $request->input('test_split');
        $hyper->save(); 
    
        $imageDirectory = new ImageDirectory();
    
    $directoryPath = "image_directories/{$hyper->id}"; 
    Storage::disk('public')->makeDirectory($directoryPath); 

    if ($request->hasFile('images')) {
    foreach ($request->file('images') as $image) {
        $path = $image->store($directoryPath, 'public'); 

        $imageDirectory->path = $directoryPath; 
        }
        }

    
        $imageDirectory->save();
    
        $trainingSession = new TrainingSession();
        $trainingSession->hyperparametre_id = $hyper->id;
        $trainingSession->image_directory_id = $imageDirectory->id;
        $trainingSession->save(); 

        return redirect()->route('hyperparametre.create')->with('success', 'Hyperparamètres et dossier d\'images enregistrés avec succès.');
    }
    

    public function history()
    {
        $trainingHistory = TrainingSession::with(['hyperparameter', 'imageDirectory'])->get();

    /** @var \App\Models\TrainingSession[] $trainingHistory */
        foreach ($trainingHistory as $session) {
            if ($session->imageDirectory) {
                $session->images = Storage::disk('public')->files($session->imageDirectory->path);
               
            } else {
                $session->images = [];
            }
        }
    
        return view('history', compact('trainingHistory'));
    }

    public function showHyper()
{
    $hyperparameters = Hyperparametre::all(); 
    return response()->json($hyperparameters);
}
   
    public function showDoss()
    {
        $images = ImageDirectory::select('path')->get(); 
        return response()->json($images);
    }





    /**
     * Display the specified resource.
     */
    public function show(Hyperparametre $hyperparametre)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hyperparametre $hyperparametre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hyperparametre $hyperparametre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $hyperparameter = Hyperparametre::findOrFail($id);
        $hyperparameter->delete();
    
       
        return response()->json(['success' => 'Hyperparamètre supprimé avec succès.']);
    }
}
