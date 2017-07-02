<?php

namespace App\Http\Controllers\Log;

use App\Exceptions\LogReaderException;
use App\Http\Controllers\Controller;
use App\Traits\LogReader;
use Illuminate\Http\Request;

/**
 * TODO: Separate log reading logic from ViewerController.php to a separate helper/service class.
 * TODO: Cover the newly created helper/service class with PHPUnit tests. Develop unit tests (not feature tests) as described in here: https:/  /laravel.com/docs/5.4/
 * TODO: Run code coverage report to ensure the newly created class is 100% covered by unit tests.
 */
class ViewerController extends Controller
{

    use LogReader;

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
            //--Get contents of the file
            $contents = $this->getContents($path);

            //--Generate line's content
            $lines = $this->getLines($contents, $start, $length);
        }
        catch (\Exception $e) {

            //--Fail to retrieving contents of the file
            $error = $e instanceof LogReaderException ? 'ALERT' : 'ERROR';
            $lines[] = ["$error:", $e->getMessage()];
        }

        //--Ajax's JSON Response
        $resp = [
            "recordsTotal" => count($contents),
            "recordsFiltered" => count($contents),
            "data" => $lines,
        ];
        return response()->json($resp);
    }

}
