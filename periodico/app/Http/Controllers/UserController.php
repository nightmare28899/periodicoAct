<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = Cliente::all();

        return view('users.index', compact('users'));
    }

    /**
     * Export content to PDF with View
     *
     * @return void
     */
    public function downloadPdf()
    {
        $users = Cliente::all();

        view()->share('users.pdf',$users);

        $pdf = PDF::loadView('users.pdf', ['users' => $users]);
        $pdf->setPaper('A5', 'landscape');

        return $pdf->download('users.pdf');
    }
}
