<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $contactos = Contacto::all();
            if (count($contactos) <= 0 ) {
                return response()->json([
                    "status" => "ok",
                    "message" => "No hay contactos"
                ], 200);
            }
            $array = array();
            foreach ($contactos as $contacto) {
                $objectContacto = new \stdClass();
                $objectContacto->contacto_id = $contacto->id;
                $objectContacto->full_name = $contacto->full_name;
                $objectContacto->email = $contacto->email; //mail
                $objectContacto->message = $contacto->message;
                $objectContacto->localtion_lati = $contacto->localtion_lati;
                $objectContacto->localtion_lagi = $contacto->localtion_lagi;
                array_push($array, $objectContacto);
            }
            return response()->json([
                "status" => "ok",
                "message" => "contactos obtenidos con exito",
                "contactos" => $array,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "ok",
                "message" => "Ocurrio un error al consultar los contactos",
                "error" => $th->getMessage(),
                "line" => $th->getLine(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            if (empty($request->full_name) || empty($request->email) || empty($request->message)) {
                return response()->json([
                    "status" => "exists",
                    "message" => "Datos vacios"
                ], 400);
            }
            $existe_contacto = Contacto::where('email', $request->email)->exists();
            if ($existe_contacto) {
                return response()->json([
                    "status" => "exists",
                    "message" => "Este contacto ya existe"
                ], 200);
            }
            $contacto = new Contacto;
            $contacto->full_name = $request->full_name;
            $contacto->email = $request->email;
            $contacto->message = $request->message;
            $contacto->localtion_lati = $request->localtion_lati;
            $contacto->localtion_lagi = $request->localtion_lagi;
            $contacto->save();
            DB::commit();
            return response()->json([
                "status" => "ok",
                "message" => "contacto creado con exito",
                "contacto" => $contacto,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "ok",
                "message" => "Ocurrio un error al agregar el contacto",
                "error" => $th->getMessage(),
                "line" => $th->getLine(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(contacto $contacto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            if (empty($request->full_name) || empty($request->email) || empty($request->message)) {
                return response()->json([
                    "status" => "exists",
                    "message" => "Datos vacios"
                ], 400);
            } 
            $contacto = Contacto::find($request->contacto_id);

            $contacto->full_name = $request->full_name;
            $contacto->email = $request->email;
            $contacto->message = $request->message;
            $contacto->localtion_lati = $request->localtion_lati;
            $contacto->localtion_lagi = $request->localtion_lagi;
            $contacto->save();
            DB::commit();
            return response()->json([
                "status" => "ok",
                "message" => "Contacto editado con exito",
                "contacto" => $contacto,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "ok",
                "message" => "Ocurrio un error al editar el contacto",
                "error" => $th->getMessage(),
                "line" => $th->getLine(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, contacto $contacto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $contacto = Contacto::find($request->contacto_id);
            if (empty($contacto)) {
                return response()->json([
                    "status" => "ok",
                    "message" => "No existe el contacto" + $request->contacto_id,
                ], 400);
            }
            $contacto->delete();
            DB::commit();
            return response()->json([
                "status" => "ok",
                "message" => "Contacto eliminado con exito",
                "contacto" => $contacto,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "ok",
                "message" => "Ocurrio un error al eliminar el contacto",
                "error" => $th->getMessage(),
                "line" => $th->getLine(),
            ], 500);
        }
    }
}
