<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LoginHistoryController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Access denied');
        }

        $logins = Login::with('user')->orderBy('login_time', 'desc')->get();
        return view('login-history', compact('logins'));
    }


    /**
     * Delete *all* login history records.
     *
     * @OA\Delete(
     *   path="/api/login-history",
     *   tags={"LoginHistory"},
     *   summary="Truncate the login history (admin only)",
     *   security={{"sanctum": {}}},
     *   @OA\Response(
     *     response=204,
     *     description="All login records deleted"
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="Access denied"
     *   )
     * )
     */
    public function destroyAll()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Access denied');
        }

        Login::truncate(); // removes all rows from the table

        return redirect('/login-history')->with('success', 'All login history deleted.');
    }


/**
 * Export the login history as a CSV download.
 *
 * @OA\Get(
 *   path="/api/login-history/export",
 *   tags={"LoginHistory"},
 *   summary="Download login history CSV (admin only)",
 *   security={{"sanctum": {}}},
 *   @OA\Response(
 *     response=200,
 *     description="CSV file stream",
 *     @OA\MediaType(
 *       mediaType="text/csv"
 *     )
 *   ),
 *   @OA\Response(
 *     response=403,
 *     description="Access denied"
 *   )
 * )
 */
    public function export()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Access denied');
        }

        $filename = 'login_history.csv';

        $response = new StreamedResponse(function () {
            $handle = fopen('php://output', 'w');

            // header
            fputcsv($handle, ['User', 'Time', 'City', 'Country']);

            // data
            $logins = Login::with('user')->orderBy('login_time', 'desc')->get();

            foreach ($logins as $login) {
                fputcsv($handle, [
                    $login->user->name ?? 'Unknown',
                    $login->login_time,
                    $login->city,
                    $login->country,
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }



}