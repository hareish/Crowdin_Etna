<?php

namespace App\Controller;

use App\Entity\Lang;
use App\Form\LangType;
use App\Repository\LangRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/lang")
 */
class LangController extends AbstractController
{
    /**
     * @Route("/", name="app_lang_index", methods={"GET"})
     */
    public function index(LangRepository $langRepository): Response
    {
        return $this->render('lang/index.html.twig', [
            'langs' => $langRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_lang_new", methods={"GET", "POST"})
     */
    public function new(Request $request, LangRepository $langRepository): Response
    {
        $lang = new Lang();
        $form = $this->createForm(LangType::class, $lang);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $langRepository->add($lang);
            return $this->redirectToRoute('app_lang_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lang/new.html.twig', [
            'lang' => $lang,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_lang_show", methods={"GET"})
     */
    public function show(Lang $lang): Response
    {
        return $this->render('lang/show.html.twig', [
            'lang' => $lang,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_lang_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Lang $lang, LangRepository $langRepository): Response
    {
        $form = $this->createForm(LangType::class, $lang);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $langRepository->add($lang);
            return $this->redirectToRoute('app_lang_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lang/edit.html.twig', [
            'lang' => $lang,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_lang_delete", methods={"POST"})
     */
    public function delete(Request $request, Lang $lang, LangRepository $langRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lang->getId(), $request->request->get('_token'))) {
            $langRepository->remove($lang);
        }

        return $this->redirectToRoute('app_lang_index', [], Response::HTTP_SEE_OTHER);
    }
}
