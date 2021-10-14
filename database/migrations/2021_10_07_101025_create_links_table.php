<?php

use App\Types\LinkStatusType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId('user_id')
                ->constrained();

            $table->string('hash');
            $table->string('url');
            $table->string('url_hash');
            $table->string('title');
            $table->text('description');
            $table->integer('hits')->default(0); // How many times the link have been hit
            $table->string('status')->default(LinkStatusType::waiting_approval()->value);
            $table->string('cover_image')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links');
    }
}
