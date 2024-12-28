<?php

namespace App\Services\Api\Api;

use App\Events\SMSSendEvent;
use App\Exceptions\Sms\OtpException;
use App\Jobs\SendOtpWithEmailJob;
use App\Jobs\SendOtpWithSmsJob;
use App\Libraries\SMSIR;
use App\Models\LawyerActivation;
use App\Models\MemberActivation;
use App\Models\UserActivation;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class OtpService
{
    // can be : mobile | email
    protected string $method;

    // can be :  lawyer | member
    protected string $userType;

    protected string $target;

    protected int $code = 0;

    protected string $hashcode;

    protected string $code_validity_period;

    public function __construct()
    {
        $this->code_validity_period = 2;
    }

    /**
     * @throws Exception
     */
    public function sendOtpViaMobile($mobile): void
    {
        $this->generateRandomCode();
        $this->generateRandomHashcode();

        $this->storeLogMember($mobile);

        // send otp code
        if (!env('APP_DEBUG'))
            SMSIR::send($mobile, $this->code);
    }

    public function setTarget($target): self
    {
        $this->target = $target;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function getHashcode(): string
    {
        if (strlen($this->hashcode) < 6)
            throw new Exception('Hashcode is not set.');

        return $this->hashcode;
    }

    protected function generateRandomCode($length = 6): void
    {
        if (!env('APP_DEBUG')) {
            $min = pow(10, $length - 1);
            $max = pow(10, $length) - 1;
            $this->code = mt_rand($min, $max);
        } else {
            $this->code = (int)Str::repeat('1', 6);
        }
    }

    protected function generateRandomHashcode(): void
    {
        $this->hashcode = Str::random();
    }

    protected function storeLogMember($mobile): void
    {
        UserActivation::query()
            ->create([
            'type' => 1,
            'mobile' => $mobile,
            'code' => $this->code,
            'hashcode' => $this->hashcode,
            'expired_at' => Carbon::now()->addMinutes($this->code_validity_period),
            'created_at' => Carbon::now()
        ]);
    }

    protected function getLogTargetType(): int
    {
        return $this->method == 'mobile' ? 1 : 2;
    }

    /**
     * @throws Exception
     */
    protected function validator(): void
    {
        $this->userTypeValidator();

        $this->codeValidator();

        $this->targetValidator();
    }

    /**
     * @throws Exception
     */
    protected function userTypeValidator(): void
    {
        if (!in_array($this->userType, ['lawyer', 'member']))
            throw new Exception('User type not specified.');
    }

    /**
     * @throws Exception
     */
    protected function codeValidator(): void
    {
        if ($this->code == 0)
            throw new Exception('Code is not generated.');
    }

    /**
     * @throws Exception
     */
    protected function targetValidator(): void
    {
        if (strlen($this->target) < 3)
            throw new Exception('Target not specified.');
    }

    /**
     * @throws Exception
     */
    public function getLatestValidCode($mobile)
    {

        return UserActivation::query()
            ->where([
                'mobile' => $mobile,
            ])
            ->where('expired_at', '>', Carbon::now())
            ->whereNull('used_at')
            ->first();
    }

    /**
     * @throws Exception
     */
    public function verifyOtpViaMobile($mobile, $hashcode, $code): void
    {
        $codeInfo = UserActivation::query()
            ->where([
                'mobile' => $mobile,
                'hashcode' => $hashcode,
                'code' => $code,
            ])
            ->where('expired_at', '>=', Carbon::now())
            ->whereNull('used_at')
            ->first();
        if (!$codeInfo)
            throw new OtpException("اطلاعات وارد شده صحیح نمی باشد");

        $codeInfo->update([
            'used_at' => Carbon::now()
        ]);
    }
}
