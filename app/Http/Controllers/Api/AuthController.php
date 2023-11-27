<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\VerifyUserRequest;
use App\Models\User;
use App\static_data\AppStrings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Mail\TarwikaMail;
use Illuminate\Support\Facades\Mail;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\Mailer\Exception\TransportException;

class AuthController extends Controller
{
    private $path = 'images/users';
    private $disk = 'storage';

    public function register(RegisterUserRequest $request)
    {
        $imageName = 'no_image';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = $this->storeImage($file, $this->path, $this->disk);
        }
        $input = $request->validated();
        $input['image'] = $imageName;
        $verifyCode = $this->getRandomCode();
        $input['verify_code'] = $verifyCode;
        $user = User::create($input);
        $this->sendEmail($user->email, $user->verify_code);
        return $this->successResponse($user, AppStrings::success);
    }

    public function verify(VerifyUserRequest $request)
    {
        $email = $request->input('email');
        $code = $request->input('code');

        $user = User::where('email', $email)->first();

        if ($user === null) {
            return $this->notFoundResponse(AppStrings::failure);
        }

        if ($user->verify_code !== $code) {
            return $this->badRequestResponse(AppStrings::failure);
        }

        $user->email_verified_at = now();
        $user->save();
        $token = $user->createToken('auth_token')->plainTextToken;
        return $this->userWithToken($user, $token, AppStrings::success);
    }

    public function login(LoginUserRequest $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        // user not found
        if (!$user) {
            return $this->badRequestResponse('User not found');
        }

        // password not correct
        if (!Hash::check($request->input('password'), $user->password)) {
            return $this->badRequestResponse('Password not correct');
        }

        if ($user->email_verified_at === null) {
            $user->verify_code = $this->getRandomCode();
            $user->save();
            $this->sendEmail($user->email, $user->verify_code);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return $this->userWithToken($user, $token, AppStrings::success);
    }

    public function checkEmail(Request $request)
    {
        $email = $request->input('email');

        if (!$email) {
            return $this->badRequestResponse('email not sent');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return $this->badRequestResponse(AppStrings::failure);
        }

        $user->verify_code = $this->getRandomCode();
        $user->save();
        $this->sendEmail($user->email, $user->verify_code);
        return $this->successResponse($user, AppStrings::success);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $email = $request->input('email');
        $code = $request->input('code');
        $password = Hash::make($request->input('password'));

        $user = User::
        where('email', $email)
            ->where('verify_code', $code)
            ->first();
        if (!$user) {
            return $this->badRequestResponse(AppStrings::failure);
        }

        if ($user->email_verified_at === null) {
            $user->email_verified_at = now();
        }

        $user->password = $password;
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->userWithToken($user, $token, AppStrings::success);
    }

    public function profile()
    {
        return $this->successResponse(auth()->user(), AppStrings::success);
    }

    public function edit(UpdateUserRequest $request)
    {
        $user = auth()->user();
        $nameOldFile = $user->image;
        $input = $request->validated();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $input['image'] = $this->storeAndDeleteOldImage($file, $nameOldFile, $this->path, $this->disk);
        }
        $user->update($input);
        $token = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $token);
        return $this->userWithToken($user, $token, AppStrings::success);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->successResponse(null, 'Successfully logged out');
    }

    private function sendEmail($to, $content)
    {
        $email = [
            'address' => 'ahmadnourhaedr@gmail.com',
            'name' => 'Tarwika Admin',
            'to' => $to,
            'subject' => 'Verify Code',
            'content' => $content,
        ];
        try {
            Mail::send(new TarwikaMail($email));
        } catch (\Exception $e) {
        }
    }

    private function getRandomCode()
    {
        return rand(100000, 999999);
    }
}

