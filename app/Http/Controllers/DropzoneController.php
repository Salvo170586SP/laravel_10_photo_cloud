<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DropzoneController extends Controller
{
    public function store(Request $request)
    {

        if ($request->hasFile('file')) {

            $albumId = $request->input('album_id');
            $uploadedFile = $request->file('file');

            $filePath = $uploadedFile->store('files');
            
            $file = new File();
            $file->album_id = $albumId;
            $file->img_url = $filePath ;
            $file->save();

            return response()->json(['success' => 'Immagine aggiunta con successo']);
        } else {

            return response()->json(['error' => 'Errore fatale aggiunta con successo']);
        }
    }
}
