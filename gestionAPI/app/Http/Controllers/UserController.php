<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Auth\ExternalUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Tymon\JWTAuth\Facades\JWTAuth;

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
     *     path="/api/users/list",
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
     *                         example="FranciscoTest G"
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example="FranciscoTestg@test.cl"
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

        $users = Http::get("https://64c811bda1fe0128fbd59c04.mockapi.io/api/v1/datausers");
        
        return $users->json();
    }

    /**
     * Crear un nuevo usuario
     * @OA\Post (
     *     path="/api/users/new",
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
     *                     "name":"FranciscoTest",
     *                     "email":"fgutierrez@example.cl"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="CREATED",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="FranciscoTest G"),
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

        $dataToCreate = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => (new \DateTime())->format('Y-m-d\TH:i:s.u\Z'),
            'updated_at' => (new \DateTime())->format('Y-m-d\TH:i:s.u\Z')
        ];

        $user = new ExternalUser($dataToCreate);

        $token = JWTAuth::fromUser($user);
        $dataToCreate['token'] = $token;

        $response = Http::post("https://64c811bda1fe0128fbd59c04.mockapi.io/api/v1/datausers", $dataToCreate);

        if ($response->successful()) {
            // La solicitud fue exitosa 
            return response()->json(['message' => 'Usuario creado exitosamente','token' => $token], 201);

        } else {
            // La solicitud no fue exitosa 
            $statusCode = $response->status();
            $errorMessage = $response->body();
            return response()->json(['message' => $errorMessage,'status' => $statusCode], 500);
        }

    }



    /**
     * Mostrar la información de un usuario
     * @OA\Get (
     *     path="/api/users/{id} ",
     *     tags={"Usuarios"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="FranciscoTest G."),
     *              @OA\Property(property="email", type="string", example="fgutierrez@example.org"),
     *              @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
     *         )
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="NOT FOUND",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="ID sin resultados"),
     *          )
     *      )
     * )
     */public function show($id)
    {

        $users = Http::get("https://64c811bda1fe0128fbd59c04.mockapi.io/api/v1/datausers/{$id}");
        return $users->json();
    }

    /**
     * Actualizar la información de un usuario
     * @OA\Put (
     *     path="/api/users/me/{id}",
     *     tags={"Usuarios"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
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
     *                     "name": "FranciscoTest G Editado",
     *                     "email": "fgutierrez@test.cl"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="FranciscoTest G Editado"),
     *              @OA\Property(property="email", type="string", example="FranciscoTest G Editado"),
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

        
        $dataToUpdate = [
            'name' => $request->name,
            'email' => $request->email,
            'updated_at' => (new \DateTime())->format('Y-m-d\TH:i:s.u\Z')
        ];

        $response = Http::put("https://64c811bda1fe0128fbd59c04.mockapi.io/api/v1/datausers/{$id}", $dataToUpdate);

        if ($response->successful()) {
            // La solicitud fue exitosa 
            return response()->json(['message' => 'Usuario actualizado exitosamente'], 200);
        } else {
            // La solicitud no fue exitosa 
            $statusCode = $response->status();
            $errorMessage = $response->body();
            return response()->json(['message' => $errorMessage,'status' => $statusCode], 500);
        }

    }

    /**
     * Eliminar usuario y su información
     * @OA\Delete (
     *     path="/api/users/delete/{id}",
     *     tags={"Usuarios"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="NO CONTENT"
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="NOT FOUND"
     *      )
     * )
     */
    public function destroy($id)
    {
        $response = Http::delete("https://64c811bda1fe0128fbd59c04.mockapi.io/api/v1/datausers/{$id}");

        
        if ($response->successful()) {
            // La solicitud fue exitosa 
            return response()->json(['message' => 'Eliminacion exitosa'], 200);
        } else {
            // La solicitud no fue exitosa 
            $statusCode = $response->status();
            $errorMessage = $response->body();
            return response()->json(['message' => $errorMessage,'status' => $statusCode], 500);
        }

    }
}