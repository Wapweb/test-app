<?php

namespace TestApp\Controllers;

use TestApp\Library\SendMoneyBetweenUsers;
use TestApp\Models\Transaction;
use TestApp\Models\User;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $users = User::find();
        $this->view->setVar("users", $users);
    }

    public function addAction()
    {

        if ($this->request->isPost()) {
            $user = new User();
            $user->assign($this->request->getPost());

            if ($user->save() === false)
                foreach ($user->getMessages() as $message)
                    $this->flashSession->error($message->getMessage());
            else
                $this->flashSession->success("Entity saved successfully");

        }

        return $this->response->redirect("/", true);
    }

    public function sendAction()
    {

        if ($this->request->isPost()) {

            $sender = User::findFirst($this->request->getPost("senderId", "int", 0));
            $recipient = User::findFirst($this->request->getPost("recipientId", "int", 0));

            $amount = $this->request->getPost("amount", "float", 0);
            $transaction = new Transaction();

            $result = $sender->sendMoney($amount, $recipient, $transaction);

            if($result === false)
                foreach ($sender->getErrors() as $error)
                    $this->flashSession->error($error);
            else
                $this->flashSession->success("transaction processed successfully");

        }

        return $this->response->redirect("/", true);
    }

}

