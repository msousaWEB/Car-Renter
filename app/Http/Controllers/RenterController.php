<?php

namespace App\Http\Controllers;

use App\Models\Renter;
use App\Repositories\RenterRepository;
use Illuminate\Http\Request;

class RenterController extends Controller
{
    public function __construct(Renter $renter)
    {
        $this->renter = $renter;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $renterRepo = new RenterRepository($this->renter);

        if($request->has('query')){
            $renterRepo->queryFilter($request->get('query'));
        }

        if($request->has('attributes')){
            $renterRepo->SelectAttributes($request->get('attributes'));
        } 

        return response()->json($renterRepo->getResult(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->renter->rules());

        $renter = $this->renter->create([
            'customer_id' => $request->customer_id,
            'car_id' => $request->car_id,
            'date_initial' => $request->date_initial,
            'date_final' => $request->date_final,
            'data_final_fulfilled' => $request->data_final_fulfilled,
            'daily_rate' => $request->daily_rate,
            'km_initial' => $request->km_initial,
            'km_final' => $request->km_final,
        ]);

        return response()->json($renter, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $renter = $this->renter->find($id);
        if($renter === null) {
            return response()->json(['error' => 'Não foi possível encontrar este carro!'], 404);
        }

        return response()->json($renter, 200);
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
        $renter = $this->renter->find($id);
        if($renter === null) {
            return response()->json(['error' => 'Não foi possível atualizar esta marca!'], 404);
        }
        if($request->method() === 'PATCH') {
            $dynamicRules = array();
            //Percorre as regras definidas no Model
            foreach($renter as $input => $rule) {
                //Coleta apenas as regras aplicáveis nos parametros recebidos
                if(array_key_exists($input, $request->all())){
                    $dynamicRules[$input] = $rule;
                }
            }
            $request->validate($dynamicRules);
        } else {
            $request->validate($renter->rules());
        }

        $renter->fill($request->all());
        $renter->save();

        return response()->json($renter, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $renter = $this->renter->find($id);
        if($renter === null) {
            return response()->json(['error' => 'Não foi possível apagar esta locação!'], 404);
        }

        $renter->delete();

        return response()->json(['msg' => 'Locação deletado com sucesso!'], 200);
    }
}
