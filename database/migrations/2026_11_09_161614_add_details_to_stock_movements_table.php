<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stock_movements', function (Blueprint $table) {
            $table->foreignId('product_id')
                ->after('id')
                ->constrained()
                ->restrictOnDelete();
            $table->foreignId('supplier_id')
                ->nullable()
                ->after('product_id')
                ->constrained()
                ->nullOnDelete();
            $table->enum('type', ['in', 'out'])->after('supplier_id');
            $table->unsignedInteger('quantity')->after('type');
            $table->date('movement_date')->after('quantity');
            $table->text('note')->nullable()->after('movement_date');
            $table->string('attachment')->nullable()->after('note');
            $table->foreignId('created_by')
                ->after('attachment')
                ->constrained('users')
                ->restrictOnDelete();
            $table->index(['product_id', 'movement_date']);
            $table->index(['type', 'movement_date']);
        });
    }

    public function down(): void
    {
        Schema::table('stock_movements', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['supplier_id']);
            $table->dropForeign(['created_by']);

            $table->dropIndex(['product_id', 'movement_date']);
            $table->dropIndex(['type', 'movement_date']);

            $table->dropColumn([
                'product_id',
                'supplier_id',
                'type',
                'quantity',
                'movement_date',
                'note',
                'attachment',
                'created_by',
            ]);
        });
    }
};
