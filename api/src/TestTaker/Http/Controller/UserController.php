<?php

namespace App\TestTaker\Http\Controller;

use App\TestTaker\Domain\User\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class UserController
 * @package App\TestTaker\Http\Controller
 */
class UserController
{
    /** @var UserService */
    private $userService;

    /** @var SerializerInterface */
    private $serializer;

    /**
     * UserController constructor.
     * @param UserService $userService
     * @param SerializerInterface $serializer
     */
    public function __construct(UserService $userService, SerializerInterface $serializer)
    {
        $this->userService = $userService;
        $this->serializer = $serializer;
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Returns users collection with pagination"
     * )
     * @SWG\Response(
     *     response=500,
     *     description="Returns error"
     * )
     * @SWG\Parameter(
     *     name="offset",
     *     in="query",
     *     type="integer",
     *     description="current offset",
     *     default="0"
     * )
     * @SWG\Parameter(
     *     name="limit",
     *     in="query",
     *     type="integer",
     *     description="limit per page"
     * )
     * @SWG\Parameter(
     *     name="filter",
     *     in="query",
     *     type="string",
     *     description="to search"
     * )
     * @SWG\Tag(name="users")
     *
     * @param Request $request
     * @param UserService $userService
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function index(Request $request): Response
    {
        $filter = $request->get('filter') === '' ? null : $request->get('filter');

        $data = $this->userService->getUserList($request->get('limit'), $request->get('offset'), $filter);

        return new Response(
            $this->serializer->serialize($data, 'json', ['groups' => ['list']]),
            Response::HTTP_OK,
            ['Content-type' => 'application/json']
        );
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Returns single user Item"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Returns not found user"
     * )
     * @SWG\Tag(name="users")
     *
     * @param string $id
     * @param UserService $userService
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function user($id): Response
    {
        $data = $this->userService->getUser($id);

        if ($data === null) {
            return new Response(
                ['success' => false, 'error' => 'User not found'],
                Response::HTTP_NOT_FOUND,
                ['Content-type' => 'application/json']
            );
        }

        return new Response(
            $this->serializer->serialize($data, 'json', ['groups' => ['user']]),
            Response::HTTP_OK,
            ['Content-type' => 'application/json']
        );
    }
}