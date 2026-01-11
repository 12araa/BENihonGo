<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // 1. GET /api/shop
    // Menampilkan daftar semua item yang dijual
    public function index()
    {
        $items = Item::all();

        // MOCK: Kita asumsikan user (Tanaka) sedang login
        // Supaya Frontend tau mana item yang "Sudah Dibeli" vs "Belum"
        // Nanti logika real-nya pakai Auth::user()
        $user = User::first();
        $ownedItemIds = $user->inventory->pluck('item_id')->toArray();

        $data = $items->map(function($item) use ($ownedItemIds) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'type' => $item->type,
                'price' => $item->price,
                'image' => asset($item->asset_path),
                'is_owned' => in_array($item->id, $ownedItemIds), // True kalo udah punya
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // 2. POST /api/shop/buy
    // Melakukan pembelian item
    public function buy(Request $request)
    {
        // Request: { "item_id": 1 }

        $item = Item::find($request->item_id);
        if (!$item) return response()->json(['message' => 'Item not found'], 404);

        // MOCK LOGIC:
        // Kita pura-pura user punya uang 1000 Gold.
        // Kalau harga item > 1000, gagal. Kalau cukup, sukses.
        $mockUserGold = 1000;

        if ($item->price > $mockUserGold) {
            return response()->json([
                'success' => false,
                'message' => 'Gold tidak cukup!',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => "Berhasil membeli {$item->name}!",
            'data' => [
                'remaining_gold' => $mockUserGold - $item->price,
                'item_purchased' => $item->name
            ]
        ]);
    }

    // 3. POST /api/shop/equip
    // Memakai item (Ganti Avatar)
    public function equip(Request $request)
    {
        // Request: { "item_id": 2 }

        // MOCK LOGIC: Selalu berhasil
        return response()->json([
            'success' => true,
            'message' => 'Avatar berhasil diganti!',
        ]);
    }
}
