<?php

namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

class User extends Entity
{
  protected $_accessible = [
    'username' => true,
    'password' => true,
    'nickname' => true,
    'created' => true,
    'modified' => true
  ];

    /**
     * @var array JSONレスポンスなどで非表示にするプロパティ
     */
  protected $_hidden = [
    'password'
  ];

  /**
   * パスワードをハッシュ化する
   */

  protected function _setPassword($value)
  {
    if(strlen($value)) {
        $hasher = new DefaultPasswordHasher();
        return $hasher->hash($value);
    }
  }
}
