<?php

namespace App\Http\Controllers\Fitur;

use App\Http\Controllers\Controller;
use App\Models\cr;
use App\Models\Question;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Question::all())
                         ->header('Access-Control-Allow-Origin', '*')
                         ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                         ->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, Authorization, Origin, Accept, X-Auth-Token');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function view()
    {
        //index
        $question = Question::all();
        return view('components.Question.question', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
  
        ],
    [
        'pertanyaan.required' => 'pertanyaan tidak boleh kosong',
         'jawaban.required' => 'jawaban tidak boleh kosong',

    ]);
    
            Question::create([
                'pertanyaan' => $request->pertanyaan,
                'jawaban' => $request->jawaban,
           
                
            ]);
        
     
        return redirect('question')->with('success', 'FAQ berhasil di buat!');
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_question)
    {
        $question = Question::find($id_question);
        
        if (!$question) {
            return redirect('wahana-view')->with('error', 'Data tidak ditemukan!');
        }
    
   
        // Update data selain gambar
        $question->update([
            'pertanyaan' => $request->pertanyaan,
            'jawaban' => $request->jawaban,
            
        ]);
    
      
        return redirect('question')->with('success', 'Update FAQ berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_question)
    {
        // Cari data wahana berdasarkan ID
        $question = Question::find($id_question);
    
        if (!$question) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
    

        $question->delete();
    
        return redirect()->back()->with('success', 'FAQ berhasil dihapus.');
    }
   
}
