<?php

namespace App\Http\Controllers;

use App\item_user;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ItemUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = \App\User::find($id);

        return view('/cart', compact('user'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $user_id, $item_id)
    {
        $cart = new \App\item_user;

        $cart->items_id = $item_id;
        $cart->user_id = $user_id;
        $cart->duration = $request->duration;
        $cart->save();

        $serial = \App\serials::where('items_id', $item_id)->where('status', 'available')->first();
        $serial->status = 'in cart';
        $serial->save();


        $item = \App\items::find($item_id);

        $log = new \App\logs;
        $log->name = $item->name;
        $log->action = 'has been added to the cart';
        $log->status = 'in cart';
        $log->user_id = $user_id;

        $log->save();


        return redirect('/catalog');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\item_user  $item_user
     * @return \Illuminate\Http\Response
     */
    public function show(item_user $item_user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\item_user  $item_user
     * @return \Illuminate\Http\Response
     */
    public function edit(item_user $item_user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\item_user  $item_user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $date = \App\item_user::where('items_id', $id)->first();

        $date->duration = $request->date;
        $date->save();

        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\item_user  $item_user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = \App\item_user::where('items_id', $id)->first();
        $item->delete();

        return back();
    }
}
