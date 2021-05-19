<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Master\BulkDestroyMaster;
use App\Http\Requests\Admin\Master\DestroyMaster;
use App\Http\Requests\Admin\Master\IndexMaster;
use App\Http\Requests\Admin\Master\StoreMaster;
use App\Http\Requests\Admin\Master\UpdateMaster;
use App\Models\Master;
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

class MastersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexMaster $request
     * @return array|Factory|View
     */
    public function index(IndexMaster $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Master::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'userid', 'title', 'status', 'score'],

            // set columns to searchIn
            ['id', 'title', 'descr', 'status']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.master.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.master.create');

        return view('admin.master.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMaster $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreMaster $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Master
        $master = Master::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/masters'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/masters');
    }

    /**
     * Display the specified resource.
     *
     * @param Master $master
     * @throws AuthorizationException
     * @return void
     */
    public function show(Master $master)
    {
        $this->authorize('admin.master.show', $master);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Master $master
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Master $master)
    {
        $this->authorize('admin.master.edit', $master);


        return view('admin.master.edit', [
            'master' => $master,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMaster $request
     * @param Master $master
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateMaster $request, Master $master)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Master
        $master->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/masters'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/masters');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyMaster $request
     * @param Master $master
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyMaster $request, Master $master)
    {
        $master->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyMaster $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyMaster $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Master::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
