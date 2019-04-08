<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Question extends Entity
{
  protected $_accessible = [
    'user_id' => true,
    'body' => true,
    'created' => true,
    'modified' => true
  ];
}
