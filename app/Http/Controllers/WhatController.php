<?php

namespace App\Http\Controllers;

use App\Models\whats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class WhatController extends Controller
{
    public function index()
    {
        return response()->json(whats::all())
                         ->header('Access-Control-Allow-Origin', '*')
                         ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                         ->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, Authorization, Origin, Accept, X-Auth-Token');
    }
    
    public function view()
    {
        $whats = whats::all();
        return view('components.Whats.whats', compact('whats'));
    }
    

 
    
    public function store(Request $request)
    {
        // Buat validasi tanpa menghentikan proses jika ukuran lebih kecil
        $validator = Validator::make($request->all(), [
            'images' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);
    
        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }
    
        // Jika lolos validasi dasar, cek ukuran gambar
        $gambar = $request->file('images');
        list($width, $height) = getimagesize($gambar);
    
        $file_name = time() . '_' . $gambar->getClientOriginalName();
        $gambar->storeAs('public/whats/', $file_name);
    
        whats::create([
            'images' => $file_name,
        ]);
    
        // Jika gambar lebih kecil dari batas, tambahkan peringatan
        if ($width < 370 || $height < 210) {
            return redirect('whats-view')->with([
                'success' => 'Kegiatan berhasil dibuat!',
                'warning' => 'Peringatan: Ukuran gambar lebih kecil dari 370x210 px!',
            ]);
        }
    
        return redirect('whats-view')->with('success', 'Kegiatan berhasil dibuat!');
    }
    
    
 
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_whats)
    {

   
    
        $whats = whats::find($id_whats);
        
        if (!$whats) {
            return redirect('whats-view')->with('error', 'Data tidak ditemukan!');
        }
    
        // Simpan nama gambar lama
        $gambarSebelumnya = $whats->images;
    
   
    
        // Jika ada gambar baru yang diunggah
        if ($request->hasFile('images')) {
            // Hapus gambar lama jika ada
            if ($gambarSebelumnya && Storage::exists('public/whats/' . $gambarSebelumnya)) {
                Storage::delete('public/whats/' . $gambarSebelumnya);
            }
    
            // Upload gambar baru
            $gambarBaru = $request->file('images');
            $file_name = time() . '_' . $gambarBaru->getClientOriginalName();
            $gambarBaru->storeAs('public/whats', $file_name);
    
            // Simpan nama gambar baru ke database
            $whats->update(['images' => $file_name]);
        }
    
return redirect('whats-view')->with('success', 'Update Kegiatan   berhasil!');
    }

 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_whats)
    {
        // Cari data whats berdasarkan ID
        $whats = whats::find($id_whats);
    
        if (!$whats) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
    
        // Cek apakah whats memiliki gambar
        if ($whats->images && Storage::exists('public/whats/' . $whats->images)) {
            // Hapus gambar lama dari storage
            Storage::delete('public/whats/' . $whats->images);
        }
    
        // Hapus data dari database
        $whats->delete();
    
        return redirect()->back()->with('success', 'Kegiatan  berhasil dihapus.');
    }
}
