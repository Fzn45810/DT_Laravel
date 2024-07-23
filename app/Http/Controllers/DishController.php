<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dish;
use Illuminate\Support\Facades\Validator;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list_dish = Dish::with('rating')->get();
        return response()->json(['list_dish' => $list_dish]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required|string|max:255|unique:dishes',
            'description' => 'required|string|max:255|unique:dishes',
            'image_url' => 'required|string|max:255',
            'price' => 'required|integer'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $dish = new Dish;
        $dish->name = request()->name;
        $dish->description = request()->description;
        $dish->image_url = request()->image_url;
        $dish->price = request()->price;
        $dish->save();

        return response()->json(['success' => 'successfully store']);
    }

    /**
     * Display the specified resource.
    */
    public function show(string $id)
    {
        $get_dish = Dish::where("id", $id)->first();
        return response()->json(['dish' => $get_dish]);
    }

    /**
     * Show the form for editing the specified resource.
    */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required|string|max:255|unique:dishes',
            'description' => 'required|string|max:255|unique:dishes',
            'image_url' => 'required|string|max:255',
            'price' => 'required|integer'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $get_dish = Dish::where("id", $id)->update([
            'name' => request('name'),
            'description' => request('description'),
            'image_url' => request('image_url'),
            'price' => request('price')
        ]);

        return response()->json(['success' => 'successfully update']);
    }

    /**
     * Remove the specified resource from storage.
    */
    public function destroy(string $id)
    {
        if(Dish::where("id", $id)->delete()){
            return response()->json(['success' => 'successfully deleted']);
        }else{
            return response()->json(['error' => 'please try again']);
        }
    }
}
