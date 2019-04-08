<?php

namespace App\Controller;

class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add']);
    }

    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success('ユーザー登録が完了しました');

                return $this->redirect(['controller' => 'Login', 'action' => 'index']);
            }
            $this->Flash->error('ユーザーの登録に失敗しました');
        }
        $this->set(compact('user'));
    }

    public function edit()
    {
        $user = $this->Users->get($this->Auth->user('id'));
        if($this->request->is('put')){
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if($this->Users->save($user)) {
                $this->Auth->setUser($user->toArray());
                $this->Flash->succsess('ユーザー更新しました');

                return $this->redirect(['controller' => 'Questions', 'action' => 'index']);
            }
            $this->Flash->error('ユーザーの更新に失敗しました');
        }
        $this->set(compact('user'));
    }

    public function password()
    {
        $user = $this->Users->newEntity();
        if($this->request->is('post')){
            $user = $this->Users->get($this->Auth->user('id'));
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if($this->Users->save($user)) {
                $this->Auth->setUser($user->toArray());
                $this->Flash->succsess('パスワードを更新しました');

                return $this->redirect(['action' => 'edit']);
            }
            $this->Flash->error('パスワードの更新に失敗しました');
        }
        $this->set(compact('user'));
    }
}
