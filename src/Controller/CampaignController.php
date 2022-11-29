<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\Donation;
use App\Form\CampaignType;
use App\Form\DonationType;
use App\Repository\CampaignRepository;
use App\Repository\DonationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/campaign')]
class CampaignController extends AbstractController
{

    #[Route('/new', name: 'app_campaign_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CampaignRepository $campaignRepository): Response
    {
        $campaign = new Campaign();
        $form = $this->createForm(CampaignType::class, $campaign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $campaignRepository->save($campaign, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('campaign/new.html.twig', [
            'campaign' => $campaign,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_campaign_show', methods: ['GET'])]
    public function show(Campaign $campaign): Response
    {
        return $this->render('campaign/show.html.twig', [
            'campaign' => $campaign,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_campaign_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Campaign $campaign, CampaignRepository $campaignRepository): Response
    {
        $form = $this->createForm(CampaignType::class, $campaign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $campaignRepository->save($campaign, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('campaign/edit.html.twig', [
            'campaign' => $campaign,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_campaign_delete', methods: ['POST'])]
    public function delete(Request $request, Campaign $campaign, CampaignRepository $campaignRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$campaign->getId(), $request->request->get('_token'))) {
            foreach ($campaign->getDonation() as $donation){
                $donation->setCampaign(null);
            }
            $campaignRepository->remove($campaign, true);
        }

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/donation', name: 'app_campaign_donation', methods: ['GET', 'POST'])]
    public function donation(Request $request, Campaign $campaign, DonationRepository $donationRepository): Response
    {
        $donation = new Donation();
        $form = $this->createForm(DonationType::class, $donation);
        $form->handleRequest($request);
        $donation->setCreatedAt(new \DateTimeImmutable());
        $donation->setHonored(false);
        $donation->setUser($this->getUser());

        if ($form->isSubmitted() && $form->isValid()) {
            $donation->setCampaign($campaign);
            $donationRepository->save($donation,true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('campaign/donation.html.twig', [
            'campaign' => $campaign,
            'form' => $form,
            'donation'=>$donation,
        ]);
    }
}
