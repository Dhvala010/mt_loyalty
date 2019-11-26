<?php


namespace App\Actions;

use App\Store;
/**
 * Response represents an HTTP response.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class CreateMerchantStore
{

    protected $store;
    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    public function execute(array $data){
        if(!empty($data['store_id'])){
            $store = Store::find($data['store_id']);
            $store->fill($data);
            $store->save();
        }else{
            $store = $this->store->create($data);
        }
        return $store;
    }
}
