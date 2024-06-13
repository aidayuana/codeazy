<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManualBookController extends Controller
{
    public function download()
    {
        $filePath = 'path/to/manual-book.pdf'; // Sesuaikan path dengan lokasi file manual book Anda
        return response()->download(storage_path($filePath));
    }
}
