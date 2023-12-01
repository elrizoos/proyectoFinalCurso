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
        $userType = $request->input("userType");
        InvitationCode::create([
            'code' => $code,
            'used' => false,
            'role' => $userType,
            'email' => $email,
        ]);

        // Obtén el correo electrónico del usuario de alguna manera, por ejemplo, desde un formulario
        $userEmail = $request->input('email');
        //dd($userEmail);
        $this->enviarCodigo($userEmail, $code, $userType);

        return $code;
    }

    public function enviarCodigo($userEmail, $code, $userType)
    {
        //dd($userEmail);
        Mail::to($userEmail)->send(new EmergencyCallReceived($code, $userEmail));
    }
}
