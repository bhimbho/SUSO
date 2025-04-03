<?php

namespace App\Services;

use App\Models\Upload;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AnalysisService
{
    public function analyse(Upload $upload): void
    {
        $uploadedImages = $upload->uploadedImages();
        $uploadedImages = $upload->load('uploadedImages')->uploadedImages;
        $parts = [
            [
                'text' => "Analyze all images and provide insights about: 
                          1. Performance trends and metrics
                          2. Key observations and patterns  
                          Please format the response in numbers that is graphable.
                          provide a json object with the data."
            ]
        ];

        foreach ($uploadedImages as $image) {
            $parts[] = [
                'inline_data' => [
                    'mime_type' => 'image/jpeg',
                    'data' => base64_encode(file_get_contents(storage_path('app/public/' . $image->path)))
                ]
            ];
        }

        $response = Http::post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . config('services.gemini.api_key'), [
            'contents' => [
                [
                    'parts' => $parts
                ]
            ]
        ]);
        Log::info($response->json());
        if ($response->successful()) {
            $upload->update([
                'llm_response' => $response->json(),
                'analysed_at' => now(),
                'status' => 'completed'
            ]);
        }
    }
} 