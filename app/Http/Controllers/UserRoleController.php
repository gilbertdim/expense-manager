<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Role;

class UserRoleController extends Controller
{
    /**
     * Get all user roles
     * @return json List of roles
     */
    public function list()
    {
        return response()->json(Role::all());
    }

    /**
     * Save new or edit user role
     * @param $request Post method with id, name and description
     * @return json list of roles
     */
    public function save(Request $request)
    {
        $role = Role::firstOrNew([
            'id' => $request->input('id')
        ]);

        $role->name = $request->input('name');
        $role->description = $request->input('description');

        if(Role::where('name', $request->input('name'))
            ->where('id', '<>', $request->input('id'))
            ->count() > 0)
        {
            return response()->json([
                'message' => $request->input('name').' is already exists!'
            ]);
        }

        $role->save();

        return $this->list();
    }

    /**
     * delete user role
     * @param $request Post method with id
     * @return json list of roles
     */
    public function delete(Request $request)
    {
        $role = Role::find($request->input('id'));

        if($request->input('id'))
        {
            $role->delete();
        }
        else
        {
            return response()->json([
                'message' => $request->input('name').' is not found!'
            ]);
        }

        return $this->list();
    }
}
