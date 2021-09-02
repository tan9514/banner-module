<?php
/**
 * Created By PhpStorm.
 * User: Li Ming
 * Date: 2021-08-03
 * Fun: 商品表
 */

namespace Modules\Banner\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Support\Jsonable;

class Banner extends BaseModel
{
    use HasFactory;
    protected $table = "banner";

}