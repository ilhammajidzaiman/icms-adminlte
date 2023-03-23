<?php

namespace App\Http\Controllers\Private\Developer;

use App\Models\UserMenu;
use App\Models\UserLevel;
use Illuminate\Http\Request;
use App\Models\UserAccessChild;
use App\Models\UserAccessParent;
use App\Http\Controllers\Controller;
use App\Models\UserMenuParent;

class UserAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'levels'        => UserLevel::orderBy('id')->get(),
        ];
        return view('private.user-access.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('/developer/master/access');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect('/developer/master/access');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserAccess $userAccess
     * @return \Illuminate\Http\Response
     */
    public function show(UserLevel $access)
    {
        $data = [
            'level'         => $access,
        ];
        return view('private.user-access.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserAccess $userAccess
     * @return \Illuminate\Http\Response
     */
    public function edit(UserLevel $access)
    {
        $data = [
            'level'         => $access,
            'menus'         => UserMenuParent::where('parent_id', 0)->orderBy('order')->get(),
        ];
        return view('private.user-access.update', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserAccess $userAccess
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserLevel $access)
    {
        return redirect('/developer/master/access');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserAccess $userAccess
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAccessParent $access)
    {
        return redirect('/developer/master/access');
    }

    public function updateParent($level, $parent, $order)
    {
        $userAccess = UserAccessParent::where('level_id', $level)->where('parent_id', $parent)->where('order', $order)->first();
        if ($userAccess) :
            UserAccessParent::where('level_id', $level)->where('parent_id', $parent)->where('order', $order)->delete();
        else :
            $data =
                [
                    'level_id'      => $level,
                    'parent_id'     => $parent,
                    'order'         => $order,
                ];
            UserAccessParent::create($data);
        endif;
    }

    public function updateChild($level, $parent, $child, $order)
    {
        $userChild = UserAccessChild::where('level_id', $level)->where('parent_id', $parent)->where('child_id', $child)->first();
        if ($userChild) :
            UserAccessChild::where('level_id', $level)->where('parent_id', $parent)->where('child_id', $child)->delete();
        else :
            $data =
                [
                    'level_id'      => $level,
                    'parent_id'     => $parent,
                    'child_id'      => $child,
                    'order'         => $order,
                ];
            UserAccessChild::create($data);
        endif;
    }
}
