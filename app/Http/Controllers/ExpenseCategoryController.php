<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;

class ExpenseCategoryController extends Controller
{
    /**
     * Get all expense categories
     * @return json List of expense categories
     */
    public function list()
    {
        return response()->json(ExpenseCategory::all());
    }

    /**
     * Save new or edit user role
     * @param $request Post method with id, name and description
     * @return json list of roles
     */
    public function save(Request $request)
    {
        $category = ExpenseCategory::firstOrNew([
            'id' => $request->input('id')
        ]);

        $category->name = $request->input('name');
        $category->description = $request->input('description');

        if(ExpenseCategory::where('name', $request->input('name'))
            ->where('id', '<>', $request->input('id'))
            ->count() > 0)
        {
            return response()->json([
                'message' => $request->input('name').' is already exists!'
            ]);
        }

        $category->save();

        return $this->list();
    }

    /**
     * delete user role
     * @param $request Post method with id
     * @return json list of roles
     */
    public function delete(Request $request)
    {
        $category = ExpenseCategory::find($request->input('id'));

        if($request->input('id'))
        {
            $category->delete();
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
