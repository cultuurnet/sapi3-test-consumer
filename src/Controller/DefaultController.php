<?php

namespace TestConsumer\Controller;

use CultuurNet\SearchV3\SearchQuery;
use TestConsumer\Credentials\Credentials;
use TestConsumer\Form\CredentialsForm;
use TestConsumer\Form\QueryForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DefaultController extends Controller
{

    public function index(Request $request, SessionInterface $session)
    {
        $form = $this->createForm(CredentialsForm::class);
        $form->add('next', SubmitType::class, array(
            'label' => 'Verder',
            'attr' => array(
                'class' => 'btn btn-primary'
            )
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $credentials = new Credentials();
            $credentials->setEndPoint($form->get('endpoint')->getData());
            $credentials->setKey($form->get('key')->getData());
            $session->set('credentials', $credentials);

            return $this->redirectToRoute('search_query');
        }

        return $this->render('default/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function queryForm(Request $request, SessionInterface $session)
    {
        $credentials = $session->get('credentials');
        //$searchQuery = new SearchQuery();

        $form = $this->createForm(QueryForm::class);
        $form->add('send', SubmitType::class, array(
            'label' => 'Verzenden',
            'attr' => array(
                'class' => 'btn btn-primary'
            )
        ));


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $values = $form->getData();

            foreach ($values as $key => $value) {
                if (is_null($value)) {
                    unset($values[$key]);
                }
            }
            var_dump($values);
        }

        return $this->render('default/query.html.twig', array(
            'credentials' => $credentials,
            'form' => $form->createView()
        ));
    }
}