<?php

namespace App\Http\Controllers;

use App\serials;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class SerialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    { }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($item_id)
    {
        $serial = new serials;

        function random_number()
        {

            $unique = "";
            while ($unique == "") {

                $id = Str::random(40);
                $validator = \Validator::make(['serial_code' => $id], [ 'serial_code' => 'unique:serials']);

                if ($validator->fails()) {
                    return $unique = "";
                } else {
                    return $unique = $id;
                }
            }

            return $unique;
        };

        $id = random_number();


        $serial->serial_code = $id;
        $serial->status = "available";
        $serial->items_id = $item_id;

        $serial->save();

        return back()->with('modal', 'true');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\serials  $serials
     * @return \Illuminate\Http\Response
     */
    public function show(serials $serials)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\serials  $serials
     * @return \Illuminate\Http\Response
     */
    public function edit(serials $serials)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\serials  $serials
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, serials $serials)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\serials  $serials
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $serial = \App\serials::find($id);
        $serial->delete();

        return redirect('/items');
    }
}
