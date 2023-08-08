<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $albumId = $request->input('album_id');

        foreach ($request->file('files') as $uploadedFile) {
            $file = new File();
            $file->album_id = $albumId;

            // Salva il file sul filesystem e ottieni il percorso
            $url_file = Storage::put('/files', $uploadedFile);

            // Imposta il percorso del file nel campo 'img_url'
            $file->img_url = $url_file;
            $file->save();
        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        /* dd($file); */
        return back()->with( compact('file'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        if (File::exists($file->img_url)) {
            Storage::delete($file->img_url);
        }
        $file->delete();

        return back();
    }


    public function albumPage(Album $album)
    {
        $album = Album::findOrFail($album->id);
        $files = File::where('album_id', $album->id)->get();

        return view('admin.files.albumPage', compact('files', 'album'));
    }

    public function destroyAll()
    {
        //seleziono la cartella storage in public
        $files = DB::table('files')->get();

        foreach ($files as $file) {
            Storage::delete($file->img_url);
        }

        DB::table('files')->delete();

        return back();
    }

    public function downloadFile(File $file)
    {
        $filePath = public_path('storage/' . $file->img_url);
        $fileName = 'img.jpg';

        return response()->download($filePath, $fileName);
    }
}
