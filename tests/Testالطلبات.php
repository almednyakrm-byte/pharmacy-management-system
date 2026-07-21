<?php

namespace App\Tests\Controller;

use PHPUnit\Framework\TestCase;
use App\Controller\OrdersController;
use App\Repository\OrdersRepository;
use App\Service\OrdersService;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Testالطلبات extends TestCase
{
    private $ordersController;
    private $ordersRepository;
    private $ordersService;
    private $pdo;

    protected function setUp(): void
    {
        $this->ordersRepository = $this->createMock(OrdersRepository::class);
        $this->ordersService = $this->createMock(OrdersService::class);
        $this->pdo = $this->createMock(\PDO::class);
        $this->ordersController = new OrdersController($this->ordersRepository, $this->ordersService, $this->pdo);
    }

    public function testGetOrders()
    {
        $this->ordersRepository->expects($this->once())
            ->method('getAllOrders')
            ->willReturn([
                ['id' => 1, 'name' => 'Order 1'],
                ['id' => 2, 'name' => 'Order 2'],
            ]);

        $response = $this->ordersController->getOrders();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertJson($response->getContent());
    }

    public function testGetOrderById()
    {
        $this->ordersRepository->expects($this->once())
            ->method('getOrderById')
            ->with(1)
            ->willReturn(['id' => 1, 'name' => 'Order 1']);

        $response = $this->ordersController->getOrderById(1);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertJson($response->getContent());
    }

    public function testCreateOrder()
    {
        $this->ordersService->expects($this->once())
            ->method('createOrder')
            ->with(['name' => 'Order 1'])
            ->willReturn(['id' => 1, 'name' => 'Order 1']);

        $request = new Request([], [], ['name' => 'Order 1']);
        $response = $this->ordersController->createOrder($request);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertJson($response->getContent());
    }

    public function testUpdateOrder()
    {
        $this->ordersService->expects($this->once())
            ->method('updateOrder')
            ->with(1, ['name' => 'Order 1'])
            ->willReturn(['id' => 1, 'name' => 'Order 1']);

        $request = new Request([], [], ['name' => 'Order 1']);
        $response = $this->ordersController->updateOrder(1, $request);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertJson($response->getContent());
    }

    public function testDeleteOrder()
    {
        $this->ordersService->expects($this->once())
            ->method('deleteOrder')
            ->with(1)
            ->willReturn(true);

        $response = $this->ordersController->deleteOrder(1);

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testGetOrderByIdNotFound()
    {
        $this->ordersRepository->expects($this->once())
            ->method('getOrderById')
            ->with(1)
            ->willReturn(null);

        $this->expectException(NotFoundHttpException::class);

        $this->ordersController->getOrderById(1);
    }
}