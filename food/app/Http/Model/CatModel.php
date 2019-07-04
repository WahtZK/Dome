<?php
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
class CatModel extends Model{
    const CREATED_AT = null;
    const UPDATED_AT = null;
    protected $table = 'cat';
    protected $primaryKey= 'cat_id';
}
?>