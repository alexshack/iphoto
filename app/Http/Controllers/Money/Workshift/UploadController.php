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
        $folder = $this->folder;
        if ($request->get('workshiftID')) {
            $workshiftID = $request->get('workshiftID');
            $folder .= "/$workshiftID";
        }
        $path = $request->image->store($folder);
        $name = asset(str_replace('public', 'storage', $path));
        return response()->json(compact('name'));

    }

    public function destroy(Request $request, $fileName) {
        return [
            'result' => Storage::delete("{$this->folder}/$fileName"),
        ];
    }
}
