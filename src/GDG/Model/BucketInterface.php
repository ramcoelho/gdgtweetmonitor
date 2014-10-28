<?php

namespace GDG\Model;

interface BucketInterface
{
    public function fill($result);
    public function getJSON();
    public function count();
}
