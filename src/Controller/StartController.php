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
        $item = new Item();

        $fastTaskForm = $this->createForm(ItemFastFormType::class, $item);
        $fastTaskForm->handleRequest($request);

        if ($fastTaskForm->isSubmitted() && $fastTaskForm->isValid()) {
            $item = $fastTaskForm->getData();

            $entityManager->persist($item);
            $entityManager->flush();
            return $this->redirectToRoute('app_start');
        }

        $itemForm = $this->createForm(ItemFormType::class, $item);
        $itemForm->handleRequest($request);

        if ($itemForm->isSubmitted() && $itemForm->isValid()) {
            $entityManager->persist($item);
            $entityManager->flush();
            return $this->redirectToRoute('app_start');
        }

        return $this->render('start/index.html.twig', [
            'item'         => $itemRepository->findAll(),
            'itemForm'     => $itemForm,
            'fastTaskForm' => $fastTaskForm,
        ]);
    }
}
