<?php

namespace App\Controller;

use App\Entity\Sport;
use App\Repository\SportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Наброски апи для заполнения таблицы со спортом
 * 
 * @Route("/sport")
 */
class SportController extends AbstractController
{
    /**
     * @Route("/new", name="sport_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        $name = $request->request->get('name');
        if (!$this->getDoctrine()->getRepository(Sport::class)->findOneBy(['name' => $name])) {
            $sport = new Sport();
            $sport->setName($name);
            $this->getDoctrine()->getRepository(Sport::class)->save($sport);
            return new JsonResponse(['success' => true]);
        }
        
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/{id}/edit", name="sport_edit", methods={"POST"})
     */
    public function edit(Request $request, Sport $sport): Response
    {
        $name = $request->request->get('name');
        $sport->setName($name);
        $this->getDoctrine()->getRepository(Sport::class)->update($sport);
        
        return new JsonResponse(['success' => false]);
    }
}
