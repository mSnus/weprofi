<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Moderator\BulkDestroyModerator;
use App\Http\Requests\Admin\Moderator\DestroyModerator;
use App\Http\Requests\Admin\Moderator\IndexModerator;
use App\Http\Requests\Admin\Moderator\StoreModerator;
use App\Http\Requests\Admin\Moderator\UpdateModerator;
use App\Models\Moderator;
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

class ModeratorsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexModerator $request
     * @return array|Factory|View
     */
    public function index(IndexModerator $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Moderator::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'username', 'pass', 'email', 'name', 'status'],

            // set columns to searchIn
            ['id', 'username', 'pass', 'email', 'name', 'status']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.moderator.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.moderator.create');

        return view('admin.moderator.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreModerator $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreModerator $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Moderator
        $moderator = Moderator::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/moderators'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/moderators');
    }

    /**
     * Display the specified resource.
     *
     * @param Moderator $moderator
     * @throws AuthorizationException
     * @return void
     */
    public function show(Moderator $moderator)
    {
        $this->authorize('admin.moderator.show', $moderator);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Moderator $moderator
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Moderator $moderator)
    {
        $this->authorize('admin.moderator.edit', $moderator);


        return view('admin.moderator.edit', [
            'moderator' => $moderator,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateModerator $request
     * @param Moderator $moderator
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateModerator $request, Moderator $moderator)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Moderator
        $moderator->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/moderators'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/moderators');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyModerator $request
     * @param Moderator $moderator
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyModerator $request, Moderator $moderator)
    {
        $moderator->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyModerator $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyModerator $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Moderator::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
