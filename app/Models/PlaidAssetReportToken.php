<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaidAssetReportToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'asset_report_id',
        'asset_report_token',
        'deal_id'
    ];
}
