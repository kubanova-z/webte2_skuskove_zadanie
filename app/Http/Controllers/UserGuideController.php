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

    public function downloadPdf()
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('user-guide-pdf');
        return $pdf->download('user-guide.pdf');
    }

}
