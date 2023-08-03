<?php

namespace App\Auth;


use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;


class MockApiUserProvider extends EloquentUserProvider
{

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */

    public function retrieveByCredentials(array $credentials)
    {
        $response = Http::get('https://64c811bda1fe0128fbd59c04.mockapi.io/api/v1/datausers', [
            'email' => $credentials['email']
        ]);

        if ($response->successful() && !empty($response->json())) {

            //echo 'exito';
            $userData = $response->json()[0];

            return new ExternalUser($userData);

        }

        return null;

    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */

    public function validateCredentials(UserContract $user, array $credentials)
    {

        return Hash::check($credentials['password'], $user->userData['password']) ? true : false;

    }

    public function retrieveById($identifier)
    {
        // Lógica para obtener el usuario por su identificador desde la API externa
        $response = Http::get('https://64c811bda1fe0128fbd59c04.mockapi.io/api/v1/datausers', [
            'id' => $identifier
        ]);

        if ($response->successful() && !empty($response->json())) {

            $userData = $response->json()[0];

            return new ExternalUser($userData);

        }

        return null;
    }

}