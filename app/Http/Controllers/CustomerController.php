<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customerRepo = new CustomerRepository($this->customer);

        if($request->has('query')){
            $customerRepo->queryFilter($request->get('query'));
        }

        if($request->has('attributes')){
            $customerRepo->SelectAttributes($request->get('attributes'));
        } 

        return response()->json($customerRepo->getResult(), 200);
    }


    /**
     * Store a newly created resource in storage.
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->customer->rules());

        $customer = $this->customer->create([
            'name' => $request->name
        ]);

        return response()->json($customer, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = $this->customer->with('model')->find($id);
        if($customer === null) {
            return response()->json(['error' => 'Não foi possível encontrar este carro!'], 404);
        }

        return response()->json($customer, 200);
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
        $customer = $this->customer->find($id);
        if($customer === null) {
            return response()->json(['error' => 'Não foi possível atualizar esta marca!'], 404);
        }
        if($request->method() === 'PATCH') {
            $dynamicRules = array();
            //Percorre as regras definidas no Model
            foreach($customer as $input => $rule) {
                //Coleta apenas as regras aplicáveis nos parametros recebidos
                if(array_key_exists($input, $request->all())){
                    $dynamicRules[$input] = $rule;
                }
            }
            $request->validate($dynamicRules);
        } else {
            $request->validate($customer->rules());
        }

        $customer->fill($request->all());
        $customer->save();

        return response()->json($customer, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = $this->customer->find($id);
        if($customer === null) {
            return response()->json(['error' => 'Não foi possível apagar esta marca!'], 404);
        }

        $customer->delete();

        return response()->json(['msg' => 'Cliente deletado com sucesso!'], 200);
    }
}
