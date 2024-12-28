<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Models\UserActivation;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SalePartnerT extends TestCase
{
    public function register_mobile(): void
    {
        $response = $this->post('/api/v1/auth/register',
            ['mobile' => '09372791489',
            'type' => '0',
            'first_name' => 'علی',
            'last_name' => 'علوی',
            //'father_name' => 'nullable|string|persian_alpha|min:3|max:128',
            'address' => 'خ 15 خرداد',
            'phone' => '01133110171',
            'national_code' => '2080438077',
            'province_id' => 1,
            'city_id' => 1,
            'gender' => 1,
            'birthdate' => Carbon::create(1993,6,6),
            'postal_code' => "4818897434",
            //'bank_account_number' => '132121211234',
            //'bank_sheba' => 'nullable|string|ir_sheba',
            //'bank_card_number' => '6037997224363185',
            'id_card_file' => UploadedFile::fake()->image('photo.jpg'),
            //'personal_picture_file' => UploadedFile::fake()->image('photo.jpg'),
            'document_file' => UploadedFile::fake()->image('photo.jpg'),
            'education' => 3,
            'dress_size' => 1,
            //'referral' => 'string',
            //'describe' => 'string',
            ]
        );

        // Assert
        $response->assertStatus(200);

        //$response->dd();
    }
    public function test_login_mobile(): void
    {
        $response = $this->post('/api/v1/sale-partner/auth/login',
            ['mobile' => '09372791489']
        );

        // Assert
        $response->assertStatus(200);

        $otp_code = UserActivation::where("mobile",'09372791489')->first();
        $data = json_decode($response->content());
        $this->login_mobile_verify('09372791489',$data->data->hashcode, $otp_code->code);
    }

    public function login_mobile_verify($mobile, $hashCode, $code): void
    {
        $response = $this->post('/api/v1/sale-partner/auth/verify',
            [
                'mobile' => $mobile,
                "otp_code" => $code,
                "hash_code" => $hashCode
            ]
        );

        // Assert
        $response->assertStatus(200);

        $data = json_decode($response->content());
        //$this->giftOrders($data->data->token);
        //$this->update_profile($data->data->token);
        //$this->get_profile($data->data->token);
        //$this->update_document($data->data->token);
        //$this->get_coin($data->data->token);
        //$this->get_sliders();
        $this->updateToken($data->data->token);
        $this->notif($data->data->token);
        //$this->create_order($data->data->token);
        //$this->orders($data->data->token);
        //$this->goods($data->data->token);
        //$this->good($data->data->token);
        //$this->purchaseGift($data->data->token);

    }
    public function updateToken($token): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/v1/update-device-token', [
            'fcm_token' => '123456',
        ]);
        //$response->dd();
        // Assert
        $response->assertStatus(200);
    }

    public function notif($token): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/v1/send/notification');
        $response->dd();
        // Assert
        $response->assertStatus(200);
    }
    public function create_order($token): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/v1/sale-partner/order/submit',[
            'final_items' => [
                ["product_id" => 5, "quantity" => 300],
                ["product_id" => 6, "quantity" => 200],
            ],
            'description' => 'لطفاً پیش فاکتور ارسال شود',
        ]);
        $response->dd();
        // Assert
        $response->assertStatus(200);
    }

    public function update_profile($token): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->post('/api/v1/user/profile/update',
                [
                    'first_name' => 'علی',
                    'last_name' => 'علوی دو',
                    'father_name' => 'احمد',
                    'address' => 'خ 15 خرداد',
                    'phone' => '01133110172',
                    'province_id' => 1,
                    'city_id' => 2,
                    'birthdate' => Carbon::create(1993,6,10),
                    'postal_code' => "4818897435",
                    'bank_account_number' => '1321-21211234',
                    //'bank_sheba' => 'nullable|string|ir_sheba',
                    'bank_card_number' => '6037997224363185',
                    'education' => 3,
                    'dress_size' => 1,
                ]
            );
        //$response->dd();
        // Assert
        $response->assertStatus(200);
    }

    public function get_sliders($token): void
    {
        $response = $this->get('/api/v1/app/sliders');
        // Assert
        $response->dd();
        $response->assertStatus(200);
    }

    public function get_profile($token): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->get('/api/v1/user/information');
        // Assert
        $response->assertStatus(200);
    }

    public function get_coin($token): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/v1/sale-partner/coin');
        $response->dd();
        // Assert
        $response->assertStatus(200);


    }

    public function goods($token): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/v1/sale-partner/goods');
        //$response->dd();
        // Assert
        $response->assertStatus(200);
    }

    public function orders($token): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/v1/sale-partner/orders');
        $response->dd();
        // Assert
        $response->assertStatus(200);
    }

    public function giftOrders($token): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/v1/sale-partner/giftshop/orders');
        $response->dd();
        // Assert
        $response->assertStatus(200);
    }

    public function good($token): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/v1/sale-partner/good/2');
        $response->dd();
        // Assert
        $response->assertStatus(200);
    }

    public function giftshopProducts($token): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/v1/sale-partner/giftshop/products');
        $response->dd();
        // Assert
        $response->assertStatus(200);
    }

    public function create_projects($token): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/v1/user/project/create',[
            'title' => 'تست پروژه',
            'client_first_name' => 'علی',
            'client_last_name' => 'کاملی',
            'client_address' => 'خ پانزده خرداد',
            'client_phone' => '09372791489',
            //'client_national_code' => 'nullable|ir_national_code|unique:users,national_code,NULL,id,deleted_at,NULL',
            'client_province_id' => 2,
            'client_city_id' => 13,
            'serial_number' => ['P123585','P356070'],
            'client_zipcode' => '4818897434',
            'picture1' => UploadedFile::fake()->image('photo1.jpg'),
            'picture2' => UploadedFile::fake()->image('photo2.jpg'),
            'picture3' => UploadedFile::fake()->image('photo3.jpg'),
            //'picture4' => 'nullable|file|mimes:jpg,jpeg,png|max:10240',
            //'picture5' => 'nullable|file|mimes:jpg,jpeg,png|max:10240',
            'sale_partner_name' => 'نماینده مازندران ساری',
            //'description' => 'nullable|string',
        ]);
        $response->dd();
        // Assert
        $response->assertStatus(200);
    }

    public function purchaseGift($token): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('api/v1/sale-partner/giftshop/product/2/purchase');
        $response->dd();
        // Assert
        $response->assertStatus(200);
    }
}
