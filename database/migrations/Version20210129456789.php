<?php
namespace App\Migration;


use Jan\Component\Database\Migration\Migration;
use Jan\Component\Database\Schema\BluePrint;


/**
 * Class Version20210129456789
 * @package App\Migration
*/
class Version20210129456789 extends Migration
{

    public function up()
    {
        $this->schema->create('products', function (BluePrint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->string('price', 30);
            // $table->float('price');
        });
    }

    public function down()
    {
        $this->schema->dropIfExists('products');
    }
}