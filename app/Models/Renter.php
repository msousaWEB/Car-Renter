<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renter extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'car_id', 'date_initial', 'date_final', 'data_final_fulfilled', 'daily_rate', 'km_initial', 'km_final'];

    public function rules() {
        return [
            'customer_id' => 'exists:customers,id',
            'car_id' => 'exists:cars,id',
            'date_initial' => 'required',
            'date_final' => 'required',
            'data_final_fulfilled' => 'required',
            'daily_rate' => 'required',
            'km_initial' => 'required',
            'km_final' => 'required',
        ];
    }
}
