<?php

namespace TestConsumer\Controller;

use CultuurNet\SearchV3\SearchClient;
use CultuurNet\SearchV3\SearchQuery;
use CultuurNet\SearchV3\Serializer\Serializer;
use GuzzleHttp\Client;
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

            $searchQueryValues = array();
            foreach ($values as $key => $searchQueryValue) {
                if (is_array($searchQueryValue)) {
                    foreach ($searchQueryValue as $arrayValue) {
                        $searchQueryValues[] = $arrayValue;
                    }
                }
                else {
                    $searchQueryValues[] = $searchQueryValue;
                }
            }

            $searchQuery = new SearchQuery(true);
            foreach ($searchQueryValues as $parameter) {
                $searchQuery->addParameter($parameter);
            }
            $queryString = str_replace('+', '%2B', $searchQuery->__toString());
            $queryString = $credentials->getEndpoint() . '/offers?apiKey=' . $credentials->getKey() . '&' . $queryString;

            $client = new Client([
                'base_uri' => $credentials->getEndpoint(),
                'timeout' => 5,
                'headers' => [
                    'X-Api-Key' => $credentials->getKey()
                ]
            ]);

            $searchClient = new SearchClient($client, new Serializer());
            $result = $searchClient->searchOffers($searchQuery);

            $session->set('queryResult', $result);
            $session->set('queryString', $queryString);

            return $this->redirectToRoute('result');
        }

        return $this->render('default/query.html.twig', array(
            'credentials' => $credentials,
            'form' => $form->createView()
        ));
    }

    public function queryResult(Request $request, SessionInterface $session)
    {
        $result = $session->get('queryResult');
        $queryString = $session->get('queryString');

        $serializer = new Serializer();
        $serializedResult = $serializer->serialize($result);

        return $this->render('default/result.html.twig', array(
            'result' => $serializedResult,
            'queryString' => $queryString
        ));
    }
}