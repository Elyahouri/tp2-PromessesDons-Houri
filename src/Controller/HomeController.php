<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\User;
use App\Repository\CampaignRepository;
use App\Repository\DonationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(CampaignRepository $campaignRepository): Response
    {

        return $this->render('campaign/index.html.twig', [
            'campaigns' => $campaignRepository->findAll(),

        ]);
    }

    #[Route('/mesDons', name: 'app_user_donation')]
    public function mesDons()
    {
        if ($this->getUser()){
            return $this->render('user/mesDons.html.twig');
        }else{
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }


    }
    #[Route('/top3', name: 'app_campaign_top3')]
    public function top3(CampaignRepository $campaignRepository): Response
    {
        if ($this->getUser()) {
            $top3SommeDonation = [];
            while (count($top3SommeDonation) < 3) {
                $max = 0;
                foreach ($campaignRepository->findAll() as $cpmn) {
                    if ($cpmn->getSommeDonation() > $max && in_array($cpmn, $top3SommeDonation) == false) {
                        $topCpmn = $cpmn;
                        $max = $cpmn->getSommeDonation();
                    }
                }
                $top3SommeDonation[] = $topCpmn;
            }

            $top3txConversion = [];
            while (count($top3txConversion) < 3) {
                $max = 0;
                foreach ($campaignRepository->findAll() as $cpmn) {
                    if ($cpmn->getTauxConversion() > $max && in_array($cpmn, $top3txConversion) == false) {
                        $topCpmn = $cpmn;
                        $max = $cpmn->getTauxConversion();
                    }
                }
                $top3txConversion[] = $topCpmn;
            }

            $top3NbDons = [];
            while (count($top3NbDons) < 3) {
                $max = 0;
                foreach ($campaignRepository->findAll() as $cpmn) {
                    if ($cpmn->getNbDonations() > $max && in_array($cpmn, $top3NbDons) == false) {
                        $topCpmn = $cpmn;
                        $max = $cpmn->getNbDonations();
                    }
                }
                $top3NbDons[] = $topCpmn;
            }
            return $this->render('campaign/top3.html.twig', [
                'top3SommeDonation' => $top3SommeDonation,
                'top3TxConversion' => $top3txConversion,
                'top3NbDonation' => $top3NbDons,
            ]);

        }
        else {
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
    }


}
