<?php

namespace App\Controller;

use App\Service\QivivoApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    const TEMP_MIN = 5;
    const TEMP_MAX = 28;
    /**
     * @Route("/api/qivivo/setTemperature", name="qivivo_set_temperature")
     * @param Request $request
     *
     * @return Response
     */
    public function qivivoSetTemperature(Request $request)
    {
        $response = new Response();
        $api_key = $request->request->get('api_key');
        $temperature = $request->request->get('temp');
        if (
            getenv('API_KEY') == $api_key
            &&
            !empty($temperature)
        ) {
            $temperature = floatval($temperature);
            $qivivo = new QivivoApi(
                getenv('QIVIVO_USER'),
                getenv('QIVIVO_PASSWORD')
            );
            if ($temperature >= self::TEMP_MIN && $temperature <= self::TEMP_MAX) {
                $qivivo->setTemperature($temperature);
                $response->setStatusCode($response::HTTP_OK);
            } else {
                $response->setStatusCode($response::HTTP_BAD_REQUEST);
            }
        } else {
            $response->setStatusCode($response::HTTP_FORBIDDEN);
        }
        return $response;
    }
    
    /**
     * @Route("/unauthorized", name="unauthorized")
     *
     * @return Response
     */
    public function displayBadRequest()
    {
        $response = new Response();
        $response->setStatusCode($response::HTTP_FORBIDDEN);
        return $response;
    }
    
}
