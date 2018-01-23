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

            try {
                $executedQuery = $searchClient->searchOffers($searchQuery);
                $result = [
                    'success' => true,
                    'result' => $executedQuery
                ];

            } catch (\Exception $e) {
                $result = [
                    'success' => false,
                    'result' => $e->getMessage()
                ];
            }

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
        $serializedResult = $serializer->serialize($result['result']);
        $serializedResult = $this->prettyPrint($serializedResult);

        return $this->render('default/result.html.twig', array(
            'success' => $result['success'],
            'result' => $serializedResult,
            'queryString' => $queryString
        ));
    }

    private function prettyPrint( $json )
    {
        $result = '';
        $level = 0;
        $in_quotes = false;
        $in_escape = false;
        $ends_line_level = NULL;
        $json_length = strlen( $json );

        for( $i = 0; $i < $json_length; $i++ ) {
            $char = $json[$i];
            $new_line_level = NULL;
            $post = "";
            if( $ends_line_level !== NULL ) {
                $new_line_level = $ends_line_level;
                $ends_line_level = NULL;
            }
            if ( $in_escape ) {
                $in_escape = false;
            } else if( $char === '"' ) {
                $in_quotes = !$in_quotes;
            } else if( ! $in_quotes ) {
                switch( $char ) {
                    case '}': case ']':
                    $level--;
                    $ends_line_level = NULL;
                    $new_line_level = $level;
                    break;

                    case '{': case '[':
                    $level++;
                    case ',':
                        $ends_line_level = $level;
                        break;

                    case ':':
                        $post = " ";
                        break;

                    case " ": case "\t": case "\n": case "\r":
                    $char = "";
                    $ends_line_level = $new_line_level;
                    $new_line_level = NULL;
                    break;
                }
            } else if ( $char === '\\' ) {
                $in_escape = true;
            }
            if( $new_line_level !== NULL ) {
                $result .= "\n".str_repeat( "\t", $new_line_level );
            }
            $result .= $char.$post;
        }

        return $result;
    }
}