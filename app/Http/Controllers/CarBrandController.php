<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use Illuminate\Http\Request;

class CarBrandController extends Controller
{
    public function __construct(CarBrand $carBrand)
    {
        $this->carBrand = $carBrand; 
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carBrands = $this->carBrand->all();
        return response()->json($carBrands, 200);
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
        $carBrand = $this->carBrand->find($id);

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

        $carBrand->update($request->all());
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

        $carBrand->delete();
        return response()->json(['msg' => 'Marca deletada com sucesso!'], 200);
    }
}
