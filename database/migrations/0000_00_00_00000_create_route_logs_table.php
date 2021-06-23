<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouteLogsTable extends Migration
{
    public function up(){
        Schema::create('route_logs', function(Blueprint $table){
            $table->id();
            $table->string('method');
            $table->string('path');
            $table->string('route_name')->nullable();
            $table->date('requested_at');
        });
    }

    public function down(){
        Schema::drop('route_logs');
    }
}