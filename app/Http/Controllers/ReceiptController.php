<?php

namespace App\Http\Controllers;

use App\Contracts\PhotoAnalyzerInterface;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    function __construct(private PhotoAnalyzerInterface $analyzer)
    { }

    public function convert(Request $request){
        $request->validate([
            'photo' => 'required|file|mimes:jpeg,png,jpg|max:4096',
        ]);

        $text = $this->analyzer->analyze($request->file('photo'));
        return response()->json([$text]);
    }
}
