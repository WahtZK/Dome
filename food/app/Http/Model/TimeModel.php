<?php
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
class TimeModel extends Model{
    const CREATED_AT = null;
    const UPDATED_AT = null;
    protected $table = 'p_time';
    protected $primaryKey= 'time_id';
}
?>