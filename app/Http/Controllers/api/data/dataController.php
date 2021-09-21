<?php

namespace App\Http\Controllers\api\data;

use App\Http\Controllers\api\BaseController;
use App\Models\User;
use App\Models\Data;
use App\Models\Comment;
use Illuminate\Http\Request;

class dataController extends BaseController
{
    public function create(Request $request){
        $input = $request->all();
        $userId = User::getUserId($input['token']);
        $insertArray = [
            'userId' => $userId,
            'name' =>$input['name'],
            'text' => $input['text']           
        ];
        $create = Data::create($insertArray);
        if($create){
            return $this->sendResponse('Eklendi',[
                'id' => $create->id
            ]); 
        }else{
            return $this->sendError('ekleme başarısız');
        }

    }

    public function list($token){
        $userId = User::getUserId($token);
        $data = Data::where('userId',$userId)->get();
        return $this->sendResponse('Listendi',[
            'data' => $data
        ]); 
    }

    public function update(Request $request){
        $input = $request->all();
        $userId = User::getUserId($input['token']);
        $updatetArray = [           
            'name' =>$input['name'],
            'text' => $input['text']           
        ];
        $update = Data::where('id',$input['id'])->where('userId',$userId)->update($updatetArray);
        if($update){
            return $this->sendResponse('Veriler Güncellendi'); 
        }else{
            return $this->sendError('Veriler Güncellenemedi');
        }

    }

    public function delete(Request $request){
        $input = $request->all();
        $userId = User::getUserId($input['token']);
      
        $delete = Data::where('id',$input['id'])->where('userId',$userId)->delete();
        if($delete){
            return $this->sendResponse('Veri Silindi'); 
        }else{
            return $this->sendError('Veri Silinemedi');
        }

    }

    public function detail($token,$id){
        $userId = User::getUserId($token);
        $control = Data::where('userId',$userId)->where('id',$id)->count();
        if($control == 0){return $this->sendError('Auth Hatalı');}
        $data = Data::Where('id',$id)->first();
        $comments = Comment::where('dataId',$id)->get();
        return $this->sendResponse('detay',[
            'comments' => $comments,
            'data' => $data
        ]); 
    }


}

