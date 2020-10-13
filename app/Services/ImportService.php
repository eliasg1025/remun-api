<?php

namespace App\Services;

use App\Repositories\ImportableRepository;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;

class ImportService
{
    public ImportableRepository $repository;


    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function execute(UploadedFile $uploadedFile)
    {
        $relativePath = '/uploads/tmp/' . now()->unix() . '.' . $uploadedFile->getClientOriginalExtension();
        if (!Storage::disk('public')->put($relativePath, \File::get($uploadedFile)))
        {
            return [
                'message' => 'Error al importar',
                'error' => 'Error al subir el archivo .csv'
            ];
        }

        try {
            (new FastExcel)->import(
                storage_path('app/public') . $relativePath,
                function ($line)
                {
                    return $this->repository->update($line, $line['id']);
                }
            );

            return [
                'message' => 'Importación completada existosamente'
            ];
        } catch (Exception $e) {
            return [
                'message' => 'Error al importar',
                'error'   => $e->getMessage()
            ];
        }
    }
}
