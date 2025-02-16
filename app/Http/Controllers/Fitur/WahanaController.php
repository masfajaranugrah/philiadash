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
             'images' => 'required|array', // Validasi sebagai array
             'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi setiap gambar
         ]);
     
         $imagePaths = [];
     
         if ($request->hasFile('images')) {
             foreach ($request->file('images') as $image) {
                 $file_name = time() . '_' . $image->getClientOriginalName();
                 $image->storeAs('public/wahana/', $file_name);
                 $imagePaths[] = $file_name; // Simpan nama file ke array
             }
         }
     
         // Simpan ke database dengan format JSON
         Wahana::create([
             'title' => $request->title,
             'description' => $request->description,
             'location' => $request->location,
             'price' => $request->price,
             'images' => json_encode($imagePaths), // Simpan sebagai JSON
         ]);
     
         return redirect('wahana-view')->with('success', 'Fasilitas wahana berhasil dibuat!');
     }
     
    
 
    //  public function update(Request $request, $id_wahana)
    //  {
    //      $wahana = Wahana::find($id_wahana);
     
    //      if (!$wahana) {
    //          return redirect('wahana-view')->with('error', 'Data tidak ditemukan!');
    //      }
     
    //      $request->validate([
    //          'title' => 'required|string|max:255',
    //          'description' => 'required|string',
    //          'location' => 'required|string|max:255',
    //          'price' => 'required|integer|min:1',
    //          'images' => 'nullable|array',
    //          'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    //      ]);
     
    //      // Hapus gambar lama jika ada file baru diunggah
    //      if ($request->hasFile('images')) {
    //          $gambarSebelumnya = json_decode($wahana->images, true) ?? [];
     
    //          // Hapus semua gambar lama dari storage
    //          foreach ($gambarSebelumnya as $gambar) {
    //              if (Storage::exists('public/wahana/' . $gambar)) {
    //                  Storage::delete('public/wahana/' . $gambar);
    //              }
    //          }
     
    //          // Upload gambar baru
    //          $imagePaths = [];
    //          foreach ($request->file('images') as $image) {
    //              $file_name = time() . '_' . $image->getClientOriginalName();
    //              $image->storeAs('public/wahana/', $file_name);
    //              $imagePaths[] = $file_name;
    //          }
     
    //          // Simpan gambar baru ke database dalam format JSON
    //          $wahana->images = json_encode($imagePaths);
    //      }
     
    //      // Update data lainnya
    //      $wahana->update([
    //          'title' => $request->title,
    //          'description' => $request->description,
    //          'location' => $request->location,
    //          'price' => $request->price,
    //          'images' => isset($imagePaths) ? json_encode($imagePaths) : $wahana->images
    //      ]);
     
    //      return redirect('wahana-view')->with('success', 'Update fasilitas wahana berhasil!');
    //  }
    public function update(Request $request, $id_wahana)
    {
        $wahana = Wahana::find($id_wahana);
        if (!$wahana) {
            return redirect('wahana-view')->with('error', 'Data tidak ditemukan!');
        }
            

        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'description' => 'required|string',
        //     'location' => 'required|string|max:255',
        //     'price' => 'required|integer|min:1',
        //     'images' => 'nullable|array',
        //     'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]);
      
       
        // Ambil gambar lama dari database
        $gambarSebelumnya = json_decode($wahana->images, true) ?? [];
     
        // Filter gambar lama yang akan dipertahankan
        $gambarTerpilih = $request->old_images ?? [];
    
        // Hapus gambar yang tidak ada di daftar gambar yang dipertahankan
        $gambarDihapus = array_diff($gambarSebelumnya, $gambarTerpilih);
    
        foreach ($gambarDihapus as $gambar) {
            if (Storage::exists('public/wahana/' . $gambar)) {
                Storage::delete('public/wahana/' . $gambar);
            }
        }
    
        // Upload gambar baru jika ada
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $file_name = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/wahana/', $file_name);
                $gambarTerpilih[] = $file_name;
            }
        }
    
        // Simpan perubahan ke database
        $wahana->update([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'price' => $request->price,
            'images' => json_encode($gambarTerpilih) // Simpan hanya gambar yang dipilih dan gambar baru
        ]);
    
        return redirect('wahana-view')->with('success', 'Update fasilitas wahana berhasil!');
    }
    
     
     public function destroy($id_wahana)
     {
         $wahana = Wahana::find($id_wahana);
     
         if (!$wahana) {
             return redirect()->back()->with('error', 'Data tidak ditemukan.');
         }
     
         // Hapus semua gambar yang tersimpan di storage
         $gambarSebelumnya = json_decode($wahana->images, true) ?? [];
     
         foreach ($gambarSebelumnya as $gambar) {
             if (Storage::exists('public/wahana/' . $gambar)) {
                 Storage::delete('public/wahana/' . $gambar);
             }
         }
     
         // Hapus data dari database
         $wahana->delete();
     
         return redirect()->back()->with('success', 'Fasilitas wahana dan semua gambar berhasil dihapus.');
     }
   
}
