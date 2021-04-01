<?php

use App\Http\Controllers\{
    InventoryController,
    OperationController,
    RecipeController,
    ProductionController
    
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("/Estoque", [InventoryController::class, "index"])
        ->name("inventory.index");
Route::get("/Estoque/Novo", [InventoryController::class, "create"])
        ->name("inventory.create");
Route::get("/Estoque/Editar/{id}", [InventoryController::class, "edit"])
        ->name("inventory.edit");
Route::post("/Estoque", [InventoryController::class, "store"])
        ->name("inventory.store");
Route::delete("/Estoque", [InventoryController::class, "destroy"])
        ->name("inventory.destroy");
Route::put("/Estoque/{id}", [InventoryController::class, "update"])
        ->name("inventory.update");

Route::get("/Operacoes", [OperationController::class, "index"])
        ->name("operation.index");
Route::get("/Operacoes/Novo", [OperationController::class, "create"])
        ->name("operation.create");
Route::get("/Operacoes/Editar/{id}", [OperationController::class, "edit"])
        ->name("operation.edit");
Route::post("/Operacoes", [OperationController::class, "store"])
        ->name("operation.store");
Route::delete("/Operacoes", [OperationController::class, "destroy"])
        ->name("operation.destroy");
Route::put("/Operacoes/{id}", [OperationController::class, "update"])
        ->name("operation.update");

Route::get("/Formulas", [RecipeController::class, "index"])
        ->name("recipe.index");
Route::get("/Formulas/Novo", [RecipeController::class, "create"])
        ->name("recipe.create");
Route::get("/Formulas/Editar/{id}", [RecipeController::class, "edit"])
        ->name("recipe.edit");
Route::post("/Formulas", [RecipeController::class, "store"])
        ->name("recipe.store");
Route::delete("/Formulas", [RecipeController::class, "destroy"])
        ->name("recipe.destroy");
Route::put("/Formulas/{id}", [RecipeController::class, "update"])
        ->name("recipe.update");

Route::get("/Producoes", [ProductionController::class, "index"])
        ->name("production.index");
Route::get("/Producoes/Novo", [ProductionController::class, "create"])
        ->name("production.create");
Route::get("/Producoes/Editar/{id}", [ProductionController::class, "edit"])
        ->name("production.edit");
Route::post("/Producoes", [ProductionController::class, "store"])
        ->name("production.store");
Route::delete("/Producoes", [ProductionController::class, "destroy"])
        ->name("production.destroy");
Route::put("/Producoes/{id}", [ProductionController::class, "update"])
        ->name("production.update");