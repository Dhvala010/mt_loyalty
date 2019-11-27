<?php


namespace App\Actions;

use App\Constants\ResponseMessage;
use App\Store;
use App\StorePromocode;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
/**
 * Response represents an HTTP response.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class CreatePromoCode
{

    protected $StorePromocode;
    public function __construct(StorePromocode $StorePromocode)
    {
        $this->StorePromocode = $StorePromocode;
    }

    public function execute(array $data){
        $data['unique_number'] = Str::random(30);
        $StorePromocode = $this->StorePromocode->create($data);
        return $StorePromocode;
    }
}
