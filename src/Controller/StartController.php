<?php

namespace App\Controller;

use App\Entity\Item;
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
        $fastItem = $this->createForm(ItemFormType::class, $item);
        $fastItem->handleRequest($request);

        if ($fastItem->isSubmitted() && $fastItem->isValid()) {
            $item = $fastItem->getData();

            $entityManager->persist($item);
            $entityManager->flush();
            return $this->redirectToRoute('app_start');
        }
        return $this->render('start/index.html.twig', [
            'fastItem' => $fastItem,
            'items'    => $itemRepository->findAll(),
        ]);
    }
}
