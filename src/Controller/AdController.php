<?php
/**
 * Created by PhpStorm
 * User: shadowluffy
 * Date: 9/26/20
 * Time: 6:22 PM
 */

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdCreateType;
use App\Manager\AdManager;
use App\Manager\ImageManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdController
 * @package App\Controller
 *
 * @Route("/ad", name="ad_")
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class AdController extends AbstractController
{
    /**
     * @var AdManager $adManager
     */
    protected $adManager;
    /**
     * @var ImageManager $imageManger
     */
    protected $imageManger;

    public function __construct(
        AdManager $adManager,
        ImageManager $imageManager)
    {
        $this->adManager = $adManager;
        $this->imageManger = $imageManager;
    }

    /**
     * @Route("/list", name="list", methods={"GET"})
     *
     * @return Response
     */
    public function listAnnouncements()
    {
        $ads = $this->adManager->getAll();

        return $this->render(
            'Ad/list.html.twig', [
                'ads' => $ads,
            ]
        );
    }

    /**
     * @Route("/{slug}/show", name="show", methods={"GET"})
     *
     * @param string $slug
     *
     * @return Response
     */
    public function showAnnouncement(string $slug)
    {
        $ad = $this->adManager->getBySlug($slug);

        return $this->render(
            'Ad/show.html.twig',
            [
                'ad' => $ad,
            ]
        );
    }

    /**
     * @Route("/create", name="create")
     *
     * @IsGranted("ROLE_USER")
     * @param Request $request
     *
     * @return Response
     */
    public function createAnnouncement(Request $request)
    {
        $ad = $this->adManager->createAnnouncement();
        $form = $this->createForm(AdCreateType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($ad->getImages() as $image) {
                $image->setAd($ad);
                $this->imageManger->save($image, false);
            }
            $ad->setAuthor($this->getUser());
            $this->adManager->save($ad);
            $this->addFlash(
                'success', "Announcement <strong>{$ad->getTitle()}</strong> created"
            );
            return $this->redirectToRoute(
                'ad_show', [
                    'slug' => $ad->getSlug()
                ]
            );
        }

        return $this->render(
            'Ad/create.html.twig', [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{slug}/edit", name="edit")
     *
     * @Security(
     *     expression="is_granted('ROLE_USER') and user === ad.getAuthor() ",
     *     message="This announcement not be written at you"
     * )
     * @param Request $request
     * @param string $slug
     * @param Ad $ad
     *
     * @return Response
     */
    public function editAnnouncement(string $slug, Request $request, Ad $ad)
    {
        $ad = $this->adManager->getBySlug($slug);
        $form = $this->createForm(AdCreateType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($ad->getImages() as $image) {
                $image->setAd($ad);
                $this->imageManger->save($image, false);
            }
            $this->adManager->save($ad);
            $this->addFlash(
                'success', "The modifications of this announcement <strong>{$ad->getTitle()}</strong> passed"
            );
            return $this->redirectToRoute(
                'ad_show', [
                    'slug' => $ad->getSlug()
                ]
            );
        }

        return $this->render('Ad/edit.html.twig', [
            'form' => $form->createView(),
            'ad' => $ad
        ]);
    }

    /**
     * @Route("/{slug}/delete", name="delete")
     *
     * @Security(expression="is_granted('ROLE_USER') and user == ad.getAuthor()")
     * @param Ad $ad
     * @param $slug
     *
     * @return Response
     */
    public function deleteAnnouncement($slug, Ad $ad)
    {
        $this->adManager->deleteAnnouncement($slug);

        $this->addFlash(
            'success',
            "The announcement <strong>{$ad->getTitle()}</strong> has been remove"
        );
        return  $this->redirectToRoute("ad_list");
    }
}