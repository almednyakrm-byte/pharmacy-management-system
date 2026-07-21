<?php

namespace App\Tests\Controller;

use App\Controller\ProductsController;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use PDO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Testالمنتجات extends TestCase
{
    private $controller;
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->controller = new ProductsController($this->pdo);
    }

    public function testGetProducts()
    {
        $this->pdo->expects($this->once())
            ->method('query')
            ->with('SELECT * FROM products')
            ->willReturn($this->createMock(\PDOStatement::class));

        $response = $this->controller->getProducts();
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPostProduct()
    {
        $product = [
            'name' => 'Product 1',
            'price' => 10.99,
        ];

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->with('INSERT INTO products (name, price) VALUES (:name, :price)')
            ->willReturn($this->createMock(\PDOStatement::class));

        $response = $this->controller->postProduct($product);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testPutProduct()
    {
        $product = [
            'id' => 1,
            'name' => 'Product 1',
            'price' => 10.99,
        ];

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->with('UPDATE products SET name = :name, price = :price WHERE id = :id')
            ->willReturn($this->createMock(\PDOStatement::class));

        $response = $this->controller->putProduct($product);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteProduct()
    {
        $id = 1;

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->with('DELETE FROM products WHERE id = :id')
            ->willReturn($this->createMock(\PDOStatement::class));

        $response = $this->controller->deleteProduct($id);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }
}


Note: This test file assumes that the `ProductsController` class has methods `getProducts`, `postProduct`, `putProduct`, and `deleteProduct` which handle the CRUD operations. The `PDO` object is mocked to simulate database interactions. The `Request` object is not used in this test file as it's not necessary for the CRUD operations.