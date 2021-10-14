<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\ExpenseCategory;

class CreateExpenseCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('description', 100);
            $table->timestamps();
        });

        ExpenseCategory::insert(
            array(
                array(
                    'name' => 'Travel',
                    'description' => 'daily compute',
                    'created_at' => now()
                ),
                array(
                    'name' => 'Entertainment',
                    'description' => 'movies etc.',
                    'created_at' => now()
                )
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expense_categories');
    }
}
