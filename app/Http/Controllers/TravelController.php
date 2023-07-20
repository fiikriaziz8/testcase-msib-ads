<?php

namespace App\Http\Controllers;

use App\Models\Travel;
use App\Http\Requests\StoreTravelRequest;
use App\Http\Requests\UpdateTravelRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TravelController extends Controller
{
    public function allTravel()
    {
        $travelLists = Travel::all();

        return response()->json([
            'success' => true,
            'message' => 'Semua data travel',
            'data' => $travelLists,
        ]);
    }


    public function filterTravel(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'harga' => 'integer|min:0',
            'asal' => 'string|max:255',
            'tujuan' => 'string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter tidak valid',
                'errors' => $validator->errors(),
            ], 422); 
        }

        $allowedParameters = ['harga', 'asal', 'tujuan', 'waktuBerangkat'];
        $invalidParameters = array_diff(array_keys($request->all()), $allowedParameters);

        if (!empty($invalidParameters)) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter tidak valid',
                'invalid_parameters' => $invalidParameters,
            ], 422); 
        }


        $query = Travel::query();

        if ($request->has('harga')) {
            $query->where('harga', $request->harga);
        }

        if ($request->has('asal')) {
            $query->where('asal', $request->asal);
        }

        if ($request->has('tujuan')) {
            $query->where('tujuan', $request->tujuan);
        }

        if ($request->has('waktuBerangkat')) {
            $query->where('waktuBerangkat', $request->waktuBerangkat);
        }

        $filteredTravelLists = $query->get();

        if($filteredTravelLists->count() == 0){
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data travel filter',
            'data' => $filteredTravelLists,
        ]);
    }  
}
