<?php

namespace Brackets\LaravelModuleComposerPackage\Http\Controllers;

use Brackets\CraftablePro\Queries\Filters\FuzzyFilter;
use Brackets\LaravelModuleComposerPackage\Http\Requests\Order\BulkDestroyOrderRequest;
use Brackets\LaravelModuleComposerPackage\Http\Requests\Order\CreateOrderRequest;
use Brackets\LaravelModuleComposerPackage\Http\Requests\Order\DestroyOrderRequest;
use Brackets\LaravelModuleComposerPackage\Http\Requests\Order\EditOrderRequest;
use Brackets\LaravelModuleComposerPackage\Http\Requests\Order\IndexOrderRequest;
use Brackets\LaravelModuleComposerPackage\Http\Requests\Order\StoreOrderRequest;
use Brackets\LaravelModuleComposerPackage\Http\Requests\Order\UpdateOrderRequest;
use Brackets\LaravelModuleComposerPackage\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexOrderRequest $request): Response|JsonResponse|RedirectResponse
    {
        $defaultSort = 'id';

        if (! $request->has('sort')) {
            return redirect()->route($request->route()->getName(), ['sort' => $defaultSort]);
        }

        $ordersQuery = QueryBuilder::for(Order::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new FuzzyFilter(
                    'id', 'notes', 'created_at', 'updated_at'
                )),
            ])
            ->defaultSort($defaultSort)
            ->allowedSorts('id', 'notes', 'created_at', 'updated_at');

        if ($request->wantsJson() && $request->get('bulk_select_all')) {
            return response()->json($ordersQuery->select(['id'])->pluck('id'));
        }

        $orders = $ordersQuery
            ->select('id', 'notes', 'created_at', 'updated_at')
            ->paginate($request->get('per_page'))->withQueryString();

        Session::put('orders_url', $request->fullUrl());

        return Inertia::render('Order/Index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreateOrderRequest $request): Response
    {
        return Inertia::render('Order/Create', [

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $order = Order::create($request->validated());

        return redirect()->route('craftable-pro.orders.index')->with(['message' => ___('craftable-pro', 'Operation successful')]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditOrderRequest $request, Order $order): Response
    {
        return Inertia::render('Order/Edit', [
            'order' => $order,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order): RedirectResponse
    {
        $order->update($request->validated());

        if (session('orders_url')) {
            return redirect(session('orders_url'))->with(['message' => ___('craftable-pro', 'Operation successful')]);
        }

        return redirect()->route('craftable-pro.orders.index')->with(['message' => ___('craftable-pro', 'Operation successful')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyOrderRequest $request, Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()->back()->with(['message' => ___('craftable-pro', 'Operation successful')]);
    }

    /**
     * Bulk destroy resource.
     */
    public function bulkDestroy(BulkDestroyOrderRequest $request): RedirectResponse
    {
        // Mass delete of resource
        DB::transaction(function () use ($request) {
            collect($request->validated()['ids'])
                ->chunk(1000)
                ->each(function ($bulkChunk) {
                    Order::whereIn('id', $bulkChunk)->delete();
                });
        });

        // Individual delete of resource items
        //        DB::transaction(function () use ($request) {
        //            collect($request->validated()['ids'])->each(function ($id) {
        //                Order::find($id)->delete();
        //            });
        //        });

        return redirect()->back()->with(['message' => ___('craftable-pro', 'Operation successful')]);
    }
}
