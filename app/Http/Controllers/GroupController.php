<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Http\Resources\Admin\GroupResource;
class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::with(['users']);
        return GroupResource::collection($groups->get());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $group = new Group;
        $group->name = $request->input('group.name');
        $group->code = $request->input('group.code');
        $group->can_add = $request->input('group.can_add');
        $group->save();
        return new GroupResource($group);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return new GroupResource($group->loadMissing('users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $group->name = $request->input('group.name');
        $group->code = $request->input('group.code');
        $group->can_add = $request->input('group.can_add');
        $group->save();
        return new GroupResource($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return $group->id;
        return response()->json([
            'status_code' => 200,
            'message' => 'Destroyed',
          ]);
    }

    public function registration_groups()
    {
        return Group::where('can_add',1)->orderBy('code')->get();
    }
    
}
