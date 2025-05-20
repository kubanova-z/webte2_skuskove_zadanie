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

    public function destroyAll()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Access denied');
        }

        Login::truncate(); // removes all rows from the table

        return redirect('/login-history')->with('success', 'All login history deleted.');
    }

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