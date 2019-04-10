<?php

namespace App\Http\Controllers;

use App\items;
use Illuminate\Http\Request;
use Input;
use Illuminate\Support\Str;


class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = \App\items::all();
        $serials = \App\serials::all();
        return view('/items', compact('items', 'serials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    { {
            $request->validate(
                [
                    'image' => 'required',
                    'name' => 'required|unique:items',
                    'price' => 'required',
                    'description' => 'required|max:191',
                    'category' => 'required'
                ]
            );
        }

        $item = new \App\items;
        $serial = new \App\serials;

        function random_number()
        {

            $unique = '';
            while ($unique == '') {

                $id = Str::random(40);
                $validator = \Validator::make(['serial_code' => $id], [ 'serial_code' => 'unique:serials']);

                if ($validator->fails()) {
                    $unique = '';
                } else {
                    $unique = $id;
                }
            }

            return $unique;
        };

        $id = random_number();

        $file = $request->file('image');
        $item->name = $request->name;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->category = $request->category;
        $item->serial_code = $id;

        $item->img_path = $file->getClientOriginalName();
        $file->move('images/games', $file->getClientOriginalName());

        $item->save();



        $serial->serial_code = $id;
        $serial->status = "available";
        $serial->items_id = $item->id;

        $serial->save();

        return redirect('/items');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { }

    /**
     * Display the specified resource.
     *
     * @param  \App\items  $items
     * @return \Illuminate\Http\Response
     */
    public function show(items $items)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\items  $items
     * @return \Illuminate\Http\Response
     */
    public function edit(items $items)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\items  $items
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { {
            $request->validate(
                [
                    'description' => 'required|max:255'
                ]
            );
        }

        $game = \App\items::find($id);
        $game->name = $request->name;
        $game->price = $request->price;
        $game->description = $request->description;
        $game->category = $request->category;

        if (Input::hasFile('image')) {
            $file = $request->file('image');
            $game->img_path = $file->getClientOriginalName();
            $file->move('images/games', $file->getClientOriginalName());
        }

        $game->save();

        return redirect('/items');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\items  $items
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = \App\items::find($id);
        $item->delete();

        return redirect('/items');
    }
}
