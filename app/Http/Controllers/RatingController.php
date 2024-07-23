<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Rating;
use App\Models\User;
use App\Models\Dish;

class RatingController extends Controller
{
    public function rating(string $user_id, string $dish_id)
    {
        $get_dish = Dish::where("id", $dish_id)->first();
        $get_user = User::where("id", $user_id)->first();

        $validator = Validator::make(request()->all(), [
            'description' => 'required|string|max:255',
            'rating' => 'required|integer|between:1,5'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $get_ratings = Rating::where('user_id', $user_id)->where('dish_id', $dish_id)->first();

        if($get_ratings){
            return response()->json(['message' => "Rating already given"]);
        }else{
            $ratings = new Rating();
            $ratings->description = request()->description;
            $ratings->rating = request()->rating;
            $ratings->dish()->associate($get_dish);
            $get_user->rating()->save($ratings);

            return response()->json(['success' => "Rating successfull"]);
        }
    }
}
