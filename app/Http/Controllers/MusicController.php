<?php

namespace App\Http\Controllers;

use App\Music;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MusicController extends Controller
{
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'=>'required',
            'author'=>'required',
            'audio' => 'required|mimes:mpga'
        ]);
        $error = $validator->messages();
        if ($validator->fails()) {
            return $this->responseData($error, false);
        }
        $file = $request->file('audio');
        $file_name = rand(1000,9000)."_". rand(1000,9000).".".$file->getClientOriginalExtension();
        $destinationPath = 'music';
        $file->move($destinationPath, $file_name);
        $author = $request->author;
        $title = $request->title;
        $cover = 'default.png';
        $name = $file_name;
        $data=['author'=>$author,'title'=>$title,'name'=>$name,'cover'=>$cover];
        $music=Music::create($data);
        return $music;
    }

    public function list(Request $request)
    {
       $music=Music::latest()->get();
       return $this->responseData($music, true);
    }

    private function responseData($message, $status)
    {
        return response()->json(["success" => $status, "message" => $message], 200);
    }
}
