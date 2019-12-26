<?php


namespace App\Actions;

use App\Store;
use App\Actions\CreatePromoCode;
/**
 * Response represents an HTTP response.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class CreateMerchantStore
{

    protected $store;
    protected $CreatePromoCode;

    public function __construct(Store $store,CreatePromoCode $CreatePromoCode)
    {
        $this->store = $store;
        $this->CreatePromoCode = $CreatePromoCode;
    }

    public function execute(array $data){
        if(!empty($data['store_id'])){
            $store = Store::find($data['store_id']);
            $store->fill($data);
            $store->save();
        }else{
            $store = $this->store->create($data);
            $PromocodeData = [
                'store_id' => $store->id
            ];
            $this->CreatePromoCode->execute($PromocodeData);
        }
        return $store;
    }
}
