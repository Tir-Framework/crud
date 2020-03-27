<?php

namespace Tir\Crud\Controllers;

use Tir\Crud\Events\DestroyEvent;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

trait DestroyTrait
{

    /**
     *  This function destroy an item
     * @return \Illuminate\Support\Facades\View index
     */
    public function destroy($id)
    {
        event(new DestroyEvent($this->name));
        $item = $this->findForDestroy($id);

        $item->delete();
        $message = trans('crud::message.item-deleted',['item'=>trans("message.item.$this->name")]); //translate message
        Session::flash('message', $message);
        return Redirect::to(route("$this->name.index"));  
    }
    

    public function restore($id){

        $item = $this->findForRestore($id);


        if ($item->restore()) {
            $message = trans('crud::message.item-restored', ['item'=>trans("message.item.$this->name")]); //translate message
            Session::flash('message', $message);
            return Redirect::back();
        } else {
            $message = trans('crud::message.problem'); //translate message
            Session::flash('error', $message);
            return Redirect::back();
        }
    }


    /**
     * This function find an object model and if permission == owner return only owner item
     * @return eloquent
     */
    public function findForDestroy($id)
    {
        $items = $this->model::findOrFail($id);
        if($this->permission == 'owner'){
            $items = $items->OnlyOwner();
        }
        return $items;
    }

        /**
     * This function find an object model and if permission == owner return only owner item
     * @return eloquent
     */
    public function findForRestore($id)
    {
        $items = $this->model::onlyTrashed()->findOrFail($id);
        if($this->permission == 'owner'){
            $items = $items->OnlyOwner();
        }
        return $items;
    }

}