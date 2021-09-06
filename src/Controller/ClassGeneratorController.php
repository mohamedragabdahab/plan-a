<?php

namespace App\Controller;

use App\Service\ClassGeneratorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Routing\Annotation\Route;

class ClassGeneratorController extends AbstractController
{
    private ClassGeneratorService $classGeneratorService;

    public function __construct(ClassGeneratorService $classGeneratorService)
    {
        $this->classGeneratorService = $classGeneratorService;
    }

    /**
     * @Route("/generate/class", name="generate_class")
     */
    public function generate(): Response
    {
        //Data can be provided from request object for example, for simplicity i hard coded it.
        $data = [
            'scope' => [
                'indirect-emissions-owned',
                'electricity',
            ],
            'name' => 'meeting-rooms',
        ];


        try {
            $this->classGeneratorService->generateFromArray($data);
        } catch (\Exception $exception) {
            Logger::error($exception->getMessage());
        }

        return $this->json('success!');
    }

}