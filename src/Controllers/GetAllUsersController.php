<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Interfaces\UserModelInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetUsersController extends Controller
{
    private $userModel;

    /**
     * GetUsersController constructor.
     * @param $userModel
     */
    public function __construct(UserModelInterface $userModel)
    {
        $this->userModel = $userModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        try {
            $users = $this->userModel->getAllUsers();
        } catch (\Throwable $e) {
            $data = ['success' => false,
                'message' => 'Something went wrong, please try again later',
                'data' => []];

            return $this->respondWithJson($response, $data, 500);
        }

        $message = $users ? 'All users returned' : 'There are no users in the database';

        $data = ['success' => true,
            'message' => $message,
            'data' => ['users' => $users]];

        return $this->respondWithJson($response, $data);
    }
}