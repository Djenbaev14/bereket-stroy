<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
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
        if(Cache::has('device_' . $request->ip())){
            $remainingTime = Cache::get('expiresAt_'.'_device'.$request->ip())->diffInSeconds(now());
            return response()->json([
                'message'=>[
                    'uz' => "Siz allaqachon kod oldingiz. Qayta so‘rash uchun $remainingTime soniya kuting.",
                    'ru'=>"Вы уже получили код. Пожалуйста, подождите $remainingTime секунд, чтобы запросить ещё раз.",
                    'en'=>"You have already received the code. Wait $remainingTime seconds to request again.",
                    'qr'=>"Siz álleqashan kod aldıńız. Qayta soraw ushin $remainingTime sekund kútiń."
                ]
            ],429);
        }else{
            $customer = Customer::withTrashed()->where('phone', $request->phone)->where('is_verified', true)->first();
            if ($customer) {
                if ($customer->trashed()) {
                    $customer->restore(); // deleted_at ni null qilib qaytarish
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
                        Cache::put('phone_'.$request->phone, $request->phone, now()->addMinutes(2));
                        Cache::put('verification_code_'.$request->phone, $ran, now()->addMinutes(2));
                        // Cache::put('expiresAt_'.$request->phone, now()->addMinutes(2),now()->addMinutes(2));
                        Cache::put('expiresAt_'.'_device'.$request->ip(), now()->addMinutes(2),now()->addMinutes(2));
                        Cache::put('device_' . $request->ip(), true, now()->addMinutes(2)); // Qurilma uchun cheklov
                    }
            }else{
                return response()->json(['error' => 'Foydalanuvchi topilmadi'], 404);
            }
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
        
        if(Cache::has('device_' . $request->ip())){
            $remainingTime = Cache::get('expiresAt_'.'_device'.$request->ip())->diffInSeconds(now());
            return response()->json([
                'message'=>[
                    'uz' => "Siz allaqachon kod oldingiz. Qayta so‘rash uchun $remainingTime soniya kuting.",
                    'ru'=>"Вы уже получили код. Пожалуйста, подождите $remainingTime секунд, чтобы запросить ещё раз.",
                    'en'=>"You have already received the code. Wait $remainingTime seconds to request again.",
                    'qr'=>"Siz álleqashan kod aldıńız. Qayta soraw ushin $remainingTime sekund kútiń."
                ]
            ],429);
        }else{
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

                Cache::put('phone_'.$request->phone, $request->phone, now()->addMinutes(2));
                Cache::put('verification_code_'.$request->phone, $ran, now()->addMinutes(2));
                // Cache::put('expiresAt_'.$request->phone, now()->addMinutes(2),now()->addMinutes(2));
                Cache::put('expiresAt_'.'_device'.$request->ip(), now()->addMinutes(2),now()->addMinutes(2));
                Cache::put('device_' . $request->ip(), true, now()->addMinutes(2)); // Qurilma uchun cheklov
                
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
        }
// ,'phone_cache'=>Cache::get('phone_'.$request->phone),'time_cache'=>Cache::get('expiresAt_'.$request->phone),'code_cache'=>Cache::get('verification_code_'.$request->phone)
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
            if(Cache::has('expiresAt_'.'_device'.$request->ip()) &&  date('m-d-Y H:i:s', $now) <= Cache::get('expiresAt_'.'_device'.$request->ip())){
                if(Cache::has('verification_code_'.$request->phone) && $request->code == Cache::get('verification_code_'.$request->phone) && $request->phone == Cache::get('phone_'.$request->phone) )    {
                    $customer=Customer::where('phone', $request->phone)->first();
                    if (!$customer) {
                        return response()->json(['error' => 'Foydalanuvchi topilmadi'], 404);
                    }
                    $token = $customer->createToken('auth_token')->plainTextToken;

                    Cache::forget('verification_code_'.$request->phone);
                    Cache::forget('expiresAt_'.'_device'.$request->ip());
                    Cache::forget('phone_'.$request->phone);
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
            if(Cache::has('expiresAt_'.'_device'.$request->ip()) &&  date('m-d-Y H:i:s', $now) <= Cache::get('expiresAt_'.'_device'.$request->ip())){
                if(Cache::has('verification_code_'.$request->phone) && $request->code == Cache::get('verification_code_'.$request->phone) && $request->phone == Cache::get('phone_'.$request->phone))    {
                    $customer=Customer::where('phone', $request->phone)->first();
                    if (!$customer) {
                        return response()->json(['error' => 'Foydalanuvchi topilmadi'], 404);
                    }
                    $customer->update(['is_verified'=>true]);
                    $token = $customer->createToken('auth_token')->plainTextToken;

                    Cache::forget('verification_code_'.$request->phone);
                    Cache::forget('expiresAt_'.'_device'.$request->ip());
                    Cache::forget('phone_'.$request->phone);
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
