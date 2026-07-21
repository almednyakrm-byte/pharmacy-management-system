<?php

namespace App\Tests\Controller;

use PHPUnit\Framework\TestCase;
use App\Controller\TeamController;
use App\Repository\TeamRepository;
use App\Entity\Team;
use App\Service\TeamService;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Testالطاقم extends TestCase
{
    private $teamController;
    private $teamRepository;
    private $teamService;
    private $pdoMock;

    protected function setUp(): void
    {
        $this->pdoMock = $this->createMock(\PDO::class);
        $this->teamRepository = $this->createMock(TeamRepository::class);
        $this->teamService = $this->createMock(TeamService::class);
        $this->teamController = new TeamController($this->teamRepository, $this->teamService);
    }

    public function testGetTeams(): void
    {
        $expectedResponse = ['teams' => []];
        $this->teamRepository->expects($this->once())
            ->method('findAll')
            ->willReturn($expectedResponse);
        $response = $this->teamController->getTeams();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($expectedResponse, json_decode($response->getContent(), true));
    }

    public function testGetTeam(): void
    {
        $team = new Team();
        $team->setId(1);
        $team->setName('Team 1');
        $expectedResponse = ['team' => $team->toArray()];
        $this->teamRepository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($team);
        $response = $this->teamController->getTeam(1);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($expectedResponse, json_decode($response->getContent(), true));
    }

    public function testCreateTeam(): void
    {
        $team = new Team();
        $team->setName('Team 1');
        $expectedResponse = ['team' => $team->toArray()];
        $this->teamService->expects($this->once())
            ->method('createTeam')
            ->with($team)
            ->willReturn($team);
        $request = new Request();
        $request->request->set('name', 'Team 1');
        $response = $this->teamController->createTeam($request);
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals($expectedResponse, json_decode($response->getContent(), true));
    }

    public function testUpdateTeam(): void
    {
        $team = new Team();
        $team->setId(1);
        $team->setName('Team 1');
        $expectedResponse = ['team' => $team->toArray()];
        $this->teamRepository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($team);
        $this->teamService->expects($this->once())
            ->method('updateTeam')
            ->with($team)
            ->willReturn($team);
        $request = new Request();
        $request->request->set('name', 'Team 1');
        $response = $this->teamController->updateTeam(1, $request);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($expectedResponse, json_decode($response->getContent(), true));
    }

    public function testDeleteTeam(): void
    {
        $team = new Team();
        $team->setId(1);
        $this->teamRepository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($team);
        $this->teamService->expects($this->once())
            ->method('deleteTeam')
            ->with($team);
        $response = $this->teamController->deleteTeam(1);
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testDeleteTeamNotFound(): void
    {
        $this->expectException(NotFoundHttpException::class);
        $this->teamRepository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn(null);
        $this->teamController->deleteTeam(1);
    }
}