<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'image'];

    public function rules() {
        return [
            'name' => 'required|unique:car_brands,name,'.$this->id.'|min:3',
            'image' => 'required|file|mimes:png'
        ];
    }

    public function feedback() {
        return [
            'required' => 'Este campo é obrigatório!',
            'name.unique' => 'Este nome já está sendo utilizado!',
            'name.min' => 'O nome deve ter no mínimo 3 caracteres!',
            'image.mimes' => 'A imagem deve ser .png!'
        ];
    }

    public function models() {
        return $this->hasMany(CarModel::class, 'brand_id');
    }
}
