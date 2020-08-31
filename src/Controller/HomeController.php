<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form as Form;
use App\Entity as Entity;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function pools(Request $request)
    {
        $pool = $this->getDoctrine()->getRepository('App:Pool')->findAll();
        $form = $this->createForm(Form\PoolType::class,$pool[0]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {    
            $em = $this->getDoctrine()->getManager();
            $em->persist($pool[0]);
            $em->flush();        
            $this->addFlash('success', 'Pool worker data changed!');
        }
        return $this->render('pool.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/panel/network", name="network")
     */
    public function network(Request $request,ValidatorInterface $validator)
    {
     
        $config = $this->getDoctrine()->getRepository('App:Config')->findAll();
        $network = $this->getDoctrine()->getRepository('App:Network')->findAll();
        $form = $this->createForm(Form\NetworkType::class,$network[0]);
        $form->handleRequest($request);        
        if ($form->isSubmitted() && $form->isValid()) { 
            $em = $this->getDoctrine()->getManager();
            $em->persist($network[0]);
            $em->flush();

            //change machine ip address
            shell_exec("sudo ifconfig " . $config[0]->getEthName() . ' ' . $network[0]->getAddress() . ' netmask' . $network[0]->getNetwork());
            shell_exec("sudo route add default gw " . $network[0]->getGateway() . ' ' . $config[0]->getEthName());
            shell_exec("sudo cp /etc/resolv.conf /etc/resolv.orig");
            shell_exec("sudo rm /etc/resolv.conf");
            shell_exec('echo "nameserver ' . $network[0]->getDns1() . '> /etc/resolv.conf"');
            $this->addFlash('success', 'network address changed!');
        }
        return $this->render('network.html.twig', [
            'form' => $form->createView(),
            'config'=> $config
        ]);
    }

    /**
     * @Route("/panel/reboot", name="reboot")
     */
    public function reboot(Request $request)
    {
        $defaultData = ['message' => 'submit button'];
        $form = $this->createFormBuilder($defaultData)
            ->add('submit', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);        
        if ($form->isSubmitted() && $form->isValid()) { 
            //reboot system
            $this->addFlash('success', 'Rebooting... please wait!');
            shell_exec("nohup sudo -b bash -c 'sleep 5; reboot' &>/dev/null;");
        }
        return $this->render('reboot.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/panel/overview", name="overview")
     */
    public function overview()
    {
        $config = $this->getDoctrine()->getRepository('App:Config')->findAll();
        $network = $this->getDoctrine()->getRepository('App:Network')->findAll();

        return $this->render('overview.html.twig', [
            'config' => $config,
            'network' => $network
        ]);
    }
}
