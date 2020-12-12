<?php

namespace App\Http\Controllers\Admin;

use App\Models\Club;
use Illuminate\Http\Request;
use App\Http\Requests\ClubStoreRequest;
use App\Http\Requests\ClubUpdateRequest;

class ClubController extends AbstractAdminController
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Club::class);

        $search = $request->get('search', '');

        $clubs = Club::search($search)->paginate();

        return view('app.clubs.index', compact('clubs', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Club::class);

        return view('app.clubs.create');
    }

    /**
     * @param \App\Http\Requests\ClubStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClubStoreRequest $request)
    {
        $this->authorize('create', Club::class);

        $validated = $request->validated();

        $club = Club::create($validated);

        return redirect()->route('clubs.edit', $club);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Club $club
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Club $club)
    {
        $this->authorize('view', $club);

        return view('app.clubs.show', compact('club'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Club $club
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Club $club)
    {
        $this->authorize('update', $club);

        return view('app.clubs.edit', compact('club'));
    }

    /**
     * @param \App\Http\Requests\ClubUpdateRequest $request
     * @param \App\Models\Club $club
     * @return \Illuminate\Http\Response
     */
    public function update(ClubUpdateRequest $request, Club $club)
    {
        $this->authorize('update', $club);

        $validated = $request->validated();

        $club->update($validated);

        return redirect()->route('clubs.edit', $club);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Club $club
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Club $club)
    {
        $this->authorize('delete', $club);

        $club->delete();

        return redirect()->route('clubs.index');
    }
}
