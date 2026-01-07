<?php

namespace App\Http\Controllers;

use App\Contracts\FileConverterInterface;
use App\Contracts\PhotoAnalyzerInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ReceiptController extends Controller
{
    private const FileName = 'receipt.csv';
    function __construct(
        private readonly PhotoAnalyzerInterface $analyzer,
        private readonly FileConverterInterface $converter,
    )
    { }

    public function convert(Request $request){
        $request->validate([
            'photo' => 'required|file|mimes:jpeg,png,jpg|max:4096',
        ]);

        $data = $this->analyzer->analyze($request->file('photo'));
        $csv = $this->converter->convert($data);

        $filename = self::FileName;
        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
