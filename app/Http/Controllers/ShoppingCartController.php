<?php

namespace App\Http\Controllers;

use App\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShoppingCartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = \App\ShoppingCart::where('user_id', Auth::user()->id)->get();

        //dd($items);
        return view('shoppingcart.index')->with('items', $items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shoppingcart.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        #Find the correct price
        if (empty(session('selected_currency'))) {
            $price = \App\Price::where('product_id', $request->product_id)
                ->orderBy('id', 'asc')
                ->first();
        } else {
            $price = \App\Price::where([
                ['product_id', $request->product_id],
                ['currency_id', session('selected_currency')]
            ])
                ->orderBy('id', 'asc')
                ->first();
        }

        #Check if product already exists in the shopping cart
        $item = \App\ShoppingCart::where([
            ['user_id', Auth::id()],
            ['product_id', $request->product_id]
        ])->first();

        if (empty($item)) {
            $shoppingCart = ShoppingCart::create([
                'currency_id' => $price->currency_id,
                'product_id' => $request->product_id,
                'user_id' => Auth::id(),
                'quantity' => 1,
                'price' => $price->price,
                'total' => $price->price
            ]);

            $shoppingCart->save();
        } else {
            $item->quantity = $item->quantity + 1;
            $item->total = $item->quantity * $item->price;
            $item->save();
        }

        return redirect(route('shoppingcart.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $slug = '')
    {
        $this->destroy($id);
        return redirect(route('shoppingcart.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        dd($id);

        $shoppingCart = Widget::findOrFail($id);

        if (!$this->adminOrCurrentUserOwns($shoppingCart)) {

            throw new UnauthorizedException;

        }

        return view('shoppingcart.edit', compact('widget'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        dd($id);

        $this->validate($request, [
            'name' => 'required|string|max:40|unique:widgets,name,' . $id

        ]);

        $shoppingCart = Widget::findOrFail($id);

        if (!$this->adminOrCurrentUserOwns($shoppingCart)) {
            throw new UnauthorizedException;
        }

        $slug = str_slug($request->name, "-");

        $shoppingCart->update(['name' => $request->name,
            'slug' => $slug,
            'user_id' => Auth::id()]);

        alert()->success('Congrats!', 'You updated a widget');

        return Redirect::route('shoppingcart.show', ['widget' => $shoppingCart, 'slug' => $slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ShoppingCart::destroy($id);
        return redirect(route('shoppingcart.index'));
    }

    public function buy()
    {
        $items = \App\ShoppingCart::where('user_id', Auth::user()->id)->get();

        foreach ($items as $item) {
            $item->destroy($item->id);
        }

        return view('shoppingcart.final');
    }
}
