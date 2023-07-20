<?php

namespace App\Http\Controllers;

use App\Models\TravelOrder;
use App\Http\Requests\StoreTravelOrderRequest;
use App\Http\Requests\UpdateTravelOrderRequest;
use App\Models\Travel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TravelOrderController extends Controller
{
    public function createOrder(Request $request)
    {

        $user = Auth::user();

        $request->validate([
            'travel_id' => 'required',
        ]);

        $travel = Travel::find($request->travel_id);

        if (!$travel) {
            return response()->json([
                'success' => false,
                'message' => 'Travel tidak ditemukan',
            ], 404);
        }

        $orderData = [
            'travel_id' => $travel->id,
            'user_id' => $user->id,
            'namaTravel' => $travel->namaTravel,
            'asal' => $travel->asal,
            'tujuan' => $travel->tujuan,
            'harga' => $travel->harga,
            'waktuBerangkat' => $travel->waktuBerangkat,
            'tanggalOrder' => now(),
        ];

        $order = TravelOrder::create($orderData);

        return response()->json([
            'success' => true,
            'message' => 'Travel berhasil di-booking',
            'data' => $order,
        ]);
    }
}
