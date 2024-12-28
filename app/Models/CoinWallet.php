<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Models\Admin\SalePartner;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class GiftShopProduct
 *
 * @property int $id
 * @property float $balance
 * @property string $address
 * @property int $walletable_id
 * @property string $walletable_type
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class CoinWallet extends Model
{
	protected $table = 'coin_wallets';

	protected $casts = [
		'status' => 'int',
		'balance' => 'float'
	];

	protected $fillable = [
		'address',
		'balance',
		'walletable_id',
		'walletable_type',
		'status',
	];

    public function walletable()
    {
        return $this->morphTo();
    }
}
