<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use App\Entity\Category;
use App\Entity\Ingredient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class RecipeController extends AbstractController
{
    /**
     * @Route("/", name="recipe_index", methods={"GET"})
     */
    public function index(RecipeRepository $recipeRepository, EntityManagerInterface $em, Request $request, PaginatorInterface $paginator): Response
    {
		$q = $request->query->get('q');
		$queryBuilder = $recipeRepository->getWithSearchQueryBuilder($q);
		$pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            11 /*limit per page*/
        );
        return $this->render('recipe/index.html.twig', [
            'recipes' => $pagination,
        ]);
    }

    /**
	 * @IsGranted("ROLE_USER")
     * @Route("/recipe/new", name="recipe_new", methods={"GET","POST"})
     */
    public function new(Request $request, UploaderHelper $uploaderHelper): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
		
        if ($form->isSubmitted() && $form->isValid()) {
			$uploadedFile = $form['photoFile']->getData();
			if($uploadedFile){
				$newFilename = $uploaderHelper->uploadRecipeImage($uploadedFile);
				$recipe->setPhoto($newFilename);
			}
			
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($recipe);
            $entityManager->flush();
			$this->addFlash('success', 'Рецепт добавлен!');
            return $this->redirectToRoute('recipe_edit', ['id' => $recipe->getId(),]);
        }

        return $this->render('recipe/new.html.twig', [
            'recipe' => $recipe,
            'recipeForm' => $form->createView(),
        ]);
    }
	
    /**
     * @Route("/recipe/{id}", name="recipe_show", methods={"GET"})
     */
    public function show(Recipe $recipe): Response
    {
        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }

    /**
	 * @IsGranted("ROLE_USER")
     * @Route("/recipe/{id}/edit", name="recipe_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Recipe $recipe, UploaderHelper $uploaderHelper): Response
    {
		$em = $this->getDoctrine()->getManager();
		$originalPhases = new ArrayCollection();
		foreach ($recipe->getPhases() as $phase) {
			$originalPhases->add($phase);
		}
		$originalCompositions = new ArrayCollection();
		foreach ($recipe->getCompositions() as $composition) {
			$originalCompositions->add($composition);
		}
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
		
        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['photoFile']->getData();
			if($uploadedFile){
				$newFilename = $uploaderHelper->uploadRecipeImage($uploadedFile);
				$recipe->setPhoto($newFilename);
			}
			for($i = 0; $i < $form['phases']->getData()->count(); $i = $i+1)
			{
				$uploadFilePhase = $form['phases'][$i]['photoPhaseFile']->getData();
				if($uploadFilePhase){
					$newFilename = $uploaderHelper->uploadRecipeImage($uploadFilePhase);
					$recipe->getPhase($i)->setPhoto($newFilename);
				}
			}
			$em->persist($recipe);
			$em->flush();
			$this->addFlash('success', 'Рецепт обновлен!');
            return $this->redirectToRoute('recipe_index', [
                'id' => $recipe->getId(),
            ]);
        }

        return $this->render('recipe/edit.html.twig', [
            'recipe' => $recipe,
            'recipeForm' => $form->createView(),
        ]);
    }

    /**
	 * @IsGranted("ROLE_USER")
     * @Route("/recipe/{id}", name="recipe_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Recipe $recipe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recipe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($recipe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('recipe_index');
    }
}
