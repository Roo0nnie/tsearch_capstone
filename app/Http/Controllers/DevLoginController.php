<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DevLoginController extends Controller
{
    public function login(Request $request, string $role)
    {
        abort_unless(app()->environment('local'), 404);

        $config = config("dev-login.roles.{$role}");

        abort_unless($config, 404);

        $user = $config['model']::where('email', $config['email'])->firstOrFail();

        Auth::guard($config['guard'])->login($user);
        $request->session()->regenerate();

        if (isset($config['status_field'], $config['status_value'])) {
            $user->update([$config['status_field'] => $config['status_value']]);
        }

        if ($config['guard'] === 'admin') {
            $user->update([
                'verification_code' => null,
                'verification_code_expires_at' => null,
            ]);
        }

        if ($config['guard'] === 'superadmin') {
            $user->update([
                'verification_code' => null,
                'verification_code_expires_at' => null,
            ]);
        }

        return redirect()->route($config['redirect']);
    }
}
