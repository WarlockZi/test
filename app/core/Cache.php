<?

namespace app\core;

class Cache {

   public function __construct() {
   }

   public  function set($key, $data, $seconds = 3600) {
      $content['data'] = $data;
      $content['end_time'] = time() + $seconds;
      $file = $_SERVER['DOCUMENT_ROOT'].'/tmp/cache/' . md5($key) . '.txt';
      if (file_put_contents($file, serialize($content))) {
         return true;
      }
      return false;
   }

   public function get($key) {
      $file = $_SERVER['DOCUMENT_ROOT'].'/tmp/cache/' . md5($key) . '.txt';
      if (file_exists($file)) {
         $content = unserialize(file_get_contents($file));
         if (time() <= $content['end_time']) {
            return $content['data'];
         }
      }
      return false;
   }

   public function delete($key) {
      $file = CACHE . '/' . md5($key) . '.txt';
      if (file_exists($file)) {
         unlink($file);
      }
   }

}
