<?php

namespace App\Http\Controllers\api\authenticate;

use App\Http\Controllers\api\BaseController;
use App\Models\User;
use Illuminate\Http\Request;

class authenticateController extends BaseController
{
    public function register(Request $request){
        $input = $request->all();
        $control = User::where('email',$input['email'])->count();
        if($control != 0) 
        {
            return $this->sendError('Bu email sistemde kayıtlı');
        }

        $token = uniqid();
        $insertArray = [
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => md5($input['password']),
            'token' => $token
        ];

        $create = User::Create($insertArray);        
        if($create){
            return $this->sendResponse('Kayıt tamamlandı',[
                'token' => $token
            ]);
        }else{
            return $this->sendError('Kayıt başarırısız');
        }
    }
    
    public function login(Request $request){
        $input = $request->all();
        $control = User::where('email',$input['email'])
        ->where('password',md5($input['password']))
        ->count();

        if($control == 0){
            return $this->sendError('Kullancı bilgileri hatalı');
            $data = User::where('email',$input['email'])
            ->where('password',md5($input['password']))
            ->first();

            return $this->sendResponse('kullanıcı giriş yaptı',[
                'token' =>$data->token
            ]);
        }
    }

}
