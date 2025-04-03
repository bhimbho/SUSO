<?php

namespace App\Jobs;

use App\Models\Upload;
use App\Services\AnalysisService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AnalyseUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private Upload $upload)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(AnalysisService $analysisService): void
    {
        $analysisService->analyse($this->upload); 
    }
}
