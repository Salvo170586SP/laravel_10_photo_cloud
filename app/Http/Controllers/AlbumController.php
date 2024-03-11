<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /*  $albums = Album::all(); */

        $search = $request->input('search');
        //ricerca solo del titolo
        $albums = Album::where('user_id', Auth::id())->where('name_album', 'like', "%$search%")->get();

        return view('admin.albums.index', compact('albums'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $album = new Album();
        $album->name_album = $request->name_album;
        $album->user_id = Auth::id();
        $album->save();

        return back()->with('message', 'Album creato con successo');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Album $album)
    {
        $album->update($request->all());

        return back()->with('message', 'Album aggiornato con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album)
    {
        $files = File::where('album_id', $album->id)->get();

        foreach ($files as $file) {
            Storage::delete($file->img_url);
            $file->delete();
        }

        /*   DB::table('files')->delete(); */
        $album->delete();

        return back()->with('message', 'Album eliminato con successo');
    }
}
