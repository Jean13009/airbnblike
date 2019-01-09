<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController {
    /**
    * @Route("/user/{slug}", name="user_show")
    */
    public function index(User $user) {
        return $this->render('user/index.html.twig', [
            'user' => $user
            ]);
        }
        /**
        * @Route("/chat/{slug}", name="user_chat")
        * @IsGranted("ROLE_USER")
        */
        public function chat(User $interlocuteur, ObjectManager $manager, Request $request) {
            $user = $this->getUser();
            $message = new Message();
            
            $form = $this->createForm(MessageType::class, $message);
            $form->handleRequest($request);
            
            if($form->isSubmitted() && $form->isValid()) {
                $message->setUser($user)
                ->setmessagesRecus($interlocuteur);
                
                $manager->persist($message);
                $manager->flush();
                unset($message);
                unset($form);
                $message = new Message();
                $form = $this->createForm(MessageType::class, $message);
                return new Response('success');
            }
            
            $messages = $manager->getRepository(Message::class)->messagesA($user->getId(), $interlocuteur->getId(), 0);
            return $this->render('user/chat.html.twig', [
                'user' => $user,
                'interlocuteur' => $interlocuteur,
                'messages' => $messages,
                'form' => $form->createView()
                ]);
            }
            /**
            * @Route("/message/{slug}/{number}", name="chat_message")
            * @IsGranted("ROLE_USER")
            * 
            */
            public function message(User $interlocuteur, ObjectManager $manager, Request $request) {
                
                $user = $this->getUser();
                $messages = $manager->getRepository(Message::class)->messagesA($user->getId(), $interlocuteur->getId(), $request->get('number'));
                return $this->json($messages);
            }
            
            /**
            * 
            * @Route("/users", name="user_list")
            *
            *
            */
            public function listUser(UserRepository $repo) {
                
                $users = $repo->findAll();

                return $this->render('user/list.html.twig', [
                    'users' => $users,
                    ]);
                }
                
            }
            