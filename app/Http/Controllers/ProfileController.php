<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $rules = ['password'=>'nullable|min:6'];
        if (!$user->isEmployee()) {
            $rules += [
                'name'                    =>'required|string|max:255',
                'gender'                  =>'required|in:M,F,Outro',
                'default_delivery_address'=>'nullable|string|max:255',
                'nif'                     =>'nullable|string|max:20',
                'default_payment_type'    =>'nullable|in:Visa,PayPal,MB WAY',
                'default_payment_reference'=>'nullable|string|max:255',
                'photo'                   =>'nullable|image|max:2048',
            ];
        }

        $data = $request->validate($rules);

        if ($request->hasFile('photo')) {
            // guarda em storage/app/public/users/XYZ.jpg
            $path = $request->photo->store('users', 'public');
            // só guarda "XYZ.jpg" no BD
            $data['photo'] = basename($path);
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->fill(collect($data)->except('password')->toArray());
        $user->save();

        return redirect()->route('profile.edit')
                         ->with('success','Perfil atualizado!');
    }
}
