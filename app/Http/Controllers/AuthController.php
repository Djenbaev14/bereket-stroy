<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request){
        if($request->has('is_legal') && $request->is_legal ==0){
            $request->validate([
                'phone' => 'required|numeric',
            ]);
            $customer = Customer::where('phone', $request->phone)->first();
            if(!$customer){
                return response()->json(['message' => 'Telefon nomer noto‘g‘ri!'], 401);
            }
        }
        else if($request->has('is_legal') && $request->is_legal ==1){
            $request->validate([
                'phone' => 'required|numeric',
                'inn' => 'required|numeric',
            ]);
            
            $customer = Customer::where('phone', $request->phone)->where('inn', $request->inn)->first();
            if(!$customer){
                return response()->json(['message' => 'Telefon nomer yoki inn noto‘g‘ri!'], 401);
            }
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
                // $url = "notify.eskiz.uz/api/message/sms/send";
                // $ran=random_int(10000,99999);
                // $resposnse = Http::withHeaders([
                //     'Authorization' => 'Bearer ' . $auth['data']['token'],
                //     ])->post($url, [
                //         'mobile_phone' => '998'.$request->phone,
                //         "message" => "bereket-stroy.uz saytına kiriw ushın tastıyıqlaw kodı:".' '.$ran,
                //     ]);
                    
                // $resposnse = $resposnse->json();
                $ran=12345;
                Session::put('phone', $request->phone); 
                Session::put('verification_code', $ran);
                Session::put('expiresAt', date('m-d-Y H:i:s', $five_minutes));
            }

        return response()->json(['message' => 'success','phone'=>$request->phone]);
    }
    public function register(Request $request){
        if($request->has('is_legal') && $request->is_legal ==0){
            $request->validate([
                'phone' => 'required|numeric|unique:customers,phone,' . $request->phone,
                'name' => 'required',
            ]);
        }else{
            $request->validate([
                'phone' => 'required|numeric|unique:customers,phone,' . $request->phone,
                'name' => 'required',
                'company_name' => 'required',
                'inn' => 'required|unique:customers,inn,' . $request->inn,
            ]);
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
                // $url = "notify.eskiz.uz/api/message/sms/send";
                // $ran=random_int(10000,99999);
                // $resposnse = Http::withHeaders([
                //     'Authorization' => 'Bearer ' . $auth['data']['token'],
                //     ])->post($url, [
                //         'mobile_phone' => '998'.$request->phone,
                //         "message" => "bereket-stroy.uz saytına kiriw ushın tastıyıqlaw kodı:".' '.$ran,
                //     ]);
                    
                // $resposnse = $resposnse->json();
                $ran=12345;
                Session::put('phone', $request->phone); 
                Session::put('verification_code', $ran);
                Session::put('expiresAt', date('m-d-Y H:i:s', $five_minutes));

                
                if($request->has('is_legal') && $request->is_legal ==0){
                    Customer::create( [
                        'first_name'=>$request->name,
                        'phone'=>$request->phone,
                        'is_verified'=>false,
                    ]);
                }else{
                    Customer::create(  [
                        'first_name'=>$request->name,
                        'phone'=>$request->phone,
                        'company_name'=>$request->company_name,
                        'inn'=>$request->inn,
                        'is_verified'=>false,
                    ]);
                }
            }

        return response()->json(['message' => 'success','phone'=>$request->phone]);
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
                    return response()->json(['message' => 'Tasdiqlash kodi xato.']);
                }
            }else{
                return response()->json(['message' => 'Tasdiqlash kodining vaqti tugadi.']);
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
                    return response()->json(['message' => 'Tasdiqlash kodi xato.']);
                }
            }else{
                return response()->json(['message' => 'Tasdiqlash kodining vaqti tugadi.']);
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
