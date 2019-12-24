<?php


namespace App\Actions;

use App\StoreOffer;

/**
 * Response represents an HTTP response.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class AddEditStoreOffer
{

    protected $StoreOffer;

    public function __construct(StoreOffer $StoreOffer)
    {
        $this->StoreOffer = $StoreOffer;
    }

    public function execute(array $data){
        if(!empty($data['store_offer_id'])){
            $StoreOffer = StoreOffer::find($data['store_offer_id']);
            $StoreOffer->fill($data);
            $StoreOffer->save();
        }else{
            $StoreOffer = $this->StoreOffer->create($data);
        }
        return $StoreOffer;
    }
}
