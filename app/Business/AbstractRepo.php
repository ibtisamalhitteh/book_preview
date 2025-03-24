<?php

namespace App\Business;

use Illuminate\Support\Facades\DB;

abstract class AbstractRepo
{
    /**
     * Validate the attributes.
     *
     * @param  AbstractModel $model
     * @param  array $attributes
     * @return array
     */
    abstract protected function validate($model, $attributes);

    /**
     * Store the given entity
     *
     * @param  AbstractModel $model
     * @param  array $attributes
     * @return mixed
     */
    abstract protected function store($model, $attributes);

    /**
     * Delete the given entity.
     *
     * @param  AbstractModel $model
     * @return void
     */
    abstract public function delete($model);

    /**
     * Save old entity.
     *
     * @param  AbstractModel $model
     * @param  array $attributes
     * @return AbstractModel
     */
    public function save($model, $attributes)
    {
         $model->update($attributes);
         return $model;
    }

    /**
     * Save old entity.
     *
     * @param  AbstractModel $model
     * @param  array $attributes
     * @return AbstractModel
     */
    public function saveWhereColNull($model, $attributes ,$column)
    {
         $model->whereNull($column)->update($attributes);
    }

    /**
     * Save old entity.
     *
     * @param  AbstractModel $model
     * @param  array $attributes
     * @return AbstractModel
     */
    public function getWhereColNull($model ,$column)
    {
         $list = $model->whereNull($column)->get();
         return $list;
    }
    /**
     * Save old entity.
     *
     * @param  AbstractModel $model
     * @param  array $attributes
     * @return AbstractModel
     */
    public function saveWhereCol($model, $attributes ,$col1,$op ,$col2)
    {
         $model->where($col1,$op,$col2)->update($attributes);
    }

    /**
     * get list of model.
     *
     * @param  AbstractModel $model
     * @return AbstractModel
     */
    public function all($model)
    {
      
        $list = $model::orderBy('created_at', 'desc')->get(); 
        return $list;
    }

    /**
     * get list of model.
     *
     * @param  AbstractModel $model
     * @param  array $searchables 
     * @return AbstractModel
     */
    public function list($model, $searchables=null)
    { 
        if($searchables){
            foreach($searchables as $search){
                if(!isset($search['op']))
                    $model=$model->where($search['key'] , $search['value']);
                else
                     $model=$model->where($search['key'], $search['op'] , $search['value']);
            }
         $model = $model->whereNull('deleted_at');     
         $list =  $model->orderBy('created_at', 'desc')->get();
        }else{
           $list = $model->whereNull('deleted_at')->orderBy('created_at', 'desc')->get(); 
        }

        return $list;
    }

    /**
     * get list of model with pagination.
     *
     * @param  AbstractModel $model
     * @param  array $searchables 
     * @return AbstractModel
     */
    public function paginationList($model, $searchables=null)
    {
        if($searchables){
            foreach($searchables as $search){
                $model = $model->where($search['key'] , $search['op'], $search['value']);
            }
            
         $model = $model->whereNull('deleted_at');   
         $list =  $model->orderBy('created_at', 'desc')->paginate(10) ;
        }else{
           $list = $model->whereNull('deleted_at')->orderBy('created_at', 'desc')->paginate(10) ;
        }

        return $list;
    }


    /**
     * Create a new entity.
     *
     * @param  AbstractModel $model
     * @param  array $attributes
     * @return AbstractModel
     */
    public function create($model, $attributes)
    {
       // $model->create($attributes);
        return $this->update($model, $attributes);
    }

    /**
     * Update an existing entity.
     *
     * @param  AbstractModel $model
     * @param  array $attributes
     * @return AbstractModel
     */
    public function update($model, $attributes)
    {
        $data = $this->validate($model, $attributes);

        DB::transaction(function () use ($model, $data) {
            $this->store($model, $data);
        });

        $this->afterStorage($model);

        return $model->fresh();
    }

    /**
     * Run after storage
     *
     * @param  AbstractModel $model
     */
    public function afterStorage($model)
    {
        //
    }

    /**
     * Restore an entity.
     *
     * @param  AbstractModel $model
     * @throws \Exception
     */
    public function restore($model)
    {
        $model->restore();
    }

    /**
     * get an entity.
     *
     * @param  AbstractModel $model
     * @throws \Exception
     */
    public function get($model , $searchables=null)
    {
        if($searchables){
            foreach($searchables as $search){
                $model = $model->where($search['key'] , $search['op'], $search['value']);
            }
            
         $model = $model->whereNull('deleted_at');   
         $model =  $model->first() ;
        }else{
           $model = $model->whereNull('deleted_at')->first() ;
        }

        return $model;
    }

}
