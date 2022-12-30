<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSellingOrderRequest;
use App\Http\Requests\UpdateSellingOrderRequest;
use App\Http\Resources\SellingOrderResource;
use App\Models\SellingOrder;
use Illuminate\Http\Response;

class SellingOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new SellingOrderResource(SellingOrder::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSellingOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSellingOrderRequest $request)
    {
        $order = SellingOrder::create($request->validated());

        return (new SellingOrderResource($order))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SellingOrder  $sellingOrder
     * @return \Illuminate\Http\Response
     */
    public function show(SellingOrder $sellingOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSellingOrderRequest  $request
     * @param  \App\Models\SellingOrder  $sellingOrder
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSellingOrderRequest $request, SellingOrder $sellingOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SellingOrder  $sellingOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(SellingOrder $sellingOrder)
    {
        //
    }
}
