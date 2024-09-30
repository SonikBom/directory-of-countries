<?php

namespace App\Controller;
use App\Model\Country;
use App\Model\CountryScenarios;
use Exception;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;


use App\Model\Exceptions\InvalidCodeException;
use App\Model\Exceptions\CountryNotFoundException;
use App\Model\Exceptions\DuplicatedCodeException;


#[Route('api/country', name: 'app_api_country')]
class CountryController extends AbstractController
{
    public function __construct(
        private readonly CountryScenarios $country
    ) {

    }

    
    // получение всех аэропортов
    #[Route(path: '', name: 'app_api_country_root', methods: ['GET'])]
    public function getAll(Request $request): JsonResponse
    {
        
        return $this->json(data: $this->country->getAll(), status: 200);
    }

      // получение страны по коду
      #[Route(path:'/{code}', name:'app_api_country_code', methods: ['GET'])] 
      public function get(string $code): JsonResponse {
          try {
             
              return $this->json(data: $this->country->get($code));
          } catch (InvalidCodeException $ex) {
              $response = $this->buildErrorResponse(ex: $ex);
              $response->setStatusCode(code: 400);
              return $response;
          } catch (CountryNotFoundException $ex) {
              $response = $this->buildErrorResponse(ex: $ex);
              $response->setStatusCode(code: 404);
              return $response;
          }
      }

      //Добавление страны
      #[Route(path: '', name: 'app_api_country_add', methods: ['POST'])]
    public function add(Request $request, #[MapRequestPayload] Country $countries) : JsonResponse {
        try {
            $this->country->store(country: $countries);
            return $this->json(data: ['message'=>'country is added successfully'], status: 200);
        } catch (InvalidCodeException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 400);
            return $response;
        } catch (DuplicatedCodeException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 409);
            return $response;
        }
    }

    // редактирование аэропорта
    #[Route(path: '/{code}', name: 'app_api_country_edit', methods: ['PATCH'])]
    public function edit(Request $request, string $code, #[MapRequestPayload] Country $country) : JsonResponse {
        try {
            $this->country->edit(code: $code, country: $country);
            return $this->json(data: ['message'=>'country is updated successfully'], status: 200);
        } catch (InvalidCodeException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 400);
            return $response;
        } catch (CountryNotFoundException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 404);
            return $response;
        } catch (DuplicatedCodeException $ex) {
            $response = $this->buildErrorResponse(ex: $ex);
            $response->setStatusCode(code: 409);
            return $response;
        }
    }

     // удаление страны
     #[Route(path: '/{code}', name: 'app_api_airport_remove', methods: ['DELETE'])]
     public function remove(string $code) : JsonResponse {
         try {
             $this->country->delete($code);
             return $this->json(data: ['message'=>'country is removed'], status: 200);
         } catch (InvalidCodeException $ex) {
             $response = $this->buildErrorResponse(ex: $ex);
             $response->setStatusCode(code: 400);
             return $response;
         } catch (CountryNotFoundException $ex) {
             $response = $this->buildErrorResponse(ex: $ex);
             $response->setStatusCode(code: 404);
             return $response;
         }
     }
    
    // вспомогательный метод получения объекта CountryPreview
    // вспомогательный метод формирования ошибки
    private function buildErrorResponse(Exception $ex): JsonResponse {
        return $this->json(data: [
            'errorCode' => $ex->getCode(),
            'errorMessage' => $ex->getMessage(),
        ]);
    } 
}
