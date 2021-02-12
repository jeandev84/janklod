<?php
namespace Jan\Component\Debug\Exception;


use Exception;

/**
 * Class ErrorHandler
 * @package Jan\Component\Debug\Exception
 */
class ErrorHandler
{

    /** @var Exception */
    protected $exception;


    /**
     * ErrorHandler constructor.
     * @param Exception $exception
     */
    public function __construct(Exception $exception)
    {
        $this->exception = $exception;
    }


    /**
     *
   */
    public function handle()
    {

    }


    /**
     * @param Exception $e
    */
    public function log(Exception $e)
    {
        // error_log('');
        /*
        error_log($e->getMessage(), $e->getTrace(), $e->getFile(), [

        ]);
        */
    }

}