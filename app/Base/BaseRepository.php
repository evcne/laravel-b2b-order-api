<?php 

namespace App\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use Illuminate\Support\Collection;

class BaseRepository
{
    protected $helper;


    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

}