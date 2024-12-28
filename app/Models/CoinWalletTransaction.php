<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoinWalletTransaction extends Model
{
	protected $table = 'coin_wallet_transactions';

	protected $casts = [
		'from_wallet_id' => 'int',
		'to_wallet_id' => 'int',
	];

	protected $fillable = [
		'from_wallet_id',
		'to_wallet_id',
		'amount',
	];
}
