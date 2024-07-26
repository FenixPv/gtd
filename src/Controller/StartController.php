<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\ItemFastFormType;
use App\Form\ItemFormType;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StartController extends AbstractController
{
    #[Route('/', name: 'app_start')]
    public function index(
        Request                $request,
        EntityManagerInterface $entityManager,
        ItemRepository         $itemRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $fastTask = new Item();
        $fastTaskForm = $this->createForm(ItemFastFormType::class, $fastTask);
        $fastTaskForm->handleRequest($request);

        if ($fastTaskForm->isSubmitted() && $fastTaskForm->isValid()) {
            $fastTask = $fastTaskForm->getData();

            $entityManager->persist($fastTask);
            $entityManager->flush();
            return $this->redirectToRoute('app_start');
        }
        return $this->render('start/index.html.twig', [
            'fastTaskForm' => $fastTaskForm,
            'item'         => $itemRepository->findAll(),
        ]);
    }
}
