<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRequest;
use App\Http\Requests\StoreUpdateOperationRequest;
use App\Models\Inventory;
use App\Models\Operation;
use App\Models\OperationType;
use App\Services\OperationService;
use function redirect;
use function view;

class OperationController extends Controller
{
    
    protected $service;
    
    public function __construct(OperationService $service) {
        $this->service = $service;
    }
    
    public function index()
    {
        $list = Operation::with(['operationType','inventory'])->latest()->paginate(5);
        
        return view("operation.index", ["list"=>$list]);
    }

    public function create()
    {
        $operation_types = OperationType::all();
        $items = Inventory::all();
        return view("operation.create",[
            "operation_types"=> $operation_types, 
            "items"=>$items
        ]);
    }

    public function store(StoreUpdateOperationRequest $request)
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
        $operation = Operation::find($id);
        if(!$operation){
            $message = [
                "message" => "Registro Inválido!",
                "type"=>"warning"
            ];
            return redirect()->route('operation.index')->with($message);
        }
        $operation_types = OperationType::all();
        $items = Inventory::all();
        return view("operation.edit",[
            "operation"=>$operation,
            "operation_types"=> $operation_types, 
            "items"=>$items
        ]);
    }

    public function update(StoreUpdateOperationRequest $request, $id)
    {
        
        $return = $this->service->update($request->all(), $id);
        
        $message = [
            "message" => $return["message"],
            "type"=> $return["type"]
        ];
        
        return redirect()->route($return["route"])->with($message);
        
        
    }

    public function destroy(DeleteRequest $request)
    {
        
        $return = $this->service->destroy($request->id);
        
        $message = [
            "message" => $return["message"],
            "type"=> $return["type"]
        ];
        
        return redirect()->route($return["route"])->with($message);
    }
}
