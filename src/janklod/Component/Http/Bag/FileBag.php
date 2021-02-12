<?php
namespace Jan\Component\Http\Bag;

use Exception;
use Jan\Component\Http\Exception\BagException;
use Jan\Component\Http\UploadedFile;
use RuntimeException;



/**
 * Class FileBag
 * @package Jan\Component\Http\Bag
*/
class FileBag extends ParameterBag
{


      /**
       * FileBag constructor.
       *
       * @param array $data
      */
      public function __construct(array $data)
      {
          $mappedFiles = [];

          foreach($data as $key => $files)
          {
              $mappedFiles[$key] = $this->mappingUploadedFiles($files);
          }

          parent::__construct($mappedFiles);
      }



      /**
        * @param $files
        * @return array
      */
      protected function resolvedFiles($files)
      {
          $newFiles = [];

          foreach ($files as $index => $fileData)
          {
            $fileData = (array) $fileData;
            
            $i = 0;

            foreach ($fileData as $value)
            {
                $newFiles[$i][$index] = $value;
                $i++;
            }
         }

         return $newFiles;
      }


      /**
       * @param $files
       * @return array
      */
      protected function mappingUploadedFiles($files)
      {
        if(! $files)
        {
            return [];
        }

        // TODO REFACTORING
        $uploadedFiles = [];
        
        foreach ($this->resolvedFiles($files) as $file)
        {
            if($file['error'] === UPLOAD_ERR_NO_FILE)
            {
                return [];
            }

            $uploadedFile = new UploadedFile();
            $uploadedFile->setFilename($file['name']);
            $uploadedFile->setMimeType($file['type']);
            $uploadedFile->setTempFile($file['tmp_name']);
            $uploadedFile->setError($file['error']);
            $uploadedFile->setSize($file['size']);

            // lazy loading,  for not duplicate
            if(! \in_array($uploadedFile, $uploadedFiles))
            {
                $uploadedFiles[] = $uploadedFile;
            }
         }

         return $uploadedFiles;
      }

}


/*
https://www.php.net/manual/fr/reserved.variables.files.php
function multiple(array $_files, $top = TRUE)
{
    $files = array();
    foreach($_files as $name=>$file){
        if($top) $sub_name = $file['name'];
        else    $sub_name = $name;

        if(is_array($sub_name)){
            foreach(array_keys($sub_name) as $key){
                $files[$name][$key] = array(
                    'name'     => $file['name'][$key],
                    'type'     => $file['type'][$key],
                    'tmp_name' => $file['tmp_name'][$key],
                    'error'    => $file['error'][$key],
                    'size'     => $file['size'][$key],
                );
                $files[$name] = multiple($files[$name], FALSE);
            }
        }else{
            $files[$name] = $file;
        }
    }
    return $files;
}

print_r($_FILES);

Array
(
    [image] => Array
        (
            [name] => Array
                (
                    [0] => 400.png
                )
            [type] => Array
                (
                    [0] => image/png
                )
            [tmp_name] => Array
                (
                    [0] => /tmp/php5Wx0aJ
                )
            [error] => Array
                (
                    [0] => 0
                )
            [size] => Array
                (
                    [0] => 15726
                )
        )
)

$files = multiple($_FILES);
print_r($files);

Array
(
    [image] => Array
        (
            [0] => Array
                (
                    [name] => 400.png
                    [type] => image/png
                    [tmp_name] => /tmp/php5Wx0aJ
                    [error] => 0
                    [size] => 15726
                )
        )
)
*/
