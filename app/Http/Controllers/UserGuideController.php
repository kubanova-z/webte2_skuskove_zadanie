<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class UserGuideController extends Controller
{
    public function show()
    {
        return view('user-guide');
    }


    /**
     * Download the user guide as a PDF.
     *
     * @OA\Get(
     *   path="/api/user-guide/pdf",
     *   tags={"UserGuide"},
     *   summary="Download the user guide PDF",
     *   @OA\Response(
     *     response=200,
     *     description="User guide PDF file",
     *     @OA\MediaType(mediaType="application/pdf")
     *   )
     * )
     */
    public function downloadPdf()
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('user-guide-pdf');
        return $pdf->download('user-guide.pdf');
    }

}
