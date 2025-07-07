<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminTableController extends Controller
{
    public function index()
    {
        $tables = Table::all();
        return view('admin.tables', compact('tables'));
    }

    public function downloadQrPdf()
    {
        $tables = \App\Models\Table::all();

        $pdf = Pdf::loadView('admin.tables_pdf', compact('tables'));
        return $pdf->download('lokabirin_table_qrcodes.pdf');
    }
}
