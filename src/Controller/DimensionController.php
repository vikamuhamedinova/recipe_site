<?php

namespace App\Controller;

use App\Entity\Dimension;
use App\Form\DimensionType;
use App\Repository\DimensionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/dimension")
 */
class DimensionController extends AbstractController
{
    /**
     * @Route("/", name="dimension_index", methods={"GET"})
     */
    public function index(DimensionRepository $dimensionRepository, Request $request, PaginatorInterface $paginator): Response
    {
		$dimension = new Dimension();
		$form = $this->createForm(DimensionType:: class, $dimension,
		['action' => $this->generateUrl('dimension_new_ajax'),
		'method' => 'POST',
		]);
		
        $q = $request->query->get('q');
		$queryBuilder = $dimensionRepository->getWithSearchQueryBuilder($q);
		$pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
		
		return $this->render('dimension/index.html.twig', [
            'dimensions' => $pagination,
			'dimension' => $dimension,
			'form' => $form->createView(),
        ]);
    }

	/**
	* Creates a new dimension entity.
	*
	* @Route("/new_ajax", name="dimension_new_ajax", methods={"POST"})
	*
	*/
	public function addAction(Request $request)
	{
		$dimension = new Dimension();
		$newDimensionForm = $this->createForm(DimensionType:: class, $dimension,
		['action' => $this->generateUrl('dimension_new_ajax'),
		'method' => 'POST',
		]);
		$newDimensionForm->handleRequest($request);
		if ($newDimensionForm->isSubmitted() && $newDimensionForm->isValid()) {
		$em = $this->getDoctrine()->getManager();
		$em->persist($dimension);
		$em->flush();
		$response = '<tr>
			<td>'. $dimension->getNameDimension() . '</td>
			<td>
				<a href="/{'.$dimension->getId().'}">
					<img class="card-img-top" alt="Thumbnail [100%x225]" style="height: 25px; width: 25px;" 
					src="search.png">
				</a>
				<a href="/{'.$dimension->getId().'}/edit">
					<img class="card-img-top" alt="Thumbnail [100%x225]" style="height: 25px; width: 25px;" 
					src="document.png">
				</a>
			</td>
		</tr>';
		 
		return new JsonResponse([
		'resp' => $response
		], 200);
		}
		return new JsonResponse([], 400);
	}
	
    /**
     * @Route("/new", name="dimension_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $dimension = new Dimension();
        $form = $this->createForm(DimensionType::class, $dimension);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dimension);
            $entityManager->flush();
			$this->addFlash('success', 'Еденица меры добавлена!');
            return $this->redirectToRoute('dimension_index');
        }

        return $this->render('dimension/new.html.twig', [
            'dimension' => $dimension,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dimension_show", methods={"GET"})
     */
    public function show(Dimension $dimension): Response
    {
        return $this->render('dimension/show.html.twig', [
            'dimension' => $dimension,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="dimension_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Dimension $dimension): Response
    {
        $form = $this->createForm(DimensionType::class, $dimension);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
			$this->addFlash('success', 'Еденица меры обновлена!');
            return $this->redirectToRoute('dimension_index', [
                'id' => $dimension->getId(),
            ]);
        }

        return $this->render('dimension/edit.html.twig', [
            'dimension' => $dimension,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dimension_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Dimension $dimension): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dimension->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($dimension);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dimension_index');
    }

}
