<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Expense;

class ExpenseController extends Controller
{
    /**
     * Get all user roles
     * @return json List of roles
     */
    public function list()
    {
        return response()->json(
            Expense::where('user_id', request()->user()->id)
                ->get()
                ->makeHidden([
                    'created_at', 'updated_at', 'category'
                ])
        );
    }

    /**
     * Get expense summary
     * @return json List of expense categories with sum expenses
     */
    public function summary()
    {
        return response()->json(
            Expense::where('user_id', request()->user()->id)
                ->select('category_id', DB::raw('SUM(amount) as total'))
                ->groupBy('category_id')
                ->get()
                ->makeHidden([
                    'created_at', 'updated_at', 'category', 'category_id', 'created_date'
                ])
        );        
    }

    /**
     * Save new or edit expense
     * @param $request Post method with id, category, amount and entry date
     * @return json list of expense
     */
    public function save(Request $request)
    {
        $expense = Expense::firstOrNew([
            'id' => $request->input('id')
        ]);

        $expense->category_id = $request->input('category');
        $expense->amount = $request->input('amount');
        $expense->entry_date = $request->input('entryDate');
        $expense->user_id = $request->user()->id;
        $expense->save();

        return $this->list();
    }

    /**
     * delete user expense
     * @param $request Post method with id
     * @return json list of expense
     */
    public function delete(Request $request)
    {
        $expense = Expense::find($request->input('id'));

        if($request->input('id'))
        {
            $expense->delete();
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
