<?php

namespace App\Controller;

class QuestionsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Answers');
    }

    /**
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $questions = $this->paginate($this->Questions->findQuestionsWithAnsweredCount()->contain(['Users']), [
            'order' => ['Questions.id' => 'DESC']
        ]);
        $this->set(compact('questions'));
    }

    public function add()
    {
        $question = $this->Questions->newEntity();

        if ($this->request->is('post')) {
            $question = $this->Questions->patchEntity($question, $this->request->getData());
            $question->user_id = $this->Auth->user('id');

            if ($this->Questions->save($question)) {
                $this->Flash->success('質問を投稿しました');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('質問の投稿に失敗しました');
        }

        $this->set(compact('question'));
    }

    public function view(int $id)
    {
        $question = $this->Questions->get($id, ['contain' => ['Users']]);

        $answers = $this->Answers
            ->find()
            ->where(['Answers.question_id' => $id])
            ->contain(['Users'])
            ->orderAsc('Answers.id')
            ->all();

        $newAnswer = $this->Answers->newEntity();

        $this->set(compact('question', 'answers', 'newAnswer'));
    }

    public function delete(int $id)
    {
        $this->request->allowMethod(['post']);

        $question = $this->Questions->get($id);
        if($question->user_id !== $this->Auth->user('id')){
            $this->Flash->error('他のユーザの質問を削除することはできません');
            return $this->redirect(['action' => 'index']);
        }

        if ($this->Questions->delete($question)) {
            $this->Flash->success('質問を削除しました');
        } else {
            $this->Flash->error('質問を削除に失敗しました');
        }

        return $this->redirect(['action' => 'index']);
    }
}
