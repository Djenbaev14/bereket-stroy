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
    // public function login(Request $request){
    //     $request->validate(['phone' => 'required|numeric']);

    //     // Foydalanuvchini qidirish yoki yaratish
    //     // $client = Client::firstOrCreate(['phone' => $request->phone]);
    //     $exists=Customer::where('phone','=',$request->phone)->exists();
    //     $verificationCode = 12345;
    //     if($exists){
    //         $client=Customer::where('phone','=',$request->phone)
    //         ->update([
    //             'verification_code' => $verificationCode, 
    //             'is_verified' => false,
    //             'verification_expires_at' => now()->addMinutes(3)]
    //         );
    //     }else{
    //         $client=Customer::create([
    //             'phone'=>$request->phone,
    //             'verification_code' => $verificationCode,
    //             'is_verified' => false,
    //             'verification_expires_at' => now()->addMinutes(3)
    //         ]);
    //     }

    //     // Tasdiqlash kodi generatsiyasi
    //     // $client->update(['verification_code' => $verificationCode, 'is_verified' => false,
    //     // 'verification_expires_at' => now()->addMinutes(3)]);

    //     return response()->json(['message' => 'Tasdiqlash kodi yuborildi.']);
    // }
    public function register(Request $request){
        // return Session::all();
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
                    Session::put('phone', $request->phone);
                    Session::put('verification_code', 12345);
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
            return response()->json(['message' => 'Tasdiqlash kodi yuborildi.','phone'=>$request->phone]);
        
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
    // public function verifyCode(Request $request) {
    //     $request->validate([
    //         'phone' => 'required|numeric',
    //         'code' => 'required|numeric'
    //     ]);
    
    //     // Foydalanuvchini topish
    //     $client = Customer::where('phone', $request->phone)->first();
    //     if (!$client || $client->verification_code != $request->code) {
    //         return response()->json(['message' => 'Noto‘g‘ri kod!'], 400);
    //     }
    //     if (now()->greaterThan($client->verification_expires_at)) {
    //         return response()->json(['message' => 'Kodning muddati tugagan!'], 400);
    //     }
    
    //     // Foydalanuvchini tasdiqlash
    //     $client->update([
    //         'status' => true, 
    //         'is_verified' => true, 
    //         'verification_code' => null,
    //         'verification_expires_at' => null]);
    //     $token = $client->createToken('auth_token')->plainTextToken;
    //     if ($client->status) {
    //         return response()->json([
    //             'message' => 'Foydalanuvchi muvaffaqiyatli tasdiqlandi.',
    //             'token' => $token,
    //             // 'redirect' => route('home') 
    //         ], 200);
    //     } else {
    //         return response()->json([
    //             'message' => 'Iltimos, ma\'lumotlaringizni to‘ldiring.',
    //             'token' => $token,
    //             // 'redirect' => route('profile.form') 
    //         ], 200);
    //     }
    
    //     // return response()->json([
    //     //     'message' => 'Foydalanuvchi tasdiqlandi.',
    //     //     'client' => $client,
    //     //     'token' => $token
    //     // ],200);
    // }

    // public function form(Request $request){
    //     $request->validate([
    //         'full_name' => 'required'
    //     ]);
    //     $client=auth()->user();
    //     $client->update([
    //         'full_name'=>$request->full_name
    //     ]);
    //     return redirect()->route('home')->with('success', 'Profil muvaffaqiyatli yaratildi.');



    // }
}
