<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/ingredient")
 */
class IngredientController extends AbstractController
{
    /**
     * @Route("/", name="ingredient_index", methods={"GET", "POST"})
     */
    public function index(IngredientRepository $ingredientRepository, Request $request): Response
    {
		$ingredients = $ingredientRepository->findAll();
		$ingredient = new Ingredient();
		$form = $this->createForm(IngredientType:: class, $ingredient);
		$form->handleRequest($request);
		
        if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($ingredient);
			$entityManager->flush();
			if ( $request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {   
				$response = '<tr id="tr-'.$ingredient->getId().'">
					<td>'. $ingredient->getNameIngredient() . '</td>
					<td>
						<a href="/ingredient/'.$ingredient->getId().'">
							<img class="card-img-top" alt="Thumbnail [100%x225]" style="height: 25px; width: 25px;" 
							src="/search.png">
						</a>
						<a href="/ingredient/'.$ingredient->getId().'/edit" class="js-edit-button">
							<img class="card-img-top" alt="Thumbnail [100%x225]" style="height: 25px; width: 25px;" 
							src="/document.png">
						</a>
					</td>
				</tr>';
				return new JsonResponse(['resp' => $response], 200);
			}
        }
        return $this->render('ingredient/index.html.twig', [
            'ingredients' => $ingredients,
			'ingredient' => $ingredient,
			'form' => $form->createView(),
        ]);
    }
	
	/**
     * @Route("/ajax")
     */
	public function ajaxAction(IngredientRepository $ingredientRepository, Request $request) {  
	    $ingredients = $ingredientRepository->findAll();  
		if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
		{
			$jsonData = array();  
			$idx = 0;  
			foreach($ingredients as $ingredient)
			{  
				$temp = array(
					'name' => $ingredient->getNameIngredient(), 
				);   
				$jsonData[$idx++] = $temp;  
			} 
			return new JsonResponse($jsonData); 
	    } else { 
			return $this->render('ingredient/ajax.html.twig'); 
		} 
	}
	
	/**
	* Displays a form to edit an existing teammate entity.
	*
	* @Route("/edit", name="teammate_edit")
	* @Method({"GET", "POST"})
	*/
	/*public function editAction(Request $request, Teammate $teammate)
	{
		$deleteForm = $this->createDeleteForm($teammate);
		$editForm = $this->createForm('SecnaBundle\Form\TeammateType', $teammate);
		$editForm->handleRequest($request);
		if ($editForm->isSubmitted() && $editForm->isValid()) {
			$this->getDoctrine()->getManager()->flush();
			$response = "
			<td><a href='/teammate/{$teammate->getId()}'>" . $teammate->getId() . '</a></td>
			<td>' . $teammate->getLastNameRu() . '</td>
			<td>' . $teammate->getFirstNameRu() . '</td>
			<td>' . $teammate->getMiddleNameRu() . '</td>
			<td>' . $teammate->getLastNameEn() . '</td>
			<td>' . $teammate->getFirstNameEn() . '</td>
			<td></td>
			<td></td>
			<td>
			<ul>
			<li>
			<a href="/teammate/' . $teammate->getId() . '">show</a>
			</li>
			<li>
			<p href="/teammate/' . $teammate->getId() . '/edit"  class="js-edit-
			button">edit</p>
			</li>
			</ul>
			</td>
			';
			return new JsonResponse([
			'resp' => $response
			], 200);
			//return $this->redirectToRoute('teammate_index');
		}
		return $this->render('teammate/_form.html.twig', array(
			'teammate' => $teammate,
			'edit_form' => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		));
	}*/
	
	
    /**
     * @Route("/new", name="ingredient_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ingredient);
            $entityManager->flush();
			$this->addFlash('success', 'Ингредиент добавлен!');
            return $this->redirectToRoute('ingredient_index');
        }

        return $this->render('ingredient/new.html.twig', [
            'ingredient' => $ingredient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ingredient_show", methods={"GET"})
     */
    public function show(Ingredient $ingredient): Response
    {
        return $this->render('ingredient/show.html.twig', [
            'ingredient' => $ingredient,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ingredient_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ingredient $ingredient)//:Response
    {
        $editForm = $this->createForm(IngredientType::class, $ingredient);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $response = '<td>'. $ingredient->getNameIngredient() . '</td>
					<td>
						<a href="/ingredient/'.$ingredient->getId().'">
							<img class="card-img-top" alt="Thumbnail [100%x225]" style="height: 25px; width: 25px;" 
							src="/search.png">
						</a>
						<a href="/ingredient/'.$ingredient->getId().'/edit" class="js-edit-button">
							<img class="card-img-top" alt="Thumbnail [100%x225]" style="height: 25px; width: 25px;" 
							src="/document.png">
						</a>
					</td>';
			return new JsonResponse(['resp' => $response], 200);
			//return $this->redirectToRoute('ingredient_index', [
            //    'id' => $ingredient->getId(),
            //]);
        }

        return $this->render('ingredient/edit.html.twig', [
            'ingredient' => $ingredient,
            'form' => $editForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ingredient_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Ingredient $ingredient): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ingredient->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ingredient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ingredient_index');
    }
}
