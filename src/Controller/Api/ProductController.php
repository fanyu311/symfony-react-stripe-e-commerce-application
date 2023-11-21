<?php

namespace App\Controller\Api;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProductController extends AbstractController
{
    #[Route('/api/products', name: 'api_get_products', methods: ['GET'])]
    // NormalizerInterface 是 Symfony 中用于标准化（Normalization）数据的接口。在 Symfony 的序列化组件中，标准化是将数据转换为标准格式的过程，通常是将复杂的数据结构（如对象或数组）转换为可以在不同系统之间传输的简单格式，比如数组或 JSON。
    public function getProducts(ProductRepository $productRepository, NormalizerInterface $normalizer): Response
    {
        $products = $productRepository->findAll();

        // grâce le normalizer on peut récupérer direct un group de products
        $serializeProducts = $normalizer->normalize($products, 'json', [
            'groups' => 'product:read'
        ]);

        // fin c'est json reponds
        return $this->json($serializeProducts);
    }
}
