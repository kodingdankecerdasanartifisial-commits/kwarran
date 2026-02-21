<?php

namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     * Display a listing of the available downloads.
     */
    public function index()
    {
        $downloads = Download::where('is_active', true)->latest()->paginate(12);
        return view('downloads.index', compact('downloads'));
    }

    /**
     * Increment download count and return the file.
     */
    public function download($id)
    {
        $download = Download::findOrFail($id);

        if (!$download->is_active) {
            abort(404);
        }

        $download->increment('downloads_count');

        if ($download->external_url) {
            return redirect()->away($download->external_url);
        }

        if (!Storage::disk('public')->exists($download->file_path)) {
            abort(404, 'File not found');
        }

        return Storage::disk('public')->download($download->file_path);
    }
}
