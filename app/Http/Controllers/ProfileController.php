<?php

namespace App\Http\Controllers;


use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class ProfileController extends Controller
{
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Profile User',
            'list' => ['Home', 'Profile']
        ];
    
        $activeMenu = 'profile'; // Set menu as active
        $level = LevelModel::all(); // If you're using levels
    
        $page = (object) [
            'title' => 'Profile User'
        ];
    
        // Pass the authenticated user
        $user = auth()->user();
    
        return view('profile.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'user' => $user, 
            'activeMenu' => $activeMenu
        ]);
    }    

    public function upload(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|max:4096',
        ]);

        $file = $request->file('foto');

        $fileContents = file_get_contents($file->getRealPath());

        $user = auth()->user(); 
        $user->photo = $fileContents;

        $user->save(); 

        return back()->with('success', 'Foto berhasil diperbarui.');
    }

    public function showProfileImage()
    {
        $user = auth()->user();

        if ($user && $user->photo) {
            return response($user->photo)->header('Content-Type', 'photo/jpg'); // Adjust MIME type accordingly
        } else {
            return response('No image', 404);
        }
    }

    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();
        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];
        $page = (object) [
            "title" => 'Edit user'
        ];
        $activeMenu = 'user'; // set menu yang sedang aktif
        return view('profile.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
    }
    
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        // Validasi input form
        $request->validate([
            'username' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            // Validasi lainnya jika diperlukan
        ]);
    
        // Update data user
        $user->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'level' => $request->level,
            // Field lainnya jika ada
        ]);
    
        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }

    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('profile.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                'nama' => 'required|max:100',
                'password' => 'nullable|min:6|max:20'
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }
            $check = UserModel::find($id);
            if ($check) {
                if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('password');
                }
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function upload_foto(Request $request){
        // buat validasi ektensi dari filenya
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // ini buat nentuin mau ditaruh mana file yang diupload
        $folderPath = 'uploads/profile_pictures/'.auth()->user()->username.'/';

        // ini buat hapus foto profil lama yang nantinya diganti sama yang baru
        $extensions = ['jpg', 'jpeg', 'png'];
        foreach ($extensions as $ext) {
            $namaFileLama = $folderPath . auth()->user()->username . '_profile.' .$ext;
            if(Storage::disk('public')->exists($namaFileLama)){
                Storage::disk('public')->delete($namaFileLama);
                break;
            }
        }

        // Ambil file dari request
        $file = $request->file('foto');

        // Buat nama file unik
        $filename = auth()->user()->username . '_profile.' . $file->getClientOriginalExtension();

        // Simpan file ke storage/app/public/uploads/profile_pictures/(username)
        $file->storeAs($folderPath, $filename, 'public');

        // Lakukan sesuatu dengan file, misalnya simpan ke database
        // auth()->user()->update(['profile_picture' => $filename]);

        return back()->with('success', 'Foto berhasil diupload.');
    }
}