<?php
namespace Jan\Component\Http;


use Jan\Component\Http\Exception\UploadException;

/**
 * Class UploadedFile
 * @package Jan\Component\Http
*/
class UploadedFile
{

    /* use UploadStatus; */

    const MSG_STATUS = [
        UPLOAD_ERR_OK => 'There is no error, the file uploaded with success',
        UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        UPLOAD_ERR_PARTIAL => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        UPLOAD_ERR_NO_FILE => 'No file was uploaded',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder. (From PHP 5.0.3).',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk. (From PHP 5.1.0)',
        UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload. (From PHP 5.2.0).'
    ];
    

    /**
      * The allowed file extensions
      *
      * @var array
      * $allowedExtensions = ['gif', 'jpg', 'jpeg', 'png', 'webp'];
    */
    protected $allowedExtensions = [];



    /**
     * @var array
    */
    protected $errors = [];



    /**
       * name of file
       *
       * @var string
    */
    protected $filename;



     /**
      * mime type
      *
      * @var string
     */
     protected $mimeType;


     /**
      * @var string
     */
     protected $tempFile;


     /**
      * @var int
     */
     protected $error;



     /**
      * @var int
     */
     protected $size;

     


     /**
      * @param string $filename
      * @return UploadedFile
     */
     public function setFilename(string $filename): UploadedFile
     {
        $this->filename = $filename;

        return $this;
     }



    /**
     * @return string
    */
    public function getOriginalClientFilename(): string
    {
        return basename(($this->filename));
    }


    /**
     * @return string
    */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }


    /**
     * @param string $mimeType
     * @return UploadedFile
    */
    public function setMimeType(string $mimeType): UploadedFile
    {
        $this->mimeType = $mimeType;

        return $this;
    }


    /**
     * @return string
    */
    public function getTempFile(): string
    {
        return $this->tempFile;
    }


    /**
     * @param string $tempFile
     * @return UploadedFile
    */
    public function setTempFile(string $tempFile): UploadedFile
    {
        $this->tempFile = $tempFile;

        return $this;
    }



    /**
     * @return int
    */
    public function getError(): int
    {
        return $this->error;
    }


    /**
     * @param int $error
     * @return UploadedFile
    */
    public function setError(int $error): UploadedFile
    {
        $this->error = $error;

        return $this;
    }


    /**
     * @return int
    */
    public function getSize(): int
    {
        return $this->size;
    }


    /**
     * @param int $size
     * @return UploadedFile
    */
    public function setSize(int $size): UploadedFile
    {
        $this->size = $size;

        return $this;
    }


    /**
     * @return string
    */
    public function getExtension()
    {
        $parts = explode('.', $this->filename);
        return end($parts);
    }



    /**
     * @return array
    */
    public function getAllowedExtensions(): array
    {
        return $this->allowedExtensions;
    }


    /**
     * @param array $allowedExtensions
     * @return UploadedFile
    */
    public function setAllowedExtensions(array $allowedExtensions): UploadedFile
    {
        $this->allowedExtensions = $allowedExtensions;

        return $this;
    }


    /**
     * @param string $message
     * @return UploadedFile
    */
    public function addError(string $message)
    {
         $this->errors[] = $message;

         return $this;
    }



    /**
     * @return array
    */
    public function getErrors()
    {
        return $this->errors;
    }



    /**
     * @param $target
     * @param $filename
     * @return false|string
     * @throws UploadException
    */
    public function move($target, $filename)
    {
        // !== UPLOAD_ERR_OK or !== UPLOAD_ERR_NO_FILE
        if($this->error !== UPLOAD_ERR_OK) {

             /* throw new UploadException($this->getErrorMessage($this->error), 409); */
             $this->addError(self::MSG_STATUS[$this->error] ?? '');
             return;
        }


        if(! \in_array($this->getExtension(), $this->allowedExtensions))
        {
             /*
             throw new UploadException(
                 sprintf('Extension file (%s) is not allowed!', $this->filename)
             , 409);s
             */
             $this->addError(sprintf('Extension file (%s) is not allowed!', $this->filename));
             return;
        }
       

        /*
        $filename = $newFilename ?? sha1(mt_rand()) . '_' . sha1(mt_rand());
        $filename .= '.'. $this->extension;
        */

        if(! is_dir($target))
        {
            @mkdir($target, 0777, true);
        }

        $uploadPath = rtrim($target, '/') . DIRECTORY_SEPARATOR . $filename;

        return move_uploaded_file($this->tempFile, $uploadPath);
    }
}