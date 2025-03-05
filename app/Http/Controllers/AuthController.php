<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request){
        $rules = [
            'phone' => ['required', 'numeric', Rule::exists('customers', 'phone')->where(fn ($query) => $query->where('is_verified', true))],
        ];
        
        if ($request->has('is_legal') && $request->is_legal == 1) {
            $rules['inn'] = 'required|exists:customers,inn';
        }
        
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $customer = Customer::where('phone', $request->phone)->where('is_verified', true)->exists();

        if ($customer) {
            
        $now = time();
        $five_minutes = $now + (5 * 60);
        if(Session::has('expiresAt')){
                Session::forget('verification_code');
                Session::forget('expiresAt');
        }
            $url_login = "notify.eskiz.uz/api/auth/login";
        
            $auth = Http::post($url_login, [
                'email' => 'santexglobalnukus@gmail.com',
                'password' => 'rnbyQKHGOH6DQV05lNzqh32Itym9M2SKEUUuCtCH',
            ]);
            $auth = $auth->json();
            if ($auth['message'] == 'token_generated') {
                $url = "notify.eskiz.uz/api/message/sms/send";
                $ran=random_int(10000,99999);
                $resposnse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $auth['data']['token'],
                    ])->post($url, [
                        'mobile_phone' => '998'.$request->phone,
                        "message" => "bereket-stroy.uz saytına kiriw ushın tastıyıqlaw kodı:".' '.$ran,
                    ]);
                    
                $resposnse = $resposnse->json();
                Session::put('phone', $request->phone); 
                Session::put('verification_code', $ran);
                Session::put('expiresAt', date('m-d-Y H:i:s', $five_minutes));
            }
        }else{
            return response()->json(['error' => 'Foydalanuvchi topilmadi'], 404);
        }

        return response()->json(['message' => 'Tasdiqlash kodi yuborildi','resposnse'=>$resposnse,'phone'=>$request->phone],200);
    }
    public function register(Request $request){
        $rules = [
            'phone' => ['required', 'numeric', Rule::unique('customers', 'phone')->where(fn ($query) => $query->where('is_verified', true))],
            'name' => 'required',
            'is_legal' => 'required|boolean',
        ];
        if ($request->has('is_legal') && $request->is_legal == 1) {
            $rules['company_name'] = 'required';
            $rules['inn'] = 'required|unique:customers,inn,' . $request->inn;
        }
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $now = time();
        $five_minutes = $now + (5 * 60);
        if(Session::has('expiresAt')){
                Session::forget('verification_code');
                Session::forget('expiresAt');
        }
            $url_login = "notify.eskiz.uz/api/auth/login";
        
            $auth = Http::post($url_login, [
                'email' => 'santexglobalnukus@gmail.com',
                'password' => 'rnbyQKHGOH6DQV05lNzqh32Itym9M2SKEUUuCtCH',
            ]);
            $auth = $auth->json();
            if ($auth['message'] == 'token_generated') {
                $url = "notify.eskiz.uz/api/message/sms/send";
                $ran=random_int(10000,99999);
                $resposnse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $auth['data']['token'],
                    ])->post($url, [
                        'mobile_phone' => '998'.$request->phone,
                        "message" => "bereket-stroy.uz saytına kiriw ushın tastıyıqlaw kodı:".' '.$ran,
                    ]);
                    
                $resposnse = $resposnse->json();
                Session::put('phone', $request->phone); 
                Session::put('verification_code', $ran);
                Session::put('expiresAt', date('m-d-Y H:i:s', $five_minutes));

                
                $customer = Customer::updateOrCreate(
                    ['phone' => $request->phone, 'is_verified' => false],
                    [
                        'is_legal' => $request->is_legal,
                        'company_name' => $request->company_name ?? null,
                        'inn' => $request->inn ?? null,
                        'first_name' => $request->name ?? null,
                    ]
                );
                
            }

        return response()->json(['message' => 'Tasdiqlash kodi yuborildi','response'=>$resposnse,'phone'=>$request->phone],200);
    }
    public static function loginVerifyCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric',
            'code' => 'required|numeric'
        ]);
        DB::beginTransaction();
        try {
            $now = time();
            if(Session::has('expiresAt') &&  date('m-d-Y H:i:s', $now) <= session()->get('expiresAt')){
                if(Session::has('verification_code') && $request->code == session('verification_code') && $request->phone == session('phone'))    {
                    $customer=Customer::where('phone', $request->phone)->first();
                    if (!$customer) {
                        return response()->json(['error' => 'Foydalanuvchi topilmadi'], 404);
                    }
                    $token = $customer->createToken('auth_token')->plainTextToken;

                    Session::forget('verification_code');
                    Session::forget('expiresAt');
                    Session::forget('phone');
                    DB::commit();
                }else{
                    return response()->json(['message' => 'Tasdiqlash kodi xato.'],422);
                }
            }else{
                return response()->json(['message' => 'Tasdiqlash kodining vaqti tugadi.'],422);
            }
        }
        catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => 'xato.'],422);
        }
            
        return response()->json([
                'message' => 'Foydalanuvchi tasdiqlandi.',
                'customer' => $customer,
                'token' => $token
            ],200);
    }
    public static function registerVerifyCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric',
            'code' => 'required|numeric'
        ]);
        DB::beginTransaction();
        try {
            $now = time();
            if(Session::has('expiresAt') &&  date('m-d-Y H:i:s', $now) <= session()->get('expiresAt')){
                if(Session::has('verification_code') && $request->code == session('verification_code') && $request->phone == session('phone'))    {
                    $customer=Customer::where('phone', $request->phone)->first();
                    if (!$customer) {
                        return response()->json(['error' => 'Foydalanuvchi topilmadi'], 404);
                    }
                    $customer->update(['is_verified'=>true]);
                    $token = $customer->createToken('auth_token')->plainTextToken;

                    Session::forget('verification_code');
                    Session::forget('expiresAt');
                    Session::forget('phone');
                    DB::commit();
                }else{
                    return response()->json(['message' => 'Tasdiqlash kodi xato.'],422);
                }
            }else{
                return response()->json(['message' => 'Tasdiqlash kodining vaqti tugadi.'],422);
            }
        }
        catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => 'xato.']);
        }
            return response()->json([
                'message' => 'Foydalanuvchi tasdiqlandi.',
                'customer' => $customer,
                'token' => $token
            ],200);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successful',
        ], 200);
    }
}
