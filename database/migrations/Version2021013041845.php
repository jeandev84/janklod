<?php
namespace App\Migration;


use Jan\Component\Database\Migration\Migration;
use Jan\Component\Database\Schema\BluePrint;

/**
 * Class Version2021013041845
 * @package App\Migration
*/
class Version2021013041845 extends Migration
{


    public function up()
    {
        $this->schema->create('orders', function (BluePrint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('reference');
            $table->string('courrier');
            $table->string('courrier_price');
            $table->boolean('state');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->dropIfExists('orders');
    }
}