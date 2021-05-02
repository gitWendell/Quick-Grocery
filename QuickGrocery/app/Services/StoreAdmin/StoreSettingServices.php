<?php

namespace App\Services\StoreAdmin;

use App\Product;
use App\RequestStock;
use App\Store;
use App\StoreSetting;

class StoreSettingServices {

    public function update($request, $id) {

        $request['can_deliver'] == null ? $update['candeliver'] = 0 : $update['candeliver'] = $request['can_deliver'];
        $update['name'] = $request['store_name'];
        $update['description'] = $request['store_description'];
        $update['status'] = $request['status'];

        if($request['auto_supply'] == 1 || count($request['request_stock']) > 0 || count($request['request_product_id']) > 0 || $request['auto_supply'] != '') {

            $storeSettingExist = StoreSetting::where('store_id', $id)->first();

            if ($storeSettingExist != null) {
                $this->updateSetting($request, $id);
            } else {
                $this->createSetting($request, $id);
            }
        }

        return $update;
    }

    public function createSetting($request, $id) {

        $createSetting['store_id'] = $id;
        $createSetting['auto_supply'] = $request['auto_supply'] == null ? $request['auto_supply'] = 0 : $request['auto_supply'];
        $createSetting['request_on_stock'] = $request['request_on_stock'] == null ? $request['request_on_stock'] = 0 : $request['request_on_stock'];
        $createSetting['status'] = 'Active';

        $settings = StoreSetting::create($createSetting);

        if ($settings && $request['request_stock'] != '') {
            $this->createRequestStock($request, $settings);
        }

    }

    public function updateSetting($request, $id) {

        $updateSetting['auto_supply'] = $request['auto_supply'];
        $updateSetting['request_on_stock'] = $request['request_on_stock'];

        StoreSetting::where('store_id', $id)->update($updateSetting);
        $settings = StoreSetting::where('store_id', $id)->first();

        if ($settings && $request['request_stock'] != '') {
            $this->updateRequestStock($request, $settings);
        }
    }

    public function getRequestStock($request) {
        $check_product_id = 0;

        foreach ($request->input('request_product_id') as $product_id) {
            if ($product_id != $check_product_id) {
                $product_ids[] = $product_id;
                $check_product_id = $product_id;
            }
        }
        foreach ($request->input('request_stock') as $howManyStock) {
                $numberOfStocks[] = $howManyStock;
        }
        return array_combine($product_ids,$numberOfStocks);

    }

    public function createRequestStock($request, $settings) {

        foreach ($this->getRequestStock($request) as $product_id => $stocks) {
            $product = Product::where('id', $product_id)->first();

            $createStocks['setting_id'] = $settings->id;
            $createStocks['product_id'] = $product_id;
            $createStocks['stocks'] = $stocks == null ? 0 : $stocks;
            $createStocks['status'] = 'Active';

            RequestStock::create($createStocks);
        }
    }

    public function updateRequestStock($request, $settings) {

        $request_stocks = RequestStock::where('setting_id', $settings->id)->get();

        if (sizeof($request_stocks) != 0 ) {
            foreach ($this->getRequestStock($request) as $product_id => $stocks) {
                $productExist = RequestStock::where('product_id',$product_id )->first();

                if ($productExist) {
                    $updateStocks['product_id'] = $product_id;
                    $updateStocks['stocks'] = $stocks;
                    RequestStock::where('id', $productExist->id)->update($updateStocks);
                } else {

                    $this->createRequestStock($request, $settings);
                }
            }
        } else {

            $this->createRequestStock($request, $settings);
        }
    }
}
