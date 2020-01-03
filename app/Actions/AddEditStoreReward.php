<?php


namespace App\Actions;

use App\StoreReward;

/**
 * Response represents an HTTP response.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class AddEditStoreReward
{

    protected $StoreReward;

    public function __construct(StoreReward $StoreReward)
    {
        $this->StoreReward = $StoreReward;
    }

    public function execute(array $data){

        if(!empty($data['store_reward_id'])){
            $StoreReward = StoreReward::find($data['store_reward_id']);
            $StoreReward->fill($data);
            $StoreReward->save();
        }else{

            $StoreReward = $this->StoreReward->create($data);
        }
        return $StoreReward;
    }
}
