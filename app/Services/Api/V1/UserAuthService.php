<?php

namespace App\Services\Api\Api\V1;

use App\Libraries\SMSIR;
use App\Models\CoinWallet;
use App\Models\User;
use App\Services\Api\Api\OtpService;
use Exception;
use Illuminate\Support\Facades\DB;
use Response;

class UserAuthService
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;

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
                $idCardFileDir = $idCardFile->storeAs('id_cards', $idCardFileName, ['disk' => 'disk']);

            }

            if($request->has('personal_picture_file')) {
                $personalPictureFile = $request->file('personal_picture_file');
                $personalPictureFileName = strtotime('now') . '.' . $personalPictureFile->extension();
                $personalPictureFileDir = $personalPictureFile->storeAs('personal_pictures', $personalPictureFileName,
                    ['disk' => 'disk']);
            }
            if($request->has('document_file')) {
                $documentFile = $request->file('document_file');
                $documentFileName = strtotime('now') . '.' . $documentFile->extension();
                $documentFileDir = $documentFile->storeAs('documents', $documentFileName, ['disk' => 'disk']);
            }
            $data = $request->all();
            $data['id_card_file'] = $idCardFileDir;
            $data['description'] =$request->input('describe');
            $data['personal_picture_file'] = $personalPictureFileDir;
            $data['document_file'] = $documentFileDir;
            $data['status'] = 0;
            //$data['birthdate'] = $request->input('birthdate');
            DB::beginTransaction();
            $user = $this->user->query()
                ->create($data);

            CoinWallet::create([
                "walletable_id" => $user->id,
                "walletable_type" => User::class,
                "address" => generateRandomString(),
                "balance" => 0,
                "status" => 1
            ]);

            $param = [
                [
                    "name" => "NAME",
                    "value" => $user->first_name." ".$user->last_name
                ],
            ];
            SMSIR::sendRegularSms($user->mobile,"424429",$param);
            //SMSIR::sendRegularSms($user->mobile,"149421",$param);
            DB::commit();
            return Response::success($user);

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
            $user = $this->user::query()
                ->where('mobile', '=', $request->input('mobile'))
                ->where('status', '<>', 3)
                ->first();

            if (!$user) {
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
        try {
            $user = User::query()->where('mobile', $request->input('mobile'))->first();

            if (!$user) {
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
                'token' => $user->createToken('auth_user')->plainTextToken,
            ]);
        } catch (Exception $exception) {
            return Response::error(
                code: 500,
                message: $exception->getMessage()
            );
        }
    }
}
