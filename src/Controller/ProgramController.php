<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Season;
use App\Entity\Program;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 *
* @Route("/program", name="program_")
 *
*/

class ProgramController extends AbstractController
{
    /**
     * Show all rows from Program's entity
     *
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render
        ('program/index.html.twig',
            ['programs' => $programs]
        );
    }

    /**
     * Getting a program by id
     * @Route("/{id<^[0-9]+$>}/", name="show")
     */
    public function show(Program $program): Response
    {

        if (!$program) {
            throw $this->createNotFoundException(
                'Error 404.'
            );
        }
        $programId = $program->getId();
        $seasons = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findBy(['program' => $programId]);

        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
        ]);
    }

    /**
     * @Route("/{program<\d+>}/season/{season<\d+>}", name="season_show")
     */
    public function showSeason(Program $program, Season $season): Response
    {
        $seasonId = $season->getId();
        $episodes = $this->getDoctrine()
            ->getRepository(Episode::class)
            ->findBy(['season' => $seasonId]);


        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episodes' => $episodes,
        ]);
    }

    /**
     * @Route ("/{program<\d+>}/season/{season<\d+>}/episode/{episode<\d+>}", name="episode_show")
     */
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode,


        ]);
    }
}
