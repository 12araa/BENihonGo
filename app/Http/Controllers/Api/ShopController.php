<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ShopService;
use Exception;

class ShopController extends Controller
{
    protected $shopService;

    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }

    public function index()
    {
        $data = $this->shopService->getShopItems(Auth::user());

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function buy(Request $request)
    {
        $request->validate(['item_id' => 'required|integer']);

        try {
            $result = $this->shopService->buyItem(Auth::user(), $request->item_id);

            return response()->json([
                'success' => true,
                'message' => "Berhasil membeli {$result['item_name']}!",
                'data' => ['current_gold' => $result['remaining_gold']]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function equip(Request $request)
    {
        $request->validate(['item_id' => 'required|integer']);

        try {
            $this->shopService->equipItem(Auth::user(), $request->item_id);

            return response()->json([
                'success' => true,
                'message' => 'Item berhasil dipasang!'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
