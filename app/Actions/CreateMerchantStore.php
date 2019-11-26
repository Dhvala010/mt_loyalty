<?php


namespace App\Actions;

use App\Constants\ResponseMessage;
use App\Exceptions\EmailNotUniqueException;
use App\Store;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
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
