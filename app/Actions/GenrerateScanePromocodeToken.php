<?php


namespace App\Actions;

use App\GeneratePromocodeToken;
use Illuminate\Support\Str;
/**
 * Response represents an HTTP response.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class GenrerateScanePromocodeToken
{

    protected $GeneratePromocodeToken;

    public function __construct(GeneratePromocodeToken $GeneratePromocodeToken)
    {
        $this->GeneratePromocodeToken = $GeneratePromocodeToken;
    }

    public function execute(array $data){
        $data['unique_token'] = Str::random(30);
        $GeneratePromocodeToken = $this->GeneratePromocodeToken->create($data);

        return $GeneratePromocodeToken;
    }
}
