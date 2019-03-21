<?php

namespace App\Http\Controllers\Api;

use App\Advert;
use App\Collections\AdvertCollection;
use App\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /** @var UserRepository $userRepository */
    protected $userRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $users = $this->userRepository->getAllPaginated($request);

        return $this->sendResponse($users, 'Users returned successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate(User::$rules);

        $user = User::create($request->all());

        if (!$user) {
            return $this->sendError('User not created.', 400, $user);
        }

        return $this->sendResponse($user, 'User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail($id);

        if (!$user) {
            return $this->sendError('User not found.', 404);
        }

        return $this->sendResponse($user->toDetailsArray(), 'User returned successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  string $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsersAdverts($userId)
    {
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail($userId);

        if (!$user) {
            return $this->sendError('User not found.', 404);
        }

        /** @var AdvertCollection $adverts */
        $adverts = $user->adverts;
        return $this->sendResponse($adverts->toBasicArray(), 'Adverts returned successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  string $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function geLatesttUsersAdvert($userId)
    {
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail($userId);

        if (!$user) {
            return $this->sendError('User not found.', 404);
        }

        /** @var Advert $advert */
        $advert = $user->adverts()
            ->orderBy('created_at', 'desc')
            ->first();
        return $this->sendResponse($advert->toDetailsArray(), "User's adverts returned successfully.");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate(User::$rules);

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail($id);

        if (!$user) {
            return $this->sendError('User not found.', 404);
        }

        $user->update($request->all());

        return $this->sendResponse($user, 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail($id);

        if (!$user) {
            return $this->sendError('User not found.', 404);
        }

        $user->delete();

        return $this->sendResponse($user, 'User updated successfully.');
    }
}
