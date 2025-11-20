<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $n = $request->integer('per_page',10);
        $q = Usuario::query();
        if($email=$request->query('email')){
            $q->where('email','like',"%{$email}%");
        }else if($search=$request->query('search')){
            $q->where(function($w) use ($search){
                $w->where('nombre','like',"%{$search}%")
                ->orWhere('email','like',"%{$search}%");
            });
        }
        $result = $q->orderBy('nombre')->paginate($n);
        return response()->json($result, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usuario $usuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuario $usuario)
    {
        //
    }
}
