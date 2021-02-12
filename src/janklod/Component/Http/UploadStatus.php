<?php
namespace Jan\Component\Http;


/**
 * Trait UploadStatus
 * @package Jan\Component\Http
*/
trait UploadStatus
{

    /**
     * @var string[]
    */
    protected $errorMessages = [
        UPLOAD_ERR_OK => 'There is no error, the file uploaded with success',
        UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        UPLOAD_ERR_PARTIAL => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        UPLOAD_ERR_NO_FILE => 'No file was uploaded',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder. (From PHP 5.0.3).',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk. (From PHP 5.1.0)',
        UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload. (From PHP 5.2.0).'
    ];



    /**
     * @param int $code
     * @return string
    */
    public function getErrorMessage(int $code)
    {
        return $this->errorMessages[$code] ?? '';
    }
}