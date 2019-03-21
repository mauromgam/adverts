<?php

namespace App\Http\Controllers\Api;

use App\Advert;
use App\Http\Controllers\Controller;
use App\Repositories\AdvertRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class AdvertController extends Controller
{
    /** @var AdvertRepository $advertRepository */
    protected $advertRepository;

    /** @var UserRepository $userRepository */
    protected $userRepository;

    /**
     * AdvertController constructor.
     * @param AdvertRepository $advertRepository
     */
    public function __construct(AdvertRepository $advertRepository)
    {
        $this->advertRepository = $advertRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $adverts = $this->advertRepository->getAllPaginated($request);

        return $this->sendResponse($adverts, 'Adverts returned successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate(Advert::$rules);

        $advert = Advert::create($request->all());

        if (!$advert) {
            return $this->sendError('Advert not created.');
        }

        return $this->sendResponse($advert, 'Advert created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var Advert $advert */
        $advert = $this->advertRepository->findWithoutFail($id);

        if (!$advert) {
            return $this->sendError('Advert not found.', 404);
        }

        return $this->sendResponse($advert->toDetailsArray(), 'Advert returned successfully.');
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
        $request->validate(Advert::$rules);

        /** @var Advert $advert */
        $advert = $this->advertRepository->findWithoutFail($id);

        if (!$advert) {
            return $this->sendError('Advert not found.', 404);
        }

        $advert->update($request->all());

        return $this->sendResponse($advert, 'Advert updated successfully.');
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
        /** @var Advert $advert */
        $advert = $this->advertRepository->findWithoutFail($id);

        if (!$advert) {
            return $this->sendError('Advert not found.', 404);
        }

        $advert->delete();

        return $this->sendResponse($advert, 'Advert updated successfully.');
    }
}
