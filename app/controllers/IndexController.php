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

            $sendMoney = new SendMoneyBetweenUsers($sender, $recipient, $amount);

            $result = $sendMoney->process();

            if($result === false)
            {
                foreach ($sendMoney->getErrors() as $error)
                    $this->flashSession->error($error);
            }
            else
            {
                $transaction = new Transaction();
                $transaction->setAmount($amount);
                $transaction->setRecipientId($recipient->getId());
                $transaction->setSenderId($sender->getId());

                if($transaction->save() === false)
                    foreach ($transaction->getMessages() as $message)
                        $this->flashSession->error($message->getMessage());
                else
                    $this->flashSession->success("transaction processed successfully");
            }

        }

        return $this->response->redirect("/", true);
    }

}

