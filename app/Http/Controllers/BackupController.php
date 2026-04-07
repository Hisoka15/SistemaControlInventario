<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class BackupController extends Controller
{
    public function index()
    {
        $backups = Backup::orderBy('created_at', 'desc')
            ->paginate(10);

        return view('backups.index', compact('backups'));
    }

    public function store()
    {
        $host = env('DB_HOST');
        $port = env('DB_PORT');
        $database = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $backupName = 'copia_de_seguridad_' . now('America/Managua')->format('Y-m-d_His') . '.sql';
        $backupPath = storage_path('app/backup/' . $backupName);
        $command = "mysqldump --no-tablespaces -h {$host} -P {$port} -u {$user} -p{$password} {$database} > {$backupPath}";
        exec($command);
        $backup = Backup::create([
            'name' => $backupName,
            'path' => $backupPath,
            'disk' => 'local',
            'size' => round(filesize($backupPath) / 1024 / 1024, 2)."MB",
            'type' => 'sql',
            'created_at' => now('America/Managua')->format('Y-m-d H:i:s'),
            'updated_at' => now('America/Managua')->format('Y-m-d H:i:s')
        ]);
        exec($command);
        $backup->save();

        Session::flash('message', 'Copia de seguridad generada correctamente');
        Session::flash('type', 'success');

        return redirect()->route('backups.index');
    }

    public function download($id)
    {
        $backup = Backup::find($id);
        return response()->download($backup->path);
    }

    public function restore(Backup $backup)
    {
        $host = env('DB_HOST');
        $port = env('DB_PORT');
        $database = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $password = env('DB_PASSWORD');

        $command = "mysql -h {$host} -P {$port} -u {$user} -p{$password} {$database} < {$backup->path}";

        exec($command);

        Session::flash('message', 'Copia de seguridad restaurada correctamente');
        Session::flash('type', 'success');

        return redirect()->route('login');
    }
}
