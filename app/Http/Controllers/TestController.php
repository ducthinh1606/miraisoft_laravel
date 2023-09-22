<?php

namespace App\Http\Controllers;

use App\Http\Requests\Test2Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TestController extends Controller
{
    public function test3()
    {
        $folderOne = 'D:\Test\one';
        $folderTwo = 'D:\Test\two';

        $filesOne = File::allFiles($folderOne);
        $filesTwo = File::allFiles($folderTwo);

        $fileNamesOne = array_map('basename', $filesOne);
        $fileNamesTwo = array_map('basename', $filesTwo);

        return array_values(array_intersect($fileNamesOne, $fileNamesTwo));
    }

    public function test2(Test2Request $request)
    {
        $rootPath = 'D:\Test\Test2';

        $requestFile = $request->file('file');

        $appEnvPath = $this->getAppEnv($request->app_env);
        $contractServer = $this->getContractServer($request->contract_server);

        $path = $rootPath . $appEnvPath . $contractServer;

        $matchingFile = null;

        if (is_dir($path)) {
            if ($handle = opendir($path)) {
                while (false !== ($file = readdir($handle))) {
                    if ($file == $requestFile->getClientOriginalName()) {
                        $matchingFile = $file;
                        break;
                    }
                }
                closedir($handle);
            }
        }

        if ($matchingFile !== null) {
            $filePath = $path . "/" . $matchingFile;
            $htmlContent = File::get($filePath);
            $base64Content = base64_encode($htmlContent);

            $response = [
                'success' => true,
                'filename' => $matchingFile,
                'content' => $base64Content,
                'message' => 'Seal Info response successfully',
            ];

            return response()->json($response, 200);
        } else {
            $response = [
                'success' => false,
                'filename' => '',
                'message' => 'Seal Info response false',
            ];

            return response()->json($response, 200);
        }
    }

    private function getAppEnv($appEnv)
    {
        return match ($appEnv) {
            '0' => '\AWS',
            '1' => '\K5',
            '2' => '\T2',
        };
    }

    private function getContractServer($contractServer)
    {
        return match ($contractServer) {
            '0' => '\app1',
            '1' => '\app2',
        };
    }
}
