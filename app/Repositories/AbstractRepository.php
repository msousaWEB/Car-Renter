<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository {

    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function selectAttributesRegisterRelated($attributes) {
        $this->model = $this->model->with($attributes);
    }

    public function selectAttributes($attributes) {

        $this->model = $this->model->selectRaw($attributes);
    }

    public function queryFilter($query) {
        $query = explode(';', $query);

        foreach($query as $key => $q) {

            $querys = explode(':', $q);
            $this->model = $this->model->where($querys[0], $querys[1], $querys[2]);

        }
    }

    public function getResult() {
        return $this->model->get();
    }

    public function getPaginatedResult($pages) {
        return $this->model->paginate($pages);
    }
}

?>