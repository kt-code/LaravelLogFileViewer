<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ViewerController extends Controller
{

    /**
     * Log file viewer
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'title' => 'Log File Viewer',
            'log_dir_path' => config('log.dir_path'),
            'log_default_file' => config('log.default_file'),
        ];
        return view('index', $data);
    }

    /**
     * Log file viewer's ajax response
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function log(Request $request)
    {
        //--Input from the request
        $path = $request->input('path', '');
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $contents = [];
        $data = [];

        try {

            //--Get the contents of the file
            $fullpath = config('log.dir_path') . ltrim($path, DIRECTORY_SEPARATOR);
            $mime = \File::mimeType($fullpath);
            $contents = \File::get($fullpath);
            $size = \File::size($fullpath);
            if (str_contains($mime, 'text') == false)
                $data[] = ['ERROR:', 'Invalid file type'];
            elseif ($size == 0)
                $data[] = ['ALERT:', 'File is empty'];
            else {
                $contents = explode(PHP_EOL, $contents);
                $lines = array_slice($contents, $start, $length);
                for ($i = 0; $i < count($lines); $i++) {
                    $line = $lines[$i];
                    if ($line)
                        // $line = wordwrap($lines[$i], 75, '<br>', true);
                        $data[] = [($start + $i + 1), $line];
                }
            }

        }
        catch (\Exception $e) {

            //--Error retrieving contents of the file
            $data[] = ['ERROR:', $e->getMessage()];
        }


        //--Ajax's JSON Response
        $resp = [
            "recordsTotal" => count($contents),
            "recordsFiltered" => count($contents),
            "data" => $data,
        ];
        return response()->json($resp);
    }
}
