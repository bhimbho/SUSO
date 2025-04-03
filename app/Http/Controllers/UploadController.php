<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Jobs\AnalyseUploadJob;
use App\Jobs\UploadJob;
use App\Models\Upload;
use App\Models\UploadedImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
{
    public function index()
    {
        $uploads = Upload::with('uploadedImages')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
            
        return view('index-upload', compact('uploads'));
    }

    public function show(Upload $upload)
    {
        $analysis = $upload->llm_response;
        
        if (!$analysis) {
            return back()->with('error', 'Analysis data not available yet. Please try again later.');
        }

        return view('show-upload', compact('upload', 'analysis'));
    }

    public function create()
    {
        return view('upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'file|mimes:jpg,jpeg,png,gif,pdf,doc,docx|max:2048'
        ]);

        try {
            DB::beginTransaction();

            $upload = Upload::create([
                'user_id' => Auth::id(),
            ]);

            foreach ($request->file('files') as $file) {
                $path = $file->store('uploads', 'public');
                UploadedImage::create([
                    'upload_id' => $upload->id,
                    'path' => $path,
                ]);
            }

            AnalyseUploadJob::dispatch($upload);

            DB::commit();
        

            return redirect()->route('upload.index')->with('success', 'Files are being processed. We will notify you when the analysis is complete.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Upload failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to upload files. Please try again.');
        }
    }
}
