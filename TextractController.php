<?php

namespace App\Http\Controllers;

use App\Services\AWS\AWSService;
use Illuminate\Http\Request;

class TextractController extends Controller
{


    public function __construct(protected AWSService $service)
    {
    }
    public function analyze(Request $request)
    {

        $request->validate([
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);


        $file = $request->file('document');
        $path = $file->getRealPath();


        $queryResults = $this->service->textract($path);

        if (!empty($queryResults)) {
            return response()->json([
                'message' => 'Queries encontrados',
                'data' => $queryResults
            ]);
        } else {
            return response()->json([
                'message' => 'No se encontraron resultados de Queries.'
            ]);
        }
    }
}
