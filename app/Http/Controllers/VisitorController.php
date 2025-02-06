<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
{
    public function trackVisitor(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'device' => 'required|string',
            'ip_address' => 'required|string',
        ]);

        // Create the visitor record
        Visitor::create([
            'ip_address' => $validated['ip_address'],
            'device' => $validated['device'],
        ]);

        // Respond with success
        return response()->json(['message' => 'Visitor tracked successfully']);
    }

    public function getDeviceCounts()
    {
        $deviceCounts = Visitor::select(
                DB::raw("DATE_FORMAT(created_at, '%d %b %Y') as visit_date"),
                DB::raw("CASE 
                            WHEN device = 'desktop' THEN CONCAT(DATE_FORMAT(created_at, '%d %b %Y'))
                            WHEN device = 'mobile' THEN CONCAT(DATE_FORMAT(created_at, '%d %b %Y'))
                            ELSE device
                        END as device"),
                DB::raw('count(*) as count')
            )
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%d %b %Y')"), DB::raw("CASE 
                            WHEN device = 'desktop' THEN CONCAT(DATE_FORMAT(created_at, '%d %b %Y'))
                            WHEN device = 'mobile' THEN CONCAT(DATE_FORMAT(created_at, '%d %b %Y'))
                            ELSE device
                        END"))
            ->orderBy('visit_date', 'asc')
            ->get();
    
        return response()->json($deviceCounts);
    }
    

}
