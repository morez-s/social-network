<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

/**
 * @group Authentication
 *
 * APIs for register, login and logout
 *
 */
class AuthController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Registration
     *
	 * Registers a new user in the application.
     *
     * @bodyParam email email required Email of the user. Example: "john.brown@gmail.com"
     * @bodyParam password string required Choosen password by the user. Example: "Jbrown1234@"
     * @bodyParam password_confirmation string required Confirmation of the choosen password by the user. Example: "Jbrown1234@"
     *
	 */
    public function registration(RegistrationRequest $request)
    {
        // create user in database
        $this->userRepository->store($request->validated());

        // return response
        return prepareSuccessfulResponse(
            trans('messages.auth.successful.successful_registration')
        );
    }

    /**
     * Login
     *
	 * Log the user in the application.
     *
     * @bodyParam username string required Username or email of the user. Example: "jbrown1990"
     * @bodyParam password string required Password of the user account. Example: "Jbrown1234@"
     *
	 */
    public function login(LoginRequest $request)
    {
        // login the user
        if (
            !Auth::attempt([
                'username' => $request->input('username'),
                'password' => $request->input('password'),
            ]) and
            !Auth::attempt([
                'email' => $request->input('username'),
                'password' => $request->input('password'),
            ])
        ) {
            return prepareUnsuccessfulResponse(
                trans('messages.auth.unsuccessful.incorrect_credentials'),
                401
            );
        }

        // get the authenticated user
        $user = auth()->user();

        // check if user is not banned
        if ($user->getAttribute('is_banned')) {
            return prepareUnsuccessfulResponse(
                trans('messages.auth.unsuccessful.your_account_is_banned'),
                401
            );
        }

        // create passport token for the user
        $userInfo = [
            'username' => $user->getAttribute('username'),
            'email' => $user->getAttribute('email'),
            'token' => $user->createToken('login')->accessToken,
        ];

        // return response
        return prepareSuccessfulResponse(
            trans('messages.auth.successful.welcome_dear_user'),
            $userInfo
        );
    }
}
