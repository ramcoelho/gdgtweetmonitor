<?php

namespace GDG\Model;

class TweetBucket implements BucketInterface
{
   protected $data;

   public function __construct()
   {
      $this->data = [ ];
   }

   public function fill($result)
   {
      foreach ($result as $key => $tweet) {
         $iso_date = date('Y-m-d H:i:s', strtotime($tweet[ 'created_at' ]));
         $this->data[ $iso_date . '|' . $tweet[ 'id' ] ] = (object) [
             'author'    => (object) [
                 'name'        => $tweet[ 'user' ][ 'name' ],
                 'screen_name' => $tweet[ 'user' ][ 'screen_name' ],
                 'picture'     => str_replace('_normal', '', $tweet[ 'user' ][ 'profile_image_url' ])
             ],
             'text'      => $tweet[ 'text' ],
             'timestamp' => $iso_date,
             'id'        => '' . $tweet[ 'id' ]
         ];
      }
   }

   public function getJSON()
   {
      ksort($this->data);

      return json_encode(array_values($this->data));
   }

   public function count()
   {
      return count($this->data);
   }
}
