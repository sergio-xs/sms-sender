<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class SmsLog extends Model
{
    /**
     * @var string Protected table
     */
    protected $table = 'sms_logs';

    protected $fillable = [
        'send_date',
        'number',
        'sender',
        'message',
        'campaign',
        'client_ip',
        'credits',
        'status',
        'full_status',
        'provider',
        'sms_type',
        'contract_type',
        'company',
        'sms_sender_user',
        'port'
    ];

}
