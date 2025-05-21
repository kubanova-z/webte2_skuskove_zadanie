<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PDFController extends Controller
{

    
    //REMOVE PAGES METHODS
    public function showRemovePagesForm()
    {
        return view('pdf.remove-pages');
    }


    /**
 * @OA\Post(
 *   path="/api/pdf/remove-pages",
 *   tags={"PDF"},
 *   summary="Remove selected pages from an uploaded PDF",
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="multipart/form-data",
 *       @OA\Schema(
 *         @OA\Property(property="pdf",  type="string", format="binary", description="The PDF to strip pages from"),
 *         @OA\Property(property="pages", type="string", description="Pages to remove, e.g. '1,3-5'")
 *       )
 *     )
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="Returns the processed PDF",
 *     @OA\MediaType(mediaType="application/pdf")
 *   ),
 *   @OA\Response(response=400, description="Validation error"),
 *   @OA\Response(response=500, description="Processing failed")
 * )
 */


    public function processRemovePages(Request $request)
    {
        $this->trackFeatureUsage('remove-pages');
        // 1. Validácia vstupu
        $validated = $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240', // max 10 MB
            'pages' => 'required|string',
        ]);

        // 2. Uloženie súboru
        $uploadedPdf = $request->file('pdf');
        $inputPath = storage_path('app/pdf/input.pdf');
        $uploadedPdf->move(dirname($inputPath), 'input.pdf');

        // 3. Spracovanie čísel strán
        $pagesToRemove = $validated['pages'];

        // 4. Zavolanie Python skriptu
        $outputPath = storage_path('app/pdf/output.pdf');
        $command = "python3 ../scripts/remove-pages.py $inputPath \"$pagesToRemove\" $outputPath";
        exec($command . ' 2>&1', $output, $returnCode);

        if ($returnCode !== 0) {
            return back()->with('error', 'Nepodarilo sa spracovať PDF.');
        }

        // 5. Stiahnutie výsledku
        return response()->download($outputPath)->deleteFileAfterSend(true);
    }


    //MERGE PDFs METHODS
    public function showMergePdfsForm()
    {
        return view('pdf.merge-pdfs');
    }

     /**
     * Merge multiple PDFs into a single document.
     *
     * @OA\Post(
     *   path="/api/pdf/merge",
     *   tags={"PDF"},
     *   summary="Merge multiple PDF files into one PDF",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="pdfs",
     *           type="array",
     *           description="Array of PDF files to merge",
     *           @OA\Items(
     *             type="string",
     *             format="binary"
     *           )
     *         )
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Merged PDF file",
     *     @OA\MediaType(mediaType="application/pdf")
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="Validation error"
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Merging failed"
     *   )
     * )
     */
    public  function processMergePdfs(Request $request)
    {
        $this->trackFeatureUsage('merge-pdf');
        // 1. Validácia vstupu
        $validated = $request->validate([
            'pdfs' => 'required|array',
            'pdfs.*' => 'file|mimes:pdf|max:10240',
        ]);

        $pdfFiles = $request->file('pdfs');
        $inputPaths = [];

        foreach ($pdfFiles as $index => $file) {
            $filename = "input_" . $index . ".pdf";
            $path = storage_path("app/pdf/$filename");
            $file->move(storage_path("app/pdf"), $filename);
            $inputPaths[] = $path;
        }

        $outputPath = storage_path('app/pdf/merged_output.pdf');
        $scriptPath = base_path('scripts/merge-pdfs.py');

        // Zreťazíme cesty k PDF súborom do jedného stringu (oddelené medzerami)
        $inputFilesStr = implode(' ', $inputPaths);

        $command = "python3 $scriptPath $inputFilesStr $outputPath";
        exec($command . ' 2>&1', $output, $returnCode);

        if ($returnCode !== 0) {
            return back()->with('error', 'Zlúčenie PDF súborov zlyhalo.');
        }

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }


    //PDF TO JPG METHODS
    public function showPdfToJpgForm()
    {
        return view('pdf.pdf-to-jpg');
    }


     /**
     * Convert a PDF into JPG images and return them as a ZIP.
     *
     * @OA\Post(
     *   path="/api/pdf/to-jpg",
     *   tags={"PDF"},
     *   summary="Convert PDF pages to JPG images",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="pdf",
     *           type="string",
     *           format="binary",
     *           description="The PDF file to convert"
     *         ),
     *         @OA\Property(
     *           property="dpi",
     *           type="integer",
     *           description="Image resolution in DPI (72–300)",
     *           default=150
     *         )
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="ZIP archive of JPG images",
     *     @OA\MediaType(mediaType="application/zip")
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="Validation error"
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Conversion failed"
     *   )
     * )
     */
    public function processPdfToJpg(Request $request)
    {
        $this->trackFeatureUsage('pdf-to-jpg');
        // 1. Validácia vstupu
        $validated = $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240', // max 10 MB
            'dpi' => 'nullable|integer|min:72|max:300'
        ]);

        // 2. Uloženie PDF
        $uploadedPdf = $request->file('pdf');
        $inputPath = storage_path('app/pdf/input.pdf');
        $uploadedPdf->move(dirname($inputPath), 'input.pdf');

        // 3. Cesta k výstupnej zložke
        $outputDir = storage_path('app/pdf/jpg_output');
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0775, true);
        }

        // 4. DPI (kvalita obrázkov)
        $dpi = $request->input('dpi', 150);

        // 5. Volanie Python skriptu
        $scriptPath = base_path('scripts/pdf-to-jpg.py');
        $command = "python3 $scriptPath $inputPath $outputDir $dpi";
        exec($command . ' 2>&1', $output, $returnCode);

        if ($returnCode !== 0) {
            return back()->with('error', 'Konverzia do JPG zlyhala.');
        }

        // 6. Zbalenie výstupných obrázkov do ZIP
        $zipPath = storage_path('app/pdf/jpg_images.zip');
        $zip = new \ZipArchive;
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {
            foreach (glob($outputDir . '/*.jpg') as $file) {
                $zip->addFile($file, basename($file));
            }
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }


    //JPG TO PDF METHODS
    public function showJpgToPdfForm()
    {
        return view('pdf.jpg-to-pdf');
    }


     /**
     * Combine JPG images into a single PDF document.
     *
     * @OA\Post(
     *   path="/api/pdf/from-jpg",
     *   tags={"PDF"},
     *   summary="Convert uploaded JPG images into a PDF",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="images",
     *           type="array",
     *           description="Array of JPG files to combine",
     *           @OA\Items(
     *             type="string",
     *             format="binary"
     *           )
     *         )
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Generated PDF file",
     *     @OA\MediaType(mediaType="application/pdf")
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="Validation error"
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Conversion failed"
     *   )
     * )
     */
    public function processJpgToPdf(Request $request)
    {
        $this->trackFeatureUsage('jpg-to-pdf');
        $validated = $request->validate([
            'images' => 'required|array',
            'images.*' => 'file|mimes:jpg,jpeg|max:5120',
        ]);

        $imageFiles = $request->file('images');
        $inputPaths = [];

        foreach ($imageFiles as $index => $image) {
            $filename = "image_" . $index . ".jpg";
            $path = storage_path("app/pdf/$filename");
            $image->move(storage_path("app/pdf"), $filename);
            $inputPaths[] = $path;
        }

        $outputPath = storage_path('app/pdf/combined_output.pdf');
        $scriptPath = base_path('scripts/jpg-to-pdf.py');

        $inputFilesStr = implode(' ', $inputPaths);
        $command = "python3 $scriptPath $inputFilesStr $outputPath";
        exec($command . ' 2>&1', $output, $returnCode);

        if ($returnCode !== 0) {
            return back()->with('error', 'Konverzia z JPG do PDF zlyhala.');
        }

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }


//    ROTATE PAGES METHODS
    public function showRotatePagesForm()
    {
        return view('pdf.rotate-pages');
    }


      /**
     * Rotate selected pages of an uploaded PDF.
     *
     * @OA\Post(
     *   path="/api/pdf/rotate",
     *   tags={"PDF"},
     *   summary="Rotate pages in a PDF by 90, 180, or 270 degrees",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="pdf",
     *           type="string",
     *           format="binary",
     *           description="The PDF file to rotate"
     *         ),
     *         @OA\Property(
     *           property="pages",
     *           type="string",
     *           description="Pages to rotate, e.g. '1,3,5'"
     *         ),
     *         @OA\Property(
     *           property="angle",
     *           type="integer",
     *           description="Rotation angle (90, 180, or 270)",
     *           enum={90,180,270}
     *         )
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Rotated PDF download",
     *     @OA\MediaType(mediaType="application/pdf")
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="Validation error"
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Rotation failed"
     *   )
     * )
     */
    public function processRotatePages(Request $request)
    {
        $this->trackFeatureUsage('rotate-pdf');
        $validated = $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240',
            'pages' => 'required|string',
            'angle' => 'required|in:90,180,270',
        ]);

        $uploadedPdf = $request->file('pdf');
        $inputPath = storage_path('app/pdf/input.pdf');
        $uploadedPdf->move(dirname($inputPath), 'input.pdf');

        $outputPath = storage_path('app/pdf/rotated_output.pdf');

        //Parametre
        $pagesToRotate = $validated['pages'];  // napr. "1,3,5"
        $angle = $validated['angle'];          // napr. 90

        $scriptPath = base_path('scripts/rotate-pages.py');
        $command = "python3 $scriptPath $inputPath \"$pagesToRotate\" $angle $outputPath";
        exec($command . ' 2>&1', $output, $returnCode);

        if ($returnCode !== 0) {
            return back()->with('error', 'Otočenie strán zlyhalo.');
        }

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }


//    SPLIT PDF METHODS
    public function showSplitPdfForm()
    {
        return view('pdf.split-pdf');
    }


    /**
     * Split an uploaded PDF into multiple smaller PDFs.
     *
     * @OA\Post(
     *   path="/api/pdf/split",
     *   tags={"PDF"},
     *   summary="Split a PDF into parts of given size",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="pdf",
     *           type="string",
     *           format="binary",
     *           description="The PDF file to split"
     *         ),
     *         @OA\Property(
     *           property="split_size",
     *           type="integer",
     *           description="Number of pages per split file (min 1)",
     *           minimum=1
     *         )
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="ZIP archive of split PDF files",
     *     @OA\MediaType(mediaType="application/zip")
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="Validation error"
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Splitting failed"
     *   )
     * )
     */
    public function processSplitPdf(Request $request)
    {
        $this->trackFeatureUsage('split-pdf');
        $validated = $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240',
            'split_size' => 'required|integer|min:1',
        ]);

        $uploadedPdf = $request->file('pdf');
        $inputPath = storage_path('app/pdf/input.pdf');
        $uploadedPdf->move(dirname($inputPath), 'input.pdf');

        $splitSize = $validated['split_size'];
        $outputDir = storage_path('app/pdf/split_output');
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0775, true);
        }

        $scriptPath = base_path('scripts/split-pdf.py');
        $command = "python3 $scriptPath $inputPath $outputDir $splitSize";
        exec($command . ' 2>&1', $output, $returnCode);

        if ($returnCode !== 0) {
            return back()->with('error', 'Rozdelenie PDF zlyhalo.');
        }

        // Zbalíme všetky výsledné PDF súbory do ZIP
        $zipPath = storage_path('app/pdf/split_files.zip');
        $zip = new \ZipArchive;
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {
            foreach (glob($outputDir . '/*.pdf') as $file) {
                $zip->addFile($file, basename($file));
            }
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }





//    PROTECT PDF METHODS
    public function showProtectPdfForm()
    {
        return view('pdf.protect-pdf');
    }


    /**
     * Protect an uploaded PDF with a password.
     *
     * @OA\Post(
     *   path="/api/pdf/protect",
     *   tags={"PDF"},
     *   summary="Add password protection to a PDF",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="pdf",
     *           type="string",
     *           format="binary",
     *           description="The PDF file to protect"
     *         ),
     *         @OA\Property(
     *           property="password",
     *           type="string",
     *           description="Password to set (min 4 characters)"
     *         )
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Protected PDF download",
     *     @OA\MediaType(mediaType="application/pdf")
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="Validation error"
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Protection failed"
     *   )
     * )
     */
    public function processProtectPdf(Request $request)
    {
        $this->trackFeatureUsage('protect-pdf');
        $validated = $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240',
            'password' => 'required|string|min:4',
        ]);

        $uploadedPdf = $request->file('pdf');
        $inputPath = storage_path('app/pdf/input.pdf');
        $uploadedPdf->move(dirname($inputPath), 'input.pdf');

        $password = $validated['password'];
        $outputPath = storage_path('app/pdf/protected_output.pdf');
        $scriptPath = base_path('scripts/protect-pdf.py');

        $command = "python3 $scriptPath $inputPath $outputPath \"$password\"";
        exec($command . ' 2>&1', $output, $returnCode);

        if ($returnCode !== 0) {
            return back()->with('error', 'Zabezpečenie PDF zlyhalo.');
        }

        return response()->download($outputPath)->deleteFileAfterSend(true);

    }





//    UNLOCK PDF METHODS
    public function showUnlockPdfForm()
    {
        return view('pdf.unlock-pdf');
    }


     /**
     * Unlock a password-protected PDF.
     *
     * @OA\Post(
     *   path="/api/pdf/unlock",
     *   tags={"PDF"},
     *   summary="Remove password protection from a PDF",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="pdf",
     *           type="string",
     *           format="binary",
     *           description="The locked PDF file to unlock"
     *         ),
     *         @OA\Property(
     *           property="password",
     *           type="string",
     *           description="Password for the PDF"
     *         )
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Unlocked PDF download",
     *     @OA\MediaType(mediaType="application/pdf")
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="Validation error"
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Unlocking failed"
     *   )
     * )
     */
    public function processUnlockPdf(Request $request)
    {
        $this->trackFeatureUsage('unlock-pdf');
        $validated = $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240',
            'password' => 'required|string|min:1',
        ]);

        $uploadedPdf = $request->file('pdf');
        $inputPath = storage_path('app/pdf/locked_input.pdf');
        $uploadedPdf->move(dirname($inputPath), 'locked_input.pdf');

        $password = $validated['password'];
        $outputPath = storage_path('app/pdf/unlocked_output.pdf');
        $scriptPath = base_path('scripts/unlock-pdf.py');

        $command = "python3 $scriptPath $inputPath $outputPath \"$password\"";
        exec($command . ' 2>&1', $output, $returnCode);

        if ($returnCode !== 0) {
            return back()->with('error', 'Odomknutie PDF zlyhalo. Skontroluj heslo alebo typ súboru.');
        }

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }



//    UNLOCK PDF METHODS
    public function showResizePagesForm()
    {
        return view('pdf.resize-pages');
    }


      /**
     * Resize pages of an uploaded PDF to a specified paper size.
     *
     * @OA\Post(
     *   path="/api/pdf/resize",
     *   tags={"PDF"},
     *   summary="Resize PDF pages to A4, A5, or A6",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="pdf",
     *           type="string",
     *           format="binary",
     *           description="The PDF file whose pages will be resized"
     *         ),
     *         @OA\Property(
     *           property="size",
     *           type="string",
     *           description="Target page size",
     *           enum={"A4","A5","A6"}
     *         )
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Resized PDF download",
     *     @OA\MediaType(mediaType="application/pdf")
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="Validation error"
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Resize operation failed"
     *   )
     * )
     */
    public function processResizePages(Request $request)
    {
        $this->trackFeatureUsage('resize-pdf');
        $validated = $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240',
            'size' => 'required|in:A4,A5,A6',
        ]);

        $uploadedPdf = $request->file('pdf');
        $inputPath = storage_path('app/pdf/input.pdf');
        $uploadedPdf->move(dirname($inputPath), 'input.pdf');

        $size = $validated['size'];
        $outputPath = storage_path('app/pdf/resized_output.pdf');
        $scriptPath = base_path('scripts/resize-pages.py');

        $command = "python3 $scriptPath $inputPath $outputPath $size";
        exec($command . ' 2>&1', $output, $returnCode);

        if ($returnCode !== 0) {
            return back()->with('error', 'Zmena veľkosti strán zlyhala.');
        }

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }

    //compress PDF
    public function showCompressForm()
    {
        return view('pdf.compress');
    }


     /**
     * Compress an uploaded PDF to reduce file size.
     *
     * @OA\Post(
     *   path="/api/pdf/compress",
     *   tags={"PDF"},
     *   summary="Compress a PDF with specified quality",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="pdf",
     *           type="string",
     *           format="binary",
     *           description="The PDF file to compress"
     *         ),
     *         @OA\Property(
     *           property="quality",
     *           type="integer",
     *           description="Compression quality (10–100)",
     *           minimum=10,
     *           maximum=100
     *         )
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Compressed PDF download",
     *     @OA\MediaType(mediaType="application/pdf")
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="Validation error"
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Compression failed"
     *   )
     * )
     */
    public function processCompress(Request $request)
    {
        $this->trackFeatureUsage('compress-pdf');

        $data = $request->validate([
            'pdf'     => 'required|file|mimes:pdf|max:10240',
            'quality' => 'required|integer|min:10|max:100',
        ]);

        // 1. Uloženie vstupného PDF
        $uploadedPdf = $request->file('pdf');
        $inputPath = storage_path('app/pdf/input.pdf');
        $uploadedPdf->move(dirname($inputPath), 'input.pdf');

        // 2. Cesta k výstupnému súboru
        $outputPath = storage_path('app/pdf/compressed_output.pdf');

        // 3. Cesta k skriptu
        $scriptPath = base_path('scripts/compress-pdf.py');

        // 4. Spustenie Python skriptu
        $quality = $data['quality'];
        $command = "python3 $scriptPath \"$inputPath\" \"$outputPath\" $quality";
        exec($command . ' 2>&1', $output, $returnCode);

        if ($returnCode !== 0 || !file_exists($outputPath)) {
            return back()->withErrors([
                'pdf' => "Compression failed: " . implode("\n", $output),
            ]);
        }

        // 5. Stiahnutie výsledku
        return response()->download($outputPath)->deleteFileAfterSend(true);
    }



    //Funkcia na sledovanie pouzitych funkcionalit
    protected function trackFeatureUsage(string $feature): void
    {
        if (auth()->check()) {
            $login = \App\Models\Login::where('user_id', auth()->id())
                ->latest('login_time')
                ->first();

            if ($login) {
                $features = $login->used_features ?? [];

                if (!in_array($feature, $features)) {
                    $features[] = $feature;
                    $login->used_features = $features;
                    $login->save();
                }
            }
        }
    }




}
