<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Repositories\CarRepository;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function __construct(Car $car)
    {
        $this->car = $car;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $carRepo = new CarRepository($this->car);

        if($request->has('model_attributes')){
            $model_attributes = $request->get('model_attributes');
            $carRepo->selectAttributesRegisterRelated('model:id,'.$model_attributes);
        } else {
            $carRepo->selectAttributesRegisterRelated('model');
        }

        if($request->has('query')){
            $carRepo->queryFilter($request->get('query'));
        }

        if($request->has('attributes')){
            $carRepo->SelectAttributes($request->get('attributes'));
        } 

        return response()->json($carRepo->getResult(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->car->rules());

        $car = $this->car->create([
            'model_id' => $request->model_id,
            'plate' => $request->plate,
            'ready' => $request->ready,
            'km' => $request->km
        ]);

        return response()->json($car, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = $this->car->with('model')->find($id);
        if($car === null) {
            return response()->json(['error' => 'Não foi possível encontrar este carro!'], 404);
        }

        return response()->json($car, 200);
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
        $car = $this->car->find($id);
        if($car === null) {
            return response()->json(['error' => 'Não foi possível atualizar esta marca!'], 404);
        }
        if($request->method() === 'PATCH') {
            $dynamicRules = array();
            //Percorre as regras definidas no Model
            foreach($car as $input => $rule) {
                //Coleta apenas as regras aplicáveis nos parametros recebidos
                if(array_key_exists($input, $request->all())){
                    $dynamicRules[$input] = $rule;
                }
            }
            $request->validate($dynamicRules);
        } else {
            $request->validate($car->rules());
        }

        $car->fill($request->all());
        $car->save();

        return response()->json($car, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = $this->car->find($id);
        if($car === null) {
            return response()->json(['error' => 'Não foi possível apagar esta marca!'], 404);
        }

        $car->delete();

        return response()->json(['msg' => 'Marca deletada com sucesso!'], 200);
    }
}
