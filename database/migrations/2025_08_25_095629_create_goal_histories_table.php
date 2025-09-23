<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('goal_histories', function (Blueprint $table) {
            $table->string('course')->nullable();
            $table->text('goals')->nullable();
            $table->text('courseExpectations')->nullable();
            $table->text('teacherExpectations')->nullable();
            $table->text('selfExpectations')->nullable();
            $table->date('dueDate')->nullable();
            $table->string('completeStatus')->nullable();
            $table->unsignedBigInteger('semester_id')->nullable()->after('user_id');
            
            // Nếu có quan hệ foreign key
            $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('goal_histories', function (Blueprint $table) {
            $table->dropForeign(['semester_id']);
            $table->dropColumn([
                'course',
                'goals',
                'courseExpectations',
                'teacherExpectations',
                'selfExpectations',
                'dueDate',
                'completeStatus',
                'semester_id'
            ]);
        });
    }
};
