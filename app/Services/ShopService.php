<?php

namespace App\Services;

use App\Models\Item;
use App\Models\UserItem;
use App\Models\UserGamification;
use Illuminate\Support\Facades\DB;
use Exception;

class ShopService
{
    public function getShopItems($user)
    {
        $items = Item::where('is_active', true)->get();
        $ownedItemIds = $user->items->pluck('id')->toArray();

        return [
            'items' => $items,
            'owned_item_ids' => $ownedItemIds
        ];
    }

    public function buyItem($user, $itemId)
    {
        $item = Item::where('id', $itemId)->where('is_active', true)->first();

        if (!$item) {
            throw new Exception('Item tidak ditemukan atau belum dijual!');
        }

        if ($user->items()->where('item_id', $item->id)->exists()) {
            throw new Exception('Kamu sudah memiliki item ini!');
        }

        return DB::transaction(function () use ($user, $item) {
            $gamification = UserGamification::where('user_id', $user->id)
                                            ->lockForUpdate()
                                            ->first();

            if (!$gamification || $gamification->gold < $item->price) {
                throw new Exception('Gold tidak cukup!');
            }

            $gamification->gold -= $item->price;
            $gamification->save();

            UserItem::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
                'is_equipped' => false
            ]);

            return [
                'item_name' => $item->name,
                'remaining_gold' => $gamification->gold
            ];
        });
    }

    public function equipItem($user, $itemId)
    {
        $targetUserItem = UserItem::where('user_id', $user->id)
                                  ->where('item_id', $itemId)
                                  ->with('item')
                                  ->first();

        if (!$targetUserItem) {
            throw new Exception('Kamu belum punya item ini!');
        }

        $itemType = $targetUserItem->item->type;

        DB::transaction(function () use ($user, $targetUserItem, $itemType) {
            UserItem::where('user_id', $user->id)
                    ->whereHas('item', function($q) use ($itemType) {
                        $q->where('type', $itemType);
                    })
                    ->update(['is_equipped' => false]);

            $targetUserItem->is_equipped = true;
            $targetUserItem->save();
        });

        return true;
    }
}
