<?php

namespace App\Services\Api\Api\V1;

use App\Libraries\SMSIR;
use App\Models\Admin\SalePartner;
use App\Models\CoinWallet;
use App\Models\User;
use App\Services\Api\Api\OtpService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class SalePartnerAuthService
{
    private SalePartner $salePartner;

    public function __construct(SalePartner $salePartner)
    {
        $this->salePartner = $salePartner;

    }

    /**
     * Register User
     *
     * @param $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register($request): \Illuminate\Http\Response
    {
        try{
            $documentFileDir=$personalPictureFileDir=$idCardFileDir=null;
            if($request->has('id_card_file')){
                $idCardFile = $request->file('id_card_file');
                $idCardFileName = strtotime('now') . '.' . $idCardFile->extension();
                $idCardFileDir = $idCardFile->storeAs('sale_partner/id_cards', $idCardFileName, ['disk' => 'disk']);

            }

            if($request->has('personal_image_file')) {
                $personalPictureFile = $request->file('personal_image_file');
                $personalPictureFileName = strtotime('now') . '.' . $personalPictureFile->extension();
                $personalPictureFileDir = $personalPictureFile->storeAs('sale_partner/personal_images', $personalPictureFileName,
                    ['disk' => 'disk']);
            }

            $data = $request->all();
            $data['id_card_file'] = $idCardFileDir;
            $data['personal_image_file'] = $personalPictureFileDir;
            $data['status'] = 0;
            //$data['birthdate'] = $request->input('birthdate');
            DB::beginTransaction();
            $salePartner = $this->salePartner->query()
                ->create($data);

            CoinWallet::create([
                "walletable_id" => $salePartner->id,
                "walletable_type" => SalePartner::class,
                "address" => generateRandomString(),
                "balance" => 0,
                "status" => 1
            ]);

            $param = [
                [
                    "name" => "NAME",
                    "value" => $salePartner->first_name." ".$salePartner->last_name
                ],
            ];
            SMSIR::sendRegularSms($salePartner->mobile,"149421",$param);
            DB::commit();
            return Response::success($salePartner);

        }
        catch (Exception $exception) {
            DB::rollBack();
            return Response::error(
                code: 500,
                message: $exception->getMessage()
            );
        }

    }

    /**
     * Login User with Mobile
     *
     * @param $request
     *
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function login($request): \Illuminate\Http\Response
    {
        try {
            $salePartner = $this->salePartner::query()
                ->where('mobile', '=', $request->input('mobile'))
                ->where('status', '<>', 3)
                ->first();

            if (!$salePartner) {
                return Response::error(
                    code: 404,
                    message: 'کاربری یافت نشد'
                );
            }

            $otpService = new OtpService();

            // check for has valid token
            $latestValidCode = $otpService->getLatestValidCode($request->input('mobile'));

            if ($latestValidCode && isset($latestValidCode->expired_at)) {
                return Response::success(
                    message: __("A valid verification code is available."),
                    data: [
                        'hashcode' => $latestValidCode->hashcode,
                        'expired_at' => $latestValidCode->expired_at,
                    ]
                );
            }

            // send to mobile
            $otpService->sendOtpViaMobile($request->input('mobile'));

            return Response::success(
                message: __("Verification code sent successfully."),
                data: [
                    'hashcode' => $otpService->getHashcode(),
                ]
            );
        }
        catch (Exception $exception) {
            DB::rollBack();
            return Response::error(
                code: 500,
                message: $exception->getMessage()
            );
        }
    }

    /**
     * Verify Login User with Mobile
     *
     * @param $request
     *
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function verifyLogin($request): \Illuminate\Http\Response
    {
        // try {
            $salePartner = SalePartner::query()->where('mobile', $request->input('mobile'))->first();
            if (!$salePartner) {
                return Response::error(
                    code: 404,
                    message: 'اطلاعات وارد شده صحیح نمی باشد.'
                );
            }

            // check otp code
            $otpService = new OtpService();
            $otpService
                ->verifyOtpViaMobile(
                    $request->input('mobile'),
                    $request->input('hash_code'),
                    $request->input('otp_code')
                );

            return Response::success(data: [
                'token' => $salePartner->createToken('auth_sale_partner')->plainTextToken,
            ]);
        // } catch (Exception $exception) {
        //     return Response::error(
        //         code: 500,
        //         message: $exception->getMessage()
        //     );
        // }
    }
}
