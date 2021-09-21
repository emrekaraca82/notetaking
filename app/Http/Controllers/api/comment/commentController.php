<?php

namespace App\Http\Controllers\api\comment;

use App\Http\Controllers\api\BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comment;

class commentController extends Controller
{
    public function create(Request $request){
        $input = $request->all();
        $userId = User::getUserId($input['token']);
        $insertArray = [
            'userId' => $userId,
            'dataId' =>$input['dataId'],
            'text' => $input['text']           
        ];
        $create = Comment::create($insertArray);
        if($create){
            return $this->sendResponse('Yorum Eklendi'); 
        }else{
            return $this->sendError('Yorum Eklenemedi');
        }

    }

    public function update(Request $request){
        $input = $request->all();
        $userId = User::getUserId($input['token']);
        $updatetArray = [           
            'name' =>$input['name'],
            'text' => $input['text']           
        ];

        $update = Comment::where('id',$input['id'])
        ->where('userId',$userId)
        ->update($updatetArray);

        if($update){
            return $this->sendResponse('Veriler Güncellendi'); 
        }else{
            return $this->sendError('Veriler Güncellenemedi');
        }

    }

    public function delete(Request $request){
        $input = $request->all();
        $userId = User::getUserId($input['token']);
      
        $delete = Comment::where('id',$input['id'])
        ->where('userId',$userId)
        ->delete();
        
        if($delete){
            return $this->sendResponse('Veri Silindi'); 
        }else{
            return $this->sendError('Veri Silinemedi');
        }

    }
}
