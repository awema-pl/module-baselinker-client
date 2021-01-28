
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaselinkerClientAccountsTable extends Migration
{
    public function up()
    {
        Schema::create(config('baselinker-client.database.tables.baselinker_client_accounts'), function (Blueprint $table) {
            $table->id();
            $table->string('email')->index()->nullable();
            $table->text('api_token')->nullable();
            $table->timestamps();
        });
        
        Schema::table(config('baselinker-client.database.tables.baselinker_client_accounts'), function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained(config('baselinker-client.database.tables.users'))
                ->onDelete('cascade');
        });

        Schema::table(config('baselinker-client.database.tables.baselinker_client_accounts'), function (Blueprint $table) {
            $table->unique(['user_id', 'email']);
        });

    }

    public function down()
    {
        Schema::table(config('baselinker-client.database.tables.baselinker_client_accounts'), function (Blueprint $table) {
            $table->dropUnique(['user_id', 'email']);
            $table->dropForeign(['user_id']);
        });

        Schema::drop(config('baselinker-client.database.tables.baselinker_client_accounts'));
    }
}
