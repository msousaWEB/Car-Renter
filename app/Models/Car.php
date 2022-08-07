<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $fillable = ['model_id', 'plate', 'ready', 'km'];

    public function rules() {
        return [
            'model_id' => 'exists:car_models,id',
            'plate' => 'required',
            'ready' => 'required|boolean',
            'km' => 'required',
        ];
    }

    public function model() {
        return $this->belongsTo(CarModel::class);
    }
}
