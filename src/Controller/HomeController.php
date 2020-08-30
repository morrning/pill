<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form as Form;
use App\Entity as Entity;
use Symfony\Component\Form\FormError;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->redirectToRoute('dashboard');
    }

    /**
     * @Route("/panel/dashboard", name="dashboard")
     */
    public function dashboard()
    {
        return $this->render('dashboard.html.twig', [
            
        ]);
    }
    /**
     * @Route("/panel/pools", name="pools")
     */
    public function pools()
    {
        $pool = $this->getDoctrine()->getRepository('App:Pool')->findAll();
        $form = $this->createForm(Form\PoolType::class,$pool[0]);
    
        return $this->render('pool.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
