<?php
namespace Jan\Component\FileSystem;


/**
 * Class FileSystem
 * @package Jan\Component\FileSystem
*/
class FileSystem
{

       /**
        * @var string
       */
       protected $root;



       /**
        * FileSystem constructor.
        * @param string $root
       */
       public function __construct(string $root = '')
       {
            if($root)
            {
                $this->setRoot($root);
            }
       }


       /**
        * @param string $root
       */
       public function setRoot(string $root)
       {
           $this->root = rtrim($root, '\\/');
       }


       /**
        * Generate file path
        *
        * @param $filename
        * @return string
        *
        * $this->resource(".env.local")
       */
       public function resource($filename): string
       {
           return implode(DIRECTORY_SEPARATOR, [
               $this->root,
               $this->resolvedFilename($filename)
           ]);
       }


       /**
         * Determine if file exists
         *
         * @param $filename
         * @return bool
       */
       public function exists($filename): bool
       {
            return file_exists($this->resource($filename));
       }


       /**
        * @param $maskLink
        * @return array|false
        *
        * $this->resources("/config/*.php")
       */
       public function resources($maskLink)
       {
            return glob($this->resource($maskLink));
       }


       /**
        * @param $directory
        * @return array|false
       */
       public function scan($directory)
       {
           if(is_dir($directory))
           {
               return scandir($directory);
           }
       }


       /**
        * Load file
        *
        * @param $filename
        * @return false|mixed
       */
       public function load($filename)
       {
             if(! $this->exists($filename))
             {
                 return false;
             }

             return require $this->resource($filename);
       }


       /**
        * Write into a file
        *
        * @param $filename
        * @param $content
        * @return false|int
       */
       public function write($filename, $content)
       {
            return file_put_contents($this->resource($filename), $content, FILE_APPEND);
       }



       /**
        * Read content from file
        *
        * @param $filename
        * @return false|string
       */
       public function read($filename)
       {
           return file_get_contents($this->resource($filename));
       }


       /**
         * Get basename of file
         *
         * @param $filename
        * @return string
       */
       public function nameOnly($filename): string
       {
           return basename($this->resource($filename));
       }


       /**
        * get file extension
        *
        * @param $filename
        * @return mixed|string
       */
       public function getExtension($filename): string
       {
            $parts = explode('.', $this->resource($filename));

            return end($parts);
       }


       /**
         * @param $filename
         * @return string|string[]
       */
       public function info($filename)
       {
           return pathinfo($this->resource($filename));
       }


       /**
        * Create directory
        *
        * @param $directory
        * @return bool
       */
       public function mkdir($directory): bool
       {
           $directory = $this->resource($directory);

           if(! is_dir($directory))
           {
               return @mkdir($directory, 0777, true);
           }
       }


       /**
        * Create a file
        *
        * @param $filename
        * @return bool
       */
       public function make($filename): bool
       {
           $dirname = dirname($this->resource($filename));

           if(! \is_dir($dirname))
           {
               @mkdir($dirname, 0777, true);
           }

           return touch($this->resource($filename));
       }


       /**
        * @param $filename
        * @param $replacements
        * @return string|string[]
       */
       public function replace($filename, $replacements)
       {
            $content = $this->read($filename);
            return str_replace(array_keys($replacements), $replacements, $content);
       }




       /**
        * @param $filename
        * @return array|false
       */
       public function unlink($filename)
       {
             return $this->exists($filename) ? unlink($filename) : false;
       }


       /**
         * Remove files
         *
         * @param $maskLink
       */
       public function remove($maskLink)
       {
            array_map("unlink", $this->resources($maskLink));
       }



       /**
        * @param $filename
        * @return string|string[]
       */
       protected function resolvedFilename($filename)
       {
           return str_replace(['\\', '/'],
               DIRECTORY_SEPARATOR,
               trim($filename, '\\/')
           );
       }
}