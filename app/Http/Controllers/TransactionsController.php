<?php

namespace App\Http\Controllers;

use App\transactions;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TransactionsController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index($id)
    {
        $user = \App\User::find($id);
        $transactions = \App\transactions::all();

        return view('/transactions', compact('user', 'transactions'));
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
    public function store($user_id)
    {
        $user = \App\User::find($user_id);

        function random_number()
        {

            $unique = "";
            while ($unique == "") {

                $id = Str::random(40);
                $validator = \Validator::make([ 'transaction_code' => $id], [ 'transaction_code' => 'unique:transactions']);

                if ($validator->fails()) {
                    return $unique = "";
                } else {
                    return $unique = $id;
                }
            }

            return $unique;
        };

        $id = random_number();

        $now = Carbon::today();
        $today = Carbon::parse($now)->format('Y-m-d');


        foreach($user->items as $item) {
            $transactions = new transactions;
            $serial = \App\serials::where('items_id', $item->id)->where('status','in cart')->first();
            $serial->status = 'for approval';



            $transactions->transaction_code = $id;

            $end  = Carbon::parse($item->pivot->duration);
            $duration = $end->diffInDays($today);

            $transactions->rent_date = $today;
            $transactions->name = $item->name;
            $transactions->serial_code = $serial->serial_code;
            $transactions->img_path = $item->img_path;
            $transactions->return_date = $item->pivot->duration;
            $transactions->duration = $duration;
            $transactions->price = $item->price;
            $transactions->status = 'pending';
            $transactions->items_id = $item->id;
            $transactions->users_id = $user_id;
            $transactions->save();
            $serial->save();


            $log = new \App\logs;
            $log->name = $item->name;
            $log->action = 'this has been barrowed and is for approval from the admin';
            $log->status = 'for approval';
            $log->user_id = $user_id;

            $log->save();
        }

        $item = \App\item_user::where('user_id', $user_id);
        $item->delete();


        return redirect()->back()->with('message', 'Items has been successfully added in transaction and waiting for approval from the admin!');
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\transactions  $transactions
    * @return \Illuminate\Http\Response
    */
    public function show(transactions $transactions)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\transactions  $transactions
    * @return \Illuminate\Http\Response
    */
    public function edit(transactions $transactions)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\transactions  $transactions
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, transactions $transactions)
    {
        //
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\transactions  $transactions
    * @return \Illuminate\Http\Response
    */
    public function destroy(transactions $transactions)
    {
        //
    }
}
