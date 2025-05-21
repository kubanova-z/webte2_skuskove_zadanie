<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *   title="My PDF Converter API",
 *   version="1.0.0",
 *   description="Upload any document and get a PDF in response"
 * )
 * @OA\Server(
 *   url=L5_SWAGGER_CONST_HOST,
 *   description="API server"
 * )
 *
 * @OA\Tag(name="Auth",    description="Operations around login, logout, registration")
 * @OA\Tag(name="PDF",     description="Convert documents to PDF")
 * @OA\Tag(name="Profile", description="Fetch and update user profile")
 * @OA\Tag(name="UserGuide", description="Retrieve user guide content")
 * @OA\Tag(name="LoginHistory", description="View past login records")
 */
abstract class Controller
{
    //
}
