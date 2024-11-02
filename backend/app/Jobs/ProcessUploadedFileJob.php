<?php

/**
 * Job ProcessUploadedFileJob
 *
 * Se encarga de comprimir un archivo subido por el usuario
 * y de actualizar el mismo una vez finalice el proceso
 *
 * @author rosellpp <rpupopolanco@gmail.com>
 * @copyright 2024 Ing. Rosell Pupo Polanco
 */

namespace App\Jobs;

use App\Events\FileProcessedEvent;
use Exception;
use ZipArchive;
use App\Models\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\App;

class ProcessUploadedFileJob implements ShouldQueue
{
    use Queueable;

    /**
     * @var File $file Un archivo subido por el usuario
     */
    private File $file;

    /**
     * Create a new job instance.
     */
    public function __construct(File $file)
    {
        $this->file = $file;

        // El procesamiento se realiza en local, por lo que debo preguntar si el almacenamiento es s3
        // para en ese caso copiarlo en local
        if (config('filesystems.default') === "s3") {
            Storage::disk('local')->put(
                $this->file->path,
                Storage::disk('s3')->get($this->file->path)
            );
        }
    }

    /**
     * Comprime el archivo y lo almacena en el storage
     */
    private function zipFile()
    {  
        // Nombre del archivo ZIP
        $zipFileName = $this->file->name . ".zip";

        // Creamos una nueva instancia de ZipArchive  
        $zip = new ZipArchive();  

        // Path donde almacenaremos el zip
        $zipFilePath = Storage::disk("local")->path($zipFileName);

        // Abrimos el archivo para crearlo o sobreescribirlo si ya existe
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            // Agregamos el archivo al zip
            $filesToZip = [
                Storage::disk('local')->path($this->file->path),
            ];

            foreach ($filesToZip as $file) {  
                // Verificamos si el archivo existe antes de agregarlo
                if (file_exists($file)) {
                    $zip->addFile($file, basename($file)); // Agregamos el archivo al zip
                } else {
                    // El archivo no existe
                    throw new Exception(Lang::get("El archivo original se ha movido o eliminado"));
                }  
            }  

            // Cerramos el archivo ZIP
            $zip->close();

            // Ahora volvemos a verificar el almacenamiento para cargar el archivo zip generado
            if (config('filesystems.default') === "s3") {
                Storage::disk('s3')->put(
                    "zipped/$zipFileName",
                    fopen($zipFilePath, 'rb')
                );
            }

            $pathToRemove = $this->file->path;

            // Debemos actualizar la info del archivo
            $this->file->name = $zipFileName;
            $this->file->path = "zipped/$zipFileName";
            $this->file->size = Storage::disk("local")->size($zipFileName);
            $this->file->zipped_at = now();
            $this->file->save();

            // Ahora borramos los archivos locales
            Storage::disk('local')->delete([
                $pathToRemove,
                $zipFileName
            ]);

            // Lanzamos el evento para notificar al frontend
            FileProcessedEvent::dispatch($this->file);
        } else {  
            throw new Exception(Lang::get("No se ha podido crear el archivo zip"));
        }  
    }  

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        info("Comprimiendo archivo " . $this->file->name);

        // Ejecutamos la función que se encarga de comprimir el archivo
        $this->zipFile();
    }
}
