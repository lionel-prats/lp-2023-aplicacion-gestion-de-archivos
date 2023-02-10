<?php

namespace App\Http\Controllers\User;

use App\Models\File;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class FilesController extends Controller
{
    // muestra el listado de archivos propios
    public function index()
    {
        $files = File::whereUserId(Auth::id())->latest()->get();
        return view('user.files.index', compact('files'));
    }

    // muestra un archivo en particular 
    public function show($codeName)
    {
        $file = File::whereCodeName($codeName)->firstOrFail();

        $user_id = Auth::id();

        if ($user_id == $file->user_id) {
            return redirect("storage/$user_id/$file->code_name");
        } else {
            abort(403);
        }
    }

    // procesa la subida fisica de archivos y generar el registro asociado en la tabla files de la BD
    public function store(Request $request)
    {
        $max_size = (int)ini_get('upload_max_filesize') * 10240;

        $files = $request->file('files');
        $user_id = Auth::id();
        
        if ($request->hasFile('files')) {

            
            foreach ($files as $file) { 
                
                
                $fileName =  encrypt( $file->getClientOriginalName() ) . "." . $file->getClientOriginalExtension();
                
                if (Storage::putFileAs("/public/$user_id/", $file, $fileName)) {
                    File::create([
                        'name' => $file->getClientOriginalName(),
                        'code_name' => $fileName,
                        'user_id' => $user_id
                    ]);
                } else {
                    // no se por que, con determinados archivos no entra al if, por ende no se guardan en storage ni se crea el registro en la BD
                    return Storage::putFileAs("/public/$user_id/", $file, $fileName);
                }
            }
            Alert::success('Exito!!', 'Se ha subido el archivo');
            return back();

        } else {
            Alert::error('Error!!', 'Es necesario subir uno o más archivos');
            return back();
        }
    }

    // eliminar un archivo
    public function destroy($file_code_name)
    {
        $file = File::whereCodeName($file_code_name)->firstOrFail();

        unlink(public_path("storage/" . Auth::id() . "/$file->code_name"));

        $file->delete();

        Alert::info('Atención!', "Se ha eliminado el archivo $file->name"); 
        return back();
    }
}
