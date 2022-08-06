<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;
    protected $fillable = ['brand_id', 'name', 'image', 'port_number', 'seats', 'air_bag', 'abs'];

    public function rules() {
        return [
            'brand_id' => 'exists:car_brands,id',
            'name' => 'required|unique:car_models,name,'.$this->id.'|min:3',
            'image' => 'required|file|mimes:png,jpeg,jpg',
            'port_number' => 'required|integer|digits_between:1,5',
            'seats' => 'required|integer|digits_between:1,8',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean'
        ];
    }

    public function brand() {
        return $this->belongsTo(CarBrand::class);
    }
}
