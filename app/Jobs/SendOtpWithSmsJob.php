<?php

namespace App\Jobs;

use App\Constants\Sms;
use App\Services\Api\SmsGatewayService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOtpWithSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $code;

    private string $mobile;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mobile, $code)
    {
        $this->mobile = $mobile;
        $this->code = $code;

        $this->onQueue('sms');
    }

    /**
     * @throws Exception
     */
    public function handle()
    {
        $params = [
            'CODE' => $this->code
        ];

        $smsGateway = new SmsGatewayService();
        $smsGateway->send($this->mobile, $params, Sms::SMSIR_VERIFY_TEMPLATE_ID);
    }
}
