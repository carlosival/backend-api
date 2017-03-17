<?php

namespace DietaBundle\Controller;

use DietaBundle\Entity\DietaItem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Dietaitem controller.
 *
 * @Route("dietaitem")
 */
class DietaItemController extends Controller
{
    /**
     * Lists all dietaItem entities.
     *
     * @Route("/", name="dietaitem_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dietaItems = $em->getRepository('DietaBundle:DietaItem')->findAll();

        return $this->render('dietaitem/index.html.twig', array(
            'dietaItems' => $dietaItems,
        ));
    }

    /**
     * Creates a new dietaItem entity.
     *
     * @Route("/new", name="dietaitem_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $dietaItem = new Dietaitem();
        $form = $this->createForm('DietaBundle\Form\DietaItemType', $dietaItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dietaItem);
            $em->flush($dietaItem);

            return $this->redirectToRoute('dietaitem_show', array('id' => $dietaItem->getId()));
        }

        return $this->render('dietaitem/new.html.twig', array(
            'dietaItem' => $dietaItem,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a dietaItem entity.
     *
     * @Route("/{id}", name="dietaitem_show")
     * @Method("GET")
     */
    public function showAction(DietaItem $dietaItem)
    {
        $deleteForm = $this->createDeleteForm($dietaItem);

        return $this->render('dietaitem/show.html.twig', array(
            'dietaItem' => $dietaItem,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing dietaItem entity.
     *
     * @Route("/{id}/edit", name="dietaitem_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, DietaItem $dietaItem)
    {
        $deleteForm = $this->createDeleteForm($dietaItem);
        $editForm = $this->createForm('DietaBundle\Form\DietaItemType', $dietaItem);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dietaitem_edit', array('id' => $dietaItem->getId()));
        }

        return $this->render('dietaitem/edit.html.twig', array(
            'dietaItem' => $dietaItem,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a dietaItem entity.
     *
     * @Route("/{id}", name="dietaitem_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, DietaItem $dietaItem)
    {
        $form = $this->createDeleteForm($dietaItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dietaItem);
            $em->flush($dietaItem);
        }

        return $this->redirectToRoute('dietaitem_index');
    }

    /**
     * Creates a form to delete a dietaItem entity.
     *
     * @param DietaItem $dietaItem The dietaItem entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DietaItem $dietaItem)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dietaitem_delete', array('id' => $dietaItem->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
