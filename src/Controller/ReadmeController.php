<?php

namespace App\Controller;

use cebe\markdown\GithubMarkdown;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReadmeController extends AbstractController
{
    #[Route('/readme', name: 'readme')]
    public function index(GithubMarkdown $parser): Response
    {
        $content = file_get_contents('./../README.md'); // récupère le contenu du README
        // dd($content);

        $parsedContent = $parser->parse($content);
        // dd($parsedContent);

        return $this->render('readme/index.html.twig', [
            'content' => $parsedContent
        ]);
    }
}
