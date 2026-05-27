<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingCost;

class ShippingCostController extends Controller
{
    public function index()
    {
        $costs = ShippingCost::orderBy('min_value_threshold')->get();
        return view('settings.shipping.index',compact('costs'));
    }

    public function create()
    {
        return view('settings.shipping.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'min_value_threshold'=>'required|numeric|min:0',
            'max_value_threshold'=>'required|numeric|min:0',
            'shipping_cost'=>'required|numeric|min:0',
        ]);

        ShippingCost::create($request->only([
            'min_value_threshold','max_value_threshold','shipping_cost'
        ]));

        return redirect()->route('shipping-costs.index')
                         ->with('success','Custo de envio criado!');
    }

    public function edit(ShippingCost $shippingCost)
    {
        return view('settings.shipping.edit',compact('shippingCost'));
    }

    public function update(Request $request,ShippingCost $shippingCost)
    {
        $request->validate([
            'min_value_threshold'=>'required|numeric|min:0',
            'max_value_threshold'=>'required|numeric|min:0',
            'shipping_cost'=>'required|numeric|min:0',
        ]);

        $shippingCost->update($request->only([
            'min_value_threshold','max_value_threshold','shipping_cost'
        ]));

        return redirect()->route('shipping-costs.index')
                         ->with('success','Custo de envio atualizado!');
    }

    public function destroy(ShippingCost $shippingCost)
    {
        $shippingCost->delete();
        return redirect()->route('shipping-costs.index')
                         ->with('success','Custo de envio removido!');
    }
}
