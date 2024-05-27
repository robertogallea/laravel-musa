<?php

namespace App\Services;

class FileExportService implements ExportingServiceInterface
{

    public function export()
    {
        dd('exporting using filesystem');
    }
}
