<?php

namespace App\Service;
use Symfony\Component\DependencyInjection\ContainerInterface;


class TeamPointGetter
{
    private array $teams;

    /** @var ContainerInterface  */
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->teams = [];
    }

    public function getAllTeams(CurlService $curlService): array
    {
        // Curl servisi çalıştırılıp api linkinden takımlar getirildi.
        $response = $curlService->executer($this->container->getParameter('superLeagueAPIURL'));
        if ($response["success"]) {
            // Curl servisinden gelen sonuçlar json formatından bir dizi olarak döndürüldü.
            $this->teams = json_decode($response["data"], true);
        }
        return $this->teams;
    }

}