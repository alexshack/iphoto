<?php

namespace App\Http\Controllers\Money\Workshift;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

class UploadController extends Controller
{
    private $folder;

    public function __construct() {
        $this->folder = 'public/check-files';
    }
    public function upload(Request $request) {
        $path = $request->fileName->store($this->folder);
        $url = asset(str_replace('public', 'storage', $path));
        return response()->json([
            'url' => $url,
            'size' => Storage::size($path),
            'path' => $path,
        ]);

    }

    public function destroy(Request $request, $fileName) {
        return [
            'result' => Storage::delete("{$this->folder}/$fileName"),
        ];
    }
}
