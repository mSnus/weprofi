<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Offer\BulkDestroyOffer;
use App\Http\Requests\Admin\Offer\DestroyOffer;
use App\Http\Requests\Admin\Offer\IndexOffer;
use App\Http\Requests\Admin\Offer\StoreOffer;
use App\Http\Requests\Admin\Offer\UpdateOffer;
use App\Models\Offer;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OffersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexOffer $request
     * @return array|Factory|View
     */
    public function index(IndexOffer $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Offer::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'title', 'price', 'client', 'master', 'status', 'location', 'accepted', 'finished'],

            // set columns to searchIn
            ['id', 'title', 'descr', 'status', 'location']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.offer.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.offer.create');

        return view('admin.offer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOffer $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreOffer $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Offer
        $offer = Offer::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/offers'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/offers');
    }

    /**
     * Display the specified resource.
     *
     * @param Offer $offer
     * @throws AuthorizationException
     * @return void
     */
    public function show(Offer $offer)
    {
        $this->authorize('admin.offer.show', $offer);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Offer $offer
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Offer $offer)
    {
        $this->authorize('admin.offer.edit', $offer);


        return view('admin.offer.edit', [
            'offer' => $offer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOffer $request
     * @param Offer $offer
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateOffer $request, Offer $offer)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Offer
        $offer->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/offers'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/offers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyOffer $request
     * @param Offer $offer
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyOffer $request, Offer $offer)
    {
        $offer->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyOffer $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyOffer $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Offer::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
