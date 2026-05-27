<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function editMembership()
    {
        $setting = Setting::first();
        return view('settings.membership', compact('setting'));
    }

    public function updateMembership(Request $request)
    {
        $request->validate([
            'membership_fee'=>'required|numeric|min:0'
        ]);

        $setting = Setting::first();
        $setting->update(['membership_fee'=>$request->membership_fee]);

        return redirect()->route('settings.membership.edit')
                         ->with('success','Membership fee atualizado!');
    }
}
