<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use App\Repositories\CarBrandRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarBrandController extends Controller
{
    public function __construct(CarBrand $carBrand)
    {
        $this->carBrand = $carBrand; 
    }


    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $carBrandRepo = new CarBrandRepository($this->carBrand);

        if($request->has('model_attributes')){
            $model_attributes = $request->get('model_attributes');
            $carBrandRepo->selectAttributesRegisterRelated('models:id,'.$model_attributes);
        } else {
            $carBrandRepo->selectAttributesRegisterRelated('models');
        }

        if($request->has('query')){
            $carBrandRepo->queryFilter($request->get('query'));
        }

        if($request->has('attributes')){
            $carBrandRepo->SelectAttributes($request->get('attributes'));
        } 

        return response()->json($carBrandRepo->getResult(), 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->carBrand->rules(), $this->carBrand->feedback());
        $image = $request->file('image');
        $image_urn = $image->store('images', 'public');
        $carBrand = $this->carBrand->create([
            'name' => $request->name,
            'image' => $image_urn
        ]);

        return response()->json($carBrand, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carBrand = $this->carBrand->with('models')->find($id);
        if($carBrand === null) {
            return response()->json(['error' => 'Não foi possível encontrar esta marca!'], 404);
        }

        return response()->json($carBrand, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $carBrand = $this->carBrand->find($id);
        if($carBrand === null) {
            return response()->json(['error' => 'Não foi possível atualizar esta marca!'], 404);
        }
        if($request->method() === 'PATCH') {
            $dynamicRules = array();
            //Percorre as regras definidas no Model
            foreach($carBrand as $input => $rule) {
                //Coleta apenas as regras aplicáveis nos parametros recebidos
                if(array_key_exists($input, $request->all())){
                    $dynamicRules[$input] = $rule;
                }
            }
            $request->validate($dynamicRules, $carBrand->feedback());
        } else {
            $request->validate($carBrand->rules(), $carBrand->feedback());
        }
        //Remove a imagem anterior
        if($request->file('image')) {
            Storage::disk('public')->delete($carBrand->image);
        }
        $image = $request->file('image');
        $image_urn = $image->store('images', 'public');

        $carBrand->fill($request->all());
        $carBrand->image = $image_urn;
        $carBrand->save();

        return response()->json($carBrand, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carBrand = $this->carBrand->find($id);
        if($carBrand === null) {
            return response()->json(['error' => 'Não foi possível apagar esta marca!'], 404);
        }
        //Remove a imagem anterior
        Storage::disk('public')->delete($carBrand->image);
        $carBrand->delete();

        return response()->json(['msg' => 'Marca deletada com sucesso!'], 200);
    }
}
