<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Info(
 *             title="API Gestión Usuarios", 
 *             version="1.0",
 *             description="API de gestión de usuarios universidad de Talca"
 * )
 *
 * @OA\Server(url="http://127.0.0.1:8000/")
 */

class UserController extends Controller
{


    /**
     * Listado de usuarios
     * @OA\Get (
     *     path="/api/users",
     *     tags={"Usuarios"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Francisco G"
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example="franciscog@test.cl"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="2023-02-23T00:09:16.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="2023-02-23T12:33:45.000000Z"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Registrar la información de un usuario
     * @OA\Post (
     *     path="/api/users",
     *     tags={"Usuarios"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "nombres":"Francisco",
     *                     "apellidos":"fgutierrez@example.cl"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="CREATED",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="Francisco G"),
     *              @OA\Property(property="email", type="string", example="fgutierrez@example.cl"),
     *              @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="UNPROCESSABLE CONTENT",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The email field is required."),
     *              @OA\Property(property="errors", type="string", example="Objeto de errores"),
     *          )
     *      )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->save();

        return response()->json(['message' => 'Usuario creado exitosamente'], 201);
    }



    /**
     * Mostrar la información de un usuario
     * @OA\Get (
     *     path="/api/users/{user} ",
     *     tags={"Usuarios"},
     *     @OA\Parameter(
     *         in="path",
     *         name="user",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="Aderson Felix"),
     *              @OA\Property(property="email", type="string", example="aliya26@example.org"),
     *              @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
     *         )
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="NOT FOUND",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\User] #id"),
     *          )
     *      )
     * )
     */public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Actualizar la información de un usuario
     * @OA\Put (
     *     path="/api/users/{user}",
     *     tags={"Usuarios"},
     *     @OA\Parameter(
     *         in="path",
     *         name="user",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "nombres": "Francisco G Editado",
     *                     "apellidos": "fgutierrez@test.cl"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="nombres", type="string", example="Francisco G Editado"),
     *              @OA\Property(property="apellidos", type="string", example="Francisco G Editado"),
     *              @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="UNPROCESSABLE CONTENT",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The email field is required."),
     *              @OA\Property(property="errors", type="string", example="Objeto de errores"),
     *          )
     *      )
     * )
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . $id,
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response()->json(['message' => 'Usuario actualizado exitosamente'], 200);
    }

    /**
     * Eliminar la información de un usuario
     * @OA\Delete (
     *     path="/api/users/{user}",
     *     tags={"Usuarios"},
     *     @OA\Parameter(
     *         in="path",
     *         name="user",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="NO CONTENT"
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="NOT FOUND",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No se pudo realizar correctamente la operación"),
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Usuario eliminado exitosamente'], 200);
    }
}