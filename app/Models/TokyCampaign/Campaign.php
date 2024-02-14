<?php

namespace App\Models\TokyCampaign;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class Campaign extends Model
{
    protected $connection = 'contratti';

    protected $table = 'campaign';

}
