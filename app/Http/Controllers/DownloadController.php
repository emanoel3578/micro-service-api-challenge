<?php

namespace App\Http\Controllers;

use App\Http\Requests\DownloadRequest;
use App\Http\Services\DownloadService;
use Exception;

class DownloadController extends Controller
{
    protected DownloadService $service;

    public function __construct()
    {
        $this->service = new DownloadService();
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
            $validated = $request->validated();
            return response()->json($validated, 200);
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), $th->getCode());
        }
    }
}
