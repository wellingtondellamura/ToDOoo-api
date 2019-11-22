<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserChangePasswordRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class UserController extends Controller
{
    use SendsPasswordResetEmails;


    public function login(UserLoginRequest $request)
    {
        $data = $request->validated();
        if (!Auth::attempt($data))
        {
            return $this->sendError("Usuário ou senha incorretos");
        }
        $user = Auth::user();
        $user->accessToken = $user->createToken('authToken')->accessToken;
        return $this->sendMessage("Usuário autenticado com sucesso", $user);
    }

    public function register(UserStoreRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        if ($user) {
            $user->accessToken = $user->createToken('authToken')->accessToken;
            return $this->sendMessage("Usuário cadastrado com sucesso", $user);
        }
        return $this->sendError("Erro ao cadastrar usuário");
    }

    public function logout()
    {
        $user = Auth::user();
        $userTokens = $user->tokens;
        foreach($userTokens as $token) {
            $token->revoke();
        }
        return  $this->sendMessage("Logout realizado com sucesso");
    }

    public function changePassword(UserChangePasswordRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        if (!(Hash::check($data['old_password'], $user->password))) {
            return $this->sendError("Senha incorreta");
        }

        $user->password = bcrypt($data['new_password']);
        $user->save();
        return $this->sendMessage("Senha alterada com sucesso");
    }

    public function forgotPassword(Request $request)
    {

    }

    public function update(UserUpdateRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        $success = $user->update($data);
        if ($success){
            return $this->sendMessage("Usuário alterado com sucesso");
        }
        return $this->sendError("Erro ao atualizar dados do usuário");
    }
}
