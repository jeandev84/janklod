<?php
namespace App\Migration;


use Jan\Component\Database\Migration\Migration;
use Jan\Component\Database\Schema\BluePrint;

/**
 * Class Version20210129456789
 * @package App\Migration
*/
class Version20210130456762 extends Migration
{


    public function up()
    {
        $this->schema->create('categories', function (BluePrint $table) {
            $table->increments('id');
            $table->string('name');
        });
    }

    public function down()
    {
        $this->schema->dropIfExists('categories');
    }
}