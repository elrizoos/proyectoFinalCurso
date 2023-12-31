<?php

namespace App\Http\Controllers;

use App\Mail\EmergencyCallReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\InvitationCode;
use Illuminate\Support\Facades\Mail;

class CodigoValidacionController extends Controller
{
    public function generateInvitationCode(Request $request)
    {
        $code = strtoupper(Str::random(8));
        $email = $request->input('email');
        InvitationCode::create([
            'code' => $code,
            'used' => false,
            'email' => $email,
        ]);


        $userEmail = $request->input('email');
        //dd($userEmail);
        $this->enviarCodigo($userEmail, $code);

        return $code;
    }

    public function enviarCodigo($userEmail, $code)
    {
        //dd($userEmail);
        Mail::to($userEmail)->send(new EmergencyCallReceived($code, $userEmail));
    }
}
