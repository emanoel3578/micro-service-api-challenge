<?php

namespace App\Http\Controllers;

use App\Exports\DownloadExport;
use App\Http\Repository\ReportRepository;
use App\Http\Requests\DownloadRequest;
use App\Http\Services\DownloadService;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class DownloadController extends Controller
{
    protected DownloadService $service;

    function __construct()
    {
        $repository = new ReportRepository();
        $this->service = new DownloadService($repository);
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Http\Requests\DownloadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(DownloadRequest $request)
    {
        try {
            $validatedParams = $request->validated();
            $reportData = $this->service->getReportData($validatedParams);
            return Excel::download(new DownloadExport($reportData), 'downloads.xlsx');
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), $th->getCode());
        }
    }
}
