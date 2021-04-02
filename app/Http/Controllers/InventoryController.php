<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use function redirect;
use function view;

class InventoryController extends Controller
{
    
    protected $service;
    
    public function __construct(InventoryService $service) {
        $this->service = $service;
    }
    
    public function index()
    {
        $list = Inventory::paginate(5);
        return view("inventory.index", ["list"=>$list]);
    }

    public function create()
    {
        return view("inventory.create");
    }

    public function store(Request $request)
    {
        $return = $this->service->store($request->all());
        
        $message = [
            "message" => $return["message"],
            "type"=> $return["type"]
        ];
        
        return redirect()->route($return["route"])->with($message);
        
    }
    
    public function edit($id)
    {
        $item = Inventory::find($id);
        if(!$item){
            $message = [
                "message" => "Item não Encontrado!",
                "type"=>"warning"
            ];
            return redirect()->route('inventory.index')->with($message);
        }
        
        return view("inventory.edit",["item"=>$item]);
    }

    public function update(Request $request, $id)
    {
        $return = $this->service->update($request->all(), $id);
        $message = [
            "message" => $return["message"],
            "type" => $return["type"]
        ];
        
        return redirect()->route($return["route"],["id"=>$id])->with($message);
    }

    public function destroy(Request $request)
    {
        $return = $this->service->destroy($request->all());
        $message = [
            "message" => $return["message"],
            "type" => $return["type"]
        ];
        return redirect()->route($return["route"])->with($message);
    }
}
