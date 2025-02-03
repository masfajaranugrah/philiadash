<?php

namespace App\Http\Controllers\Fitur;

use App\Http\Controllers\Controller;
use App\Models\cr;
use App\Models\Wahana;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

 class WahanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Wahana::all())
                         ->header('Access-Control-Allow-Origin', '*')
                         ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                         ->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, Authorization, Origin, Accept, X-Auth-Token');
    }
    
    public function view()
    {
        $wahana = Wahana::all();
        return view('components.Wahana.wahana', compact('wahana'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
 
    public function store(Request $request)
    {

  
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'price' => 'required|integer|min:1',
            'images' => 'required|image|mimes:jpeg,png,jpg,gif', 
        ]);
   
        $gambar = $request->file('images');
      
        if ($gambar) {
            $file_name = time() . '_' . $gambar->getClientOriginalName();
            $gambar->storeAs('public/wahana/', $file_name);

            Wahana::create([
                'title' => $request->title,
                'description' => $request->description,
                'location' => $request->location,
                'price' => $request->price,
                'images' => $file_name,
                
            ]);
        }

        return redirect('wahana-view')->with('success', 'create new barang success ');
    }
    
 
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_wahana)
    {

   
    
        $wahana = Wahana::find($id_wahana);
        
        if (!$wahana) {
            return redirect('wahana-view')->with('error', 'Data tidak ditemukan!');
        }
    
        // Simpan nama gambar lama
        $gambarSebelumnya = $wahana->images;
    
        // Update data selain gambar
        $wahana->update([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'price' => $request->price,
        ]);
    
        // Jika ada gambar baru yang diunggah
        if ($request->hasFile('images')) {
            // Hapus gambar lama jika ada
            if ($gambarSebelumnya && Storage::exists('public/wahana/' . $gambarSebelumnya)) {
                Storage::delete('public/wahana/' . $gambarSebelumnya);
            }
    
            // Upload gambar baru
            $gambarBaru = $request->file('images');
            $file_name = time() . '_' . $gambarBaru->getClientOriginalName();
            $gambarBaru->storeAs('public/wahana', $file_name);
    
            // Simpan nama gambar baru ke database
            $wahana->update(['images' => $file_name]);
        }
    
return redirect('wahana-view')->with('success', 'Update barang berhasil!');
    }

 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_wahana)
    {
        // Cari data wahana berdasarkan ID
        $wahana = Wahana::find($id_wahana);
    
        if (!$wahana) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
    
        // Cek apakah wahana memiliki gambar
        if ($wahana->images && Storage::exists('public/wahana/' . $wahana->images)) {
            // Hapus gambar lama dari storage
            Storage::delete('public/wahana/' . $wahana->images);
        }
    
        // Hapus data dari database
        $wahana->delete();
    
        return redirect()->back()->with('success', 'Wahana dan gambar berhasil dihapus.');
    }
   
}
