<?php
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
class PriceModel extends Model{
    const CREATED_AT = null;
    const UPDATED_AT = null;
    protected $table = 'price';
    protected $primaryKey= 'price_id';
}
?>